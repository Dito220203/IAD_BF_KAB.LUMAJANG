<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        $monev = Monev::all();
        return view('admin.MonitoringEvaluasi.index', compact('monev'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subprogram = Subprogram::all();
        $rencana = RencanaKerja::all();
        $opd = Opd::all();
        return view('admin.MonitoringEvaluasi.create', compact('subprogram', 'rencana', 'opd'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_subprogram' => 'required|exists:subprograms,id',
            'id_renja' => 'nullable|exists:rencana_kerjas,id',
            'id_opd' => 'nullable|exists:opds,id',
            'lokasi' => 'nullable|string',
            'tahun' => 'nullable|string',
            'anggaran' => 'nullable|string',
            'rka' => 'required',
            'realisasi' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $validatedData['status'] = 'Belum Validasi';
        Monev::create([
            'id_pengguna' => Auth::guard('pengguna')->id(),
            'id_renja' => $validatedData['id_renja'],
            'id_subprogram' => $validatedData['id_subprogram'],
            'id_opd' => $validatedData['id_opd'],
            'lokasi' => $validatedData['lokasi'],
            'tahun' => $validatedData['tahun'],
            'anggaran' => $validatedData['anggaran'],
            'rka' => $validatedData['rka'],
            'realisasi' => $validatedData['realisasi'],
            'keterangan' => $validatedData['keterangan'],
            'status'        => $validatedData['status'], // kalau dipakai
        ]);

        return redirect()->route('monev')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function validasi(string $id)
    {
        $monev = Monev::findOrFail($id);
        $monev->status = 'Valid';
        $monev->save();

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
        $monev = Monev::findOrFail($id);

        $validatedData = $request->validate([
            'id_subprogram' => 'required|exists:subprograms,id',
            'id_renja' => 'nullable|exists:rencana_kerjas,id',
            'id_opd' => 'nullable|exists:opds,id',
            'e_lokasi' => 'nullable|string',
            'e_tahun' => 'nullable|string',
            'e_anggaran' => 'nullable|string',
            'e_rka' => 'required',
            'e_realisasi' => 'nullable|string',
            'e_keterangan' => 'nullable|string',
        ]);

        $monev->update([
            'id_pengguna' => Auth::guard('pengguna')->id(),
            'id_renja' => $validatedData['id_renja'],
            'id_subprogram' => $validatedData['id_subprogram'],
            'id_opd' => $validatedData['id_opd'],
            'lokasi' => $validatedData['e_lokasi'],
            'tahun' => $validatedData['e_tahun'],
            'anggaran' => $validatedData['e_anggaran'],
            'rka' => $validatedData['e_rka'],
            'realisasi' => $validatedData['e_realisasi'],
            'keterangan' => $validatedData['e_keterangan'],
        ]);
        return redirect()->route('monev')->with('success', 'Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Monev::where('id', $id)->delete();
        return redirect()->route('monev')->with('success', 'Data Berhasil Dihapus');
    }
}
