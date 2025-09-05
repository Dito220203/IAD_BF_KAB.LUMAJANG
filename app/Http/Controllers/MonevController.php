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

    // Filter Triwulan
    if ($request->filled('triwulan')) {
        $triwulan = $request->triwulan;

        switch ($triwulan) {
            case 1:
                $query->whereMonth('tahun', '>=', 1)->whereMonth('tahun', '<=', 3);
                break;
            case 2:
                $query->whereMonth('tahun', '>=', 4)->whereMonth('tahun', '<=', 6);
                break;
            case 3:
                $query->whereMonth('tahun', '>=', 7)->whereMonth('tahun', '<=', 9);
                break;
            case 4:
                $query->whereMonth('tahun', '>=', 10)->whereMonth('tahun', '<=', 12);
                break;
        }
    }

    // Filter Tahun
    if ($request->filled('tahun')) {
        $query->whereYear('tahun', $request->tahun);
    }

    $monev = $query->orderBy('tahun', 'desc')->paginate(10)->withQueryString();

    // Untuk dropdown tahun
    $tahun_list = Monev::selectRaw('YEAR(tahun) as tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

    return view('admin.MonitoringEvaluasi.index', compact('monev', 'tahun_list'));
}




    public function getRencana($id)
    {
        $rencana = RencanaKerja::with(['subprogram', 'opd'])->find($id);

        if (!$rencana) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'nama_program' => $rencana->subprogram->subprogram ?? '',
            'lokasi' => $rencana->lokasi ?? '',
            'tanggal' => $rencana->tanggal ?? '',
            'anggaran' => $rencana->anggaran ?? '',
            'opd' => $rencana->opd->nama ?? '',
            'opd_id' => $rencana->opd->id ?? '',
             'subprogram_id' => $rencana->id_subprogram ?? '',
        ]);
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

        $rules = [
            'id_subprogram' => 'required|exists:subprograms,id',
            'id_renja' => 'nullable|exists:rencana_kerjas,id',
            'lokasi' => 'nullable|string',
            'tahun' => 'required',
            'anggaran' => 'nullable|string',
            'rka' => 'required',
            'realisasi' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ];

        if ($user->level === 'Super Admin') {
            $rules['id_opd'] = 'required|exists:opds,id';
        }

        $validate = $request->validate($rules);

        $validate['id_pengguna'] = $user->id;

        if ($user->level !== 'Super Admin') {
            $validate['id_opd'] = $user->id_opd;
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

    // validasi sama seperti store()
    $rules = [
        'program' => 'required',
        'id_renja' => 'nullable|exists:rencana_kerjas,id',
        'lokasi' => 'nullable|string',
        'tahun' => 'required',
        'anggaran' => 'nullable|string',
        'rka' => 'required',
        'realisasi' => 'required',
        'keterangan' => 'nullable|string',
    ];

    if ($user->level === 'Super Admin') {
        $rules['id_opd'] = 'required|exists:opds,id';
    }

    $validate = $request->validate($rules);

    // mapping langsung seperti store()
    $validate['id_pengguna'] = $user->id;
    if ($user->level !== 'Super Admin') {
        $validate['id_opd'] = $user->id_opd;
    }

    $monev->update($validate);

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
