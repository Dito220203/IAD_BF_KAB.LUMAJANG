<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\Opd;
use App\Models\RencanaKerja;
use App\Models\Subprogram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class RencanakerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard('pengguna')->user();
        $user->level == 'Super Admin' ? $rencana = RencanaKerja::all() : $rencana = RencanaKerja::where('id_pengguna', $user->id)->get();
        return view('admin.RencanaKerja.index', compact('rencana'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subprogram = Subprogram::all();
        $opd = Opd::all(); // ambil semua data opd

        return view('admin.RencanaKerja.create', compact('subprogram', 'opd'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::guard('pengguna')->user();

        // validasi dasar
        $rules = [
            'subprogram' => 'required|exists:subprograms,id',
            'judul' => 'required',
            'lokasi' => 'required',
            'tanggal' => 'required',
            'anggaran' => 'required',
            'keterangan' => 'required',
        ];

        // Kalau Super Admin wajib pilih OPD
        if ($user->level === 'Super Admin') {
            $rules['id_opd'] = 'required|exists:opds,id';
        }

        $validate = $request->validate($rules);

        // mapping subprogram
        $validate['id_subprogram'] = $validate['subprogram'];
        unset($validate['subprogram']);

        // set pengguna
        $validate['id_pengguna'] = $user->id;

        // set opd otomatis kalau bukan super admin
        if ($user->level !== 'Super Admin') {
            $validate['id_opd'] = $user->id_opd; // pastikan kolom id_opd ada di tabel pengguna
        }

        $validate['status'] = 'Belum Validasi';

        RencanaKerja::create($validate);
        LogHelper::add('Menambah data Rencana Kerja');
        return redirect()->route('rencanakerja')->with('success', 'Data Berhasil Ditambahkan');
    }



    public function validasi(string $id)
    {
        $rencana = RencanaKerja::findOrFail($id);
        $rencana->status = 'Valid';
        $rencana->save();
        LogHelper::add('Memvalidasi data Rencana Kerja');
        return redirect()->route('rencanakerja')->with('success', 'Status berhasil divalidasi');
    }

    public function updateStatus(string $id)
    {
        $rencana = RencanaKerja::findOrFail($id);

        $rencana->status = $rencana->status === 'Valid' ? 'Belum Validasi' : 'Valid';
        $rencana->save();
        LogHelper::add('Mengubah status data Rencana Kerja');
        return redirect()->route('rencanakerja')->with('success', 'Status berhasil diperbarui');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rencana = RencanaKerja::with(['subprogram', 'opd'])->findOrFail($id);
        LogHelper::add('Melihat detail data Rencana Kerja');
        return view('admin.RencanaKerja.show', compact('rencana'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Ambil data rencana kerja berdasarkan ID
        $rencana = RencanaKerja::findOrFail($id);


        $subprogram = Subprogram::all();
        $opd = Opd::all();


        return view('admin.RencanaKerja.update', compact('rencana', 'subprogram', 'opd'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::guard('pengguna')->user();
        $rencana = RencanaKerja::findOrFail($id);

        // aturan validasi dasar
        $rules = [
            'e_subprogram' => 'required|exists:subprograms,id',
            'e_judul' => 'required',
            'e_lokasi' => 'required',
            'e_tanggal' => 'required',
            'e_anggaran' => 'required',
            'status' => 'nullable|string',
            'e_keterangan' => 'required',
        ];

        // kalau Super Admin wajib pilih OPD
        if ($user->level === 'Super Admin') {
            $rules['e_opd'] = 'required|exists:opds,id';
        }

        $validate = $request->validate($rules);

        // mapping data
        $data = [
            'id_subprogram' => $validate['e_subprogram'],
            'judul' => $validate['e_judul'],
            'lokasi' => $validate['e_lokasi'],
            'tanggal' => $validate['e_tanggal'],
            'anggaran' => $validate['e_anggaran'],
            'status' => $validate['status'] ?? 'Belum Validasi',
            'keterangan' => $validate['e_keterangan'],
        ];

        // set OPD sesuai role
        if ($user->level === 'Super Admin') {
            $data['id_opd'] = $validate['e_opd'];
        } else {
            $data['id_opd'] = $user->id_opd;
        }

        // update ke database
        $rencana->update($data);

        LogHelper::add('Mengubah data Rencana Kerja');
        return redirect()->route('rencanakerja')->with('success', 'Data Berhasil Diperbarui');
    }





    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rencana = RencanaKerja::findOrFail($id);

        // Hapus file dari storage kalau ada
        if ($rencana->file && Storage::disk('public')->exists($rencana->file)) {
            Storage::disk('public')->delete($rencana->file);
        }

        // Hapus data dari database
        $rencana->delete();
        LogHelper::add('Menghapus data Rencana Kerja');
        return redirect()->route('rencanakerja')->with('success', 'Data berhasil dihapus');
    }
}
