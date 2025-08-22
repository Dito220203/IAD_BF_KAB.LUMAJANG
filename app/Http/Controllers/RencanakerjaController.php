<?php

namespace App\Http\Controllers;

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
        $rencana = RencanaKerja::all();
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
        $validate = $request->validate([
            'subprogram' => 'required|exists:subprograms,id', // sesuaikan nama input
            'id_opd'     => 'required|exists:opds,id',
            'judul' => 'required',
            'lokasi' => 'required',
            'tahun' => 'required',
            'anggaran' => 'required',
            'keterangan' => 'required',
        ]);


        $validate['id_subprogram'] = $validate['subprogram'];
        unset($validate['subprogram']);

        $validate['id_pengguna'] = Auth::guard('pengguna')->id();

        $validate['status'] = 'Belum Validasi';

        RencanaKerja::create($validate);

        return redirect()->route('rencanakerja')->with('success', 'Data Berhasil Ditambahkan');
    }


    public function validasi(string $id)
    {
        $rencana = RencanaKerja::findOrFail($id);
        $rencana->status = 'Valid';
        $rencana->save();

        return redirect()->route('rencanakerja')->with('success', 'Status berhasil divalidasi');
    }

    public function updateStatus(string $id)
    {
        $rencana = RencanaKerja::findOrFail($id);

        $rencana->status = $rencana->status === 'Valid' ? 'Belum Validasi' : 'Valid';
        $rencana->save();

        return redirect()->route('rencanakerja')->with('success', 'Status berhasil diperbarui');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
// Ambil data rencana kerja beserta relasi subprogram dan opd
    $rencana = RencanaKerja::with(['subprogram', 'opd'])->findOrFail($id);

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
        $rencana = RencanaKerja::findOrFail($id);

        // Validasi input
        $request->validate([
            'e_subprogram' => 'required|exists:subprograms,id',
            'e_opd' => 'required|exists:opds,id',
            'e_judul' => 'required',
            'e_lokasi' => 'required',
            'e_tahun' => 'required',
            'e_anggaran' => 'required',
            'status' => 'nullable|string',
             'e_keterangan' => 'required',
        ]);

        // Data yang akan diupdate
        $data = [
            'id_subprogram' => $request->input('e_subprogram'),
            'id_opd' => $request->input('e_opd'),
            'judul' => $request->input('e_judul'),
            'lokasi' => $request->input('e_lokasi'),
            'tahun' => $request->input('e_tahun'),
            'anggaran' => $request->input('e_anggaran'),
            'status' => $request->input('status', 'Belum Validasi'),
             'keterangan' => $request->input('e_keterangan'),
        ];

        // Update ke database
        $rencana->update($data);

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

        return redirect()->route('rencanakerja')->with('success', 'Data berhasil dihapus');
    }
}
