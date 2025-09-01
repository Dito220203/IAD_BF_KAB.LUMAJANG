<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\Monev;
use App\Models\Notifikasi;
use App\Models\Opd;
use App\Models\Pengguna;
use App\Models\RencanaKerja;
use App\Models\Subprogram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonevController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::guard('pengguna')->user();
        $query = Monev::query();

        if ($user->level !== 'Super Admin') {
            $query->where('id_pengguna', $user->id);
        }

        if ($request->filled('triwulan')) {
            $triwulan = $request->triwulan;
            $tahun = now()->year;

            if ($triwulan == 1) {
                $query->whereBetween('created_at', ["$tahun-01-01", "$tahun-03-31"]);
            } elseif ($triwulan == 2) {
                $query->whereBetween('created_at', ["$tahun-04-01", "$tahun-06-30"]);
            } elseif ($triwulan == 3) {
                $query->whereBetween('created_at', ["$tahun-07-01", "$tahun-09-30"]);
            } elseif ($triwulan == 4) {
                $query->whereBetween('created_at', ["$tahun-10-01", "$tahun-12-31"]);
            }
        }

        $monev = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.MonitoringEvaluasi.index', compact('monev'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::guard('pengguna')->user();
        $subprogram = Subprogram::all();
        $opd = Opd::all();
        $user->level == 'Super Admin' ? $rencana = RencanaKerja::all() : $rencana = RencanaKerja::where('id_pengguna', $user->id)->get();
        return view('admin.MonitoringEvaluasi.create', compact('subprogram', 'rencana', 'opd'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::guard('pengguna')->user();

        // validasi dasar
        $rules = [
            'id_subprogram' => 'required|exists:subprograms,id',
            'id_renja' => 'nullable|exists:rencana_kerjas,id',
            'lokasi' => 'nullable|string',
            'tahun' => 'nullable|string',
            'anggaran' => 'nullable|string',
            'rka' => 'required',
            'realisasi' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ];

        // Kalau Super Admin wajib pilih OPD
        if ($user->level === 'Super Admin') {
            $rules['id_opd'] = 'required|exists:opds,id';
        }

        $validate = $request->validate($rules);

        // set pengguna
        $validate['id_pengguna'] = $user->id;

        // set opd otomatis kalau bukan super admin
        if ($user->level !== 'Super Admin') {
            $validate['id_opd'] = $user->id_opd; // pastikan tabel pengguna ada kolom id_opd
        }

        $validate['status'] = 'Belum Validasi';

        Monev::create($validate);

        LogHelper::add('Menambah data Monev');
        return redirect()->route('monev')->with('success', 'Data Berhasil Ditambahkan');
    }


    public function validasi(string $id)
    {
        $monev = Monev::findOrFail($id);
        $monev->status = 'Valid';
        $monev->save();
        LogHelper::add('Memvalidasi data Monev');
        return redirect()->route('monev')->with('success', 'Status berhasil divalidasi');
    }

    public function updateStatus(string $id)
    {
        $monev = Monev::findOrFail($id);

        // ganti status progres
        if ($monev->status === 'Valid') {
            $monev->status = 'Belum Validasi';
        } else {
            $monev->status = 'Valid';
        }
        $monev->save();
        LogHelper::add('Mengubah status data Monev');
        return redirect()->route('monev')->with('success', 'Status berhasil diperbarui');
    }

    /**
     * Display the specified resource.
     */


    public function show(string $id)
    {
        $monev = Monev::findOrFail($id);
        $subprogram = Subprogram::all();
        $rencana = RencanaKerja::all();
        $opd = Opd::all();
        LogHelper::add('Melihat detail data Monev');
        return view('admin.MonitoringEvaluasi.show', compact('monev', 'subprogram', 'rencana', 'opd'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $monev = Monev::findOrFail($id);
        $subprogram = Subprogram::all();
        $rencana = RencanaKerja::all();
        $opd = Opd::all();

        return view('admin.MonitoringEvaluasi.update', compact('monev', 'subprogram', 'rencana', 'opd'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::guard('pengguna')->user();
        $monev = Monev::findOrFail($id);

        // aturan validasi dasar
        $rules = [
            'id_subprogram' => 'required|exists:subprograms,id',
            'id_renja' => 'nullable|exists:rencana_kerjas,id',
            'e_lokasi' => 'nullable|string',
            'e_tahun' => 'nullable|string',
            'e_anggaran' => 'nullable|string',
            'e_rka' => 'required',
            'e_realisasi' => 'nullable|string',
            'e_keterangan' => 'nullable|string',
        ];

        // kalau Super Admin wajib pilih OPD
        if ($user->level === 'Super Admin') {
            $rules['id_opd'] = 'required|exists:opds,id';
        }

        $validate = $request->validate($rules);

        // mapping data
        $data = [
            'id_pengguna' => $user->id,
            'id_renja' => $validate['id_renja'] ?? null,
            'id_subprogram' => $validate['id_subprogram'],
            'lokasi' => $validate['e_lokasi'],
            'tahun' => $validate['e_tahun'],
            'anggaran' => $validate['e_anggaran'],
            'rka' => $validate['e_rka'],
            'realisasi' => $validate['e_realisasi'],
            'keterangan' => $validate['e_keterangan'],
        ];

        // set OPD sesuai role
        if ($user->level === 'Super Admin') {
            $data['id_opd'] = $validate['id_opd'];
        } else {
            $data['id_opd'] = $user->id_opd;
        }

        $monev->update($data);

        LogHelper::add('Mengupdate data Monev');
        return redirect()->route('monev')->with('success', 'Data Berhasil Diupdate');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Monev::where('id', $id)->delete();
        LogHelper::add('Menghapus data Monev');
        return redirect()->route('monev')->with('success', 'Data Berhasil Dihapus');
    }
}
