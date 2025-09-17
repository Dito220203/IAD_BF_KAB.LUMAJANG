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
use App\Models\Monev;

class RencanakerjaController extends Controller
{
    public function index()
    {
        $user = Auth::guard('pengguna')->user();
        $rencana = $user->level == 'Super Admin'
            ? RencanaKerja::active()->paginate(10)
            : RencanaKerja::active()->where('id_pengguna', $user->id)->paginate(10);

        return view('admin.RencanaKerja.index', compact('rencana'));
    }

    public function getRencanaAksi($id_subprogram)
    {
        $rencanaAksi = RencanaAksi_6_tahun::where('id_subprogram', $id_subprogram)->where('delete_at', '0')
            ->get();

        return response()->json($rencanaAksi);
    }
    public function getDetail($id)
    {
        $data = RencanaAksi_6_tahun::with(['subprogram'])->findOrFail($id);

        return response()->json([
            'sub_kegiatan' => $data->sub_kegiatan,
            'kegiatan'     => $data->kegiatan,
            'nama_program' => $data->nama_program,
            // 'tahun'        => $data->tahun,
        ]);
    }




    public function create()
    {
        $subprogram = Subprogram::where('delete_at', '0')->get();
        $opd = Opd::where('delete_at', '0')->get();
        $rencanaAksi =  RencanaAksi_6_tahun::where('delete_at', '0')->get();

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
            'rencanaAksi'    => 'required',
            'sub_kegiatan'   => 'required',
            'kegiatan'       => 'required',
            'nama_program'   => 'required',
            'tahun'          => 'required',
            'volume'         => 'required',
            'satuan'         => 'required',
            'anggaran'       => 'required',
            'sumberdana'     => 'required',
            'lokasi'         => 'required',
            'id_opd'         => 'required|exists:opds,id',
            'keterangan'     => 'required'
        ]);

        // simpan ke tabel rencana kerja
        $rencana = RencanaKerja::create([
            'id_pengguna'   => Auth::guard('pengguna')->id(),
            'id_subprogram' => $validate['id_subprogram'],
            'rencana_aksi'  => $validate['rencanaAksi'],
            'sub_kegiatan'  => $validate['sub_kegiatan'],
            'kegiatan'      => $validate['kegiatan'],
            'nama_program'  => $validate['nama_program'],
            'lokasi'        => $validate['lokasi'],
            'volume'        => $validate['volume'],
            'satuan'        => $validate['satuan'],
            'anggaran'      => $validate['anggaran'],
            'sumberdana'    => $validate['sumberdana'],
            'tahun'         => $validate['tahun'],
            'id_opd'        => $validate['id_opd'],
            'status'        => 'Belum divalidasi',
            'keterangan'    => $validate['keterangan'],
        ]);

        // otomatis simpan juga ke tabel monev
        Monev::create([
            'id_pengguna'   => $rencana->id_pengguna,
            'id_subprogram' => $rencana->id_subprogram,
            'rencana_aksi'  => $rencana->id,
            'sub_kegiatan'  => $rencana->sub_kegiatan,
            'kegiatan'      => $rencana->kegiatan,
            'nama_program'  => $rencana->nama_program,
            'lokasi'        => $rencana->lokasi,
            'volume'        => $rencana->volume,
            'satuan'        => $rencana->satuan,
            'anggaran'      => $rencana->anggaran,
            'sumberdana'    => $rencana->sumberdana,
            'tahun'         => $rencana->tahun,
            'id_opd'        => $rencana->id_opd,
            'status'        => $rencana->status,



        ]);

        LogHelper::add('Menambah Data Rencana Kerja + otomatis ke Monev');

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
        $listTahun = RencanaAksi_6_tahun::where('delete_at', '0')->get();
        $subprogram = Subprogram::where('delete_at', '0')->get();
        $opd = Opd::where('delete_at', '0')->get();

        return view('admin.RencanaKerja.update', compact('rencana','listTahun', 'subprogram', 'opd'));
    }

    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'id_subprogram'  => 'required|exists:subprograms,id',
            'rencanaAksi' => 'required',
            'sub_kegiatan'   => 'required',
            'kegiatan'       => 'required',
            'nama_program'   => 'required',
            'lokasi'         => 'required',
            'volume' => 'required',
            'satuan' => 'required',
            'anggaran'       => 'required',
            'sumberdana'       => 'required',
            'tahun'          => 'required',
            'id_opd'         => 'required|exists:opds,id',
            'keterangan'     => 'required'
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

        $rencana->update([
            'delete_at' => '1'
        ]);
        LogHelper::add('Menghapus data Rencana Kerja');

        return redirect()->route('rencanakerja')->with('success', 'Data berhasil dihapus');
    }
}
