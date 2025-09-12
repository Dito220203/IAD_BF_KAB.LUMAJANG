<?php

namespace App\Http\Controllers;

use App\Exports\RencanaAksiExport;
use App\Exports\RencanaExport;
use App\Helpers\LogHelper;
use App\Models\Opd;
use App\Models\RencanaAksi_6_tahun;
use App\Models\Subprogram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class RencanaAksi_6TahunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rencanaAksi = RencanaAksi_6_tahun::paginate(10);
        return view('admin.RencanAksi6Tahun.index', compact('rencanaAksi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subprogram = Subprogram::all();
        $opds = Opd::all();
        return view('admin.RencanAksi6Tahun.create', compact('subprogram', 'opds'));
    }
    public function exportExcelAksi()
    {
        return Excel::download(new RencanaAksiExport, 'rencana_aksi.xlsx');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'sub_program' => 'required|exists:subprograms,id',
            'nama_program' => 'required',
            'rencanaAksi' => 'required',
            'kegiatan' => 'required',
            'sub_kegiatan' => 'required',
            'tahun' => 'required',
            'anggaran' => 'required',
            'sumberdana' => 'required',

            'lokasi' => 'required',
            'volume' => 'required',
            'satuan' => 'required',
            'id_opd' => 'required|exists:opds,id',
            'keterangan' => 'required'
        ]);

        RencanaAksi_6_tahun::create([
            'id_pengguna' => Auth::guard('pengguna')->id(),
            'id_subprogram'       => $validate['sub_program'],
            'rencana_aksi' => $validate['rencanaAksi'],
            'nama_program'      => $validate['nama_program'],
            'kegiatan'          => $validate['kegiatan'],
            'sub_kegiatan'      => $validate['sub_kegiatan'],
            'tahun'             => $validate['tahun'],
            'anggaran'          => $validate['anggaran'],
            'sumberdana' => $validate['sumberdana'],
            'lokasi'            => $validate['lokasi'],
            'volume' => $validate['volume'],
            'satuan' => $validate['satuan'],
            'id_opd'  => $validate['id_opd'],
            'keterangan'        => $validate['keterangan'],
        ]);
        LogHelper::add('Menambah Data Rencana Aksi');

        return redirect()->route('rencana6tahun')
            ->with('success', 'Rencana Aksi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rencanaAksi = RencanaAksi_6_tahun::findOrFail($id);
        $subprogram = Subprogram::all();
        $opds = Opd::all();
        return view('admin.RencanAksi6Tahun.update', compact('rencanaAksi', 'subprogram', 'opds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'sub_program'      => 'required|exists:subprograms,id',
            'rencanaAksi' => 'required',
            'nama_program'     => 'required',
            'kegiatan'         => 'required',
            'sub_kegiatan'     => 'required',
            'tahun'            => 'required',
            'anggaran'         => 'required',
            'sumberdana'         => 'required|string',
            'lokasi'           => 'required',
            'volume' => 'required',
            'satuan' => 'required',
            'id_opd' => 'required|exists:opds,id',
            'keterangan'       => 'required'
        ]);

        $rencanaAksi = RencanaAksi_6_tahun::findOrFail($id);

        $rencanaAksi->update([
            'id_subprogram'      => $validate['sub_program'],
            'rencana_aksi' => $validate['rencanaAksi'],
            'nama_program'     => $validate['nama_program'],
            'kegiatan'         => $validate['kegiatan'],
            'sub_kegiatan'     => $validate['sub_kegiatan'],
            'tahun'            => $validate['tahun'],
            'anggaran'         => $validate['anggaran'],
            'sumberdana'         => $validate['sumberdana'],
            'lokasi'           => $validate['lokasi'],
            'id_opd' => $validate['id_opd'],
            'volume' => $validate['volume'],
            'satuan' => $validate['satuan'],
            'keterangan'       => $validate['keterangan'],
        ]);
        LogHelper::add('Mengedit Data Rencana Aksi');
        return redirect()->route('rencana6tahun')
            ->with('success', 'Rencana Aksi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rencanaAksi = RencanaAksi_6_tahun::findOrFail($id);
        $rencanaAksi->delete();
        LogHelper::add('Menghapus Data Rencana Aksi');
        return redirect()->route('rencana6tahun')
            ->with('success', 'Rencana Aksi berhasil dihapus!');
    }
}
