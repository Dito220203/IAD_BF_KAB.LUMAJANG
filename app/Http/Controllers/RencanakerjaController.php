<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\Opd;
use App\Models\RencanaAksi_6_tahun;
use App\Models\RencanaKerja;
use App\Models\Subprogram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RencanaExport;

class RencanakerjaController extends Controller
{
    public function index()
    {
        $user = Auth::guard('pengguna')->user();
        $rencana = $user->level == 'Super Admin'
            ? RencanaKerja::paginate(10)
            : RencanaKerja::where('id_pengguna', $user->id)->paginate(10);

        return view('admin.RencanaKerja.index', compact('rencana'));
    }

    public function getRencanaAksi($id_subprogram)
    {
        $rencanaAksi = RencanaAksi_6_tahun::where('id_subprogram', $id_subprogram)->get();

        return response()->json($rencanaAksi);
    }


    public function create()
    {
        $subprogram = Subprogram::all();
        $opd = Opd::all();
        $rencanaAksi = RencanaAksi_6_tahun::all();

        return view('admin.RencanaKerja.create', compact('subprogram', 'opd', 'rencanaAksi'));
    }
    public function exportExcel()
    {
        $user = Auth::guard('pengguna')->user();

        return Excel::download(new RencanaExport($user), 'rencana_kerja.xlsx');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'id_subprogram'  => 'required|exists:subprograms,id',
            'rencanaAksi' => 'required|exists:rencana_aksi_6_tahuns,id',
            'sub_kegiatan'   => 'required|string',
            'kegiatan'       => 'required|string',
            'nama_program' => 'required|string',
            'tahun'          => 'required',
            'volume' => 'required',
            'satuan' => 'required',
            'anggaran'       => 'required',
            'sumberdana' => 'required',
            'lokasi'         => 'required|string',
            'id_opd'         => 'required|exists:opds,id',
            'keterangan'     => 'required|string'
        ]);

        RencanaKerja::create([
            'id_pengguna'      => Auth::guard('pengguna')->id(),
            'id_subprogram'    => $validate['id_subprogram'],
            'rencana_aksi'  => $validate['rencanaAksi'],
            'sub_kegiatan'     => $validate['sub_kegiatan'],
            'kegiatan'         => $validate['kegiatan'],
            'nama_program'  => $validate['nama_program'],
            'lokasi'           => $validate['lokasi'],
            'volume' => $validate['volume'],
            'satuan' => $validate['satuan'],
            'anggaran'         => $validate['anggaran'],
            'sumberdana' => $validate['sumberdana'],
            'tahun'            => $validate['tahun'],
            'id_opd'           => $validate['id_opd'],
            'status'           => 'Belum divalidasi',
            'keterangan'       => $validate['keterangan'],
        ]);

        LogHelper::add('Menambah Data Rencana Kerja');

        return redirect()->route('rencanakerja')
            ->with('success', 'Rencana Kerja berhasil ditambahkan!');
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
        $rencana->status = $rencana->status === 'Valid' ? 'Belum divalidasi' : 'Valid';
        $rencana->save();

        LogHelper::add('Mengubah status data Rencana Kerja');
        return redirect()->route('rencanakerja')->with('success', 'Status berhasil diperbarui');
    }

    public function show(string $id)
    {
        $rencana = RencanaKerja::with(['subprogram', 'opd'])->findOrFail($id);

        LogHelper::add('Melihat detail data Rencana Kerja');
        return view('admin.RencanaKerja.show', compact('rencana'));
    }


    public function edit(string $id)
    {
        $user = Auth::guard('pengguna')->user();

        $rencana = RencanaKerja::findOrFail($id);

        $subprogram = Subprogram::all();
        $opd = Opd::all();

        return view('admin.RencanaKerja.update', compact('rencana', 'subprogram', 'opd'));
    }

    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'id_subprogram'  => 'required|exists:subprograms,id',
            'rencanaAksi' => 'required|exists:rencana_aksi_6_tahuns,id',
            'sub_kegiatan'   => 'required|string',
            'kegiatan'       => 'required|string',
            'nama_program'   => 'required|string',
            'lokasi'         => 'required|string',
            'volume' => 'required',
            'satuan' => 'required',
            'anggaran'       => 'required',
            'sumberdana'       => 'required',
            'tahun'          => 'required',
            'id_opd'         => 'required|exists:opds,id',
            'keterangan'     => 'required|string'
        ]);

        $rencana = RencanaKerja::findOrFail($id);
        $rencana->update($validate);

        LogHelper::add('Mengedit Data Rencana Kerja');

        return redirect()->route('rencanakerja')
            ->with('success', 'Rencana Kerja berhasil diperbarui!');
    }


    public function destroy(string $id)
    {
        $rencana = RencanaKerja::findOrFail($id);

        if ($rencana->file && Storage::disk('public')->exists($rencana->file)) {
            Storage::disk('public')->delete($rencana->file);
        }

        $rencana->delete();
        LogHelper::add('Menghapus data Rencana Kerja');

        return redirect()->route('rencanakerja')->with('success', 'Data berhasil dihapus');
    }
}
