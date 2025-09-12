<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\Monev;
use App\Models\Notifikasi;
use App\Models\Opd;
use App\Models\Pengguna;
use App\Models\Pesan;
use App\Models\RencanaKerja;
use App\Models\Subprogram;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // pastikan sudah install barryvdh/laravel-dompdf
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
                case 1: // Jan - Mar
                    $query->whereMonth('tanggal', '>=', 1)
                        ->whereMonth('tanggal', '<=', 3);
                    break;
                case 2: // Apr - Jun
                    $query->whereMonth('tanggal', '>=', 4)
                        ->whereMonth('tanggal', '<=', 6);
                    break;
                case 3: // Jul - Sep
                    $query->whereMonth('tanggal', '>=', 7)
                        ->whereMonth('tanggal', '<=', 9);
                    break;
                case 4: // Okt - Des
                    $query->whereMonth('tanggal', '>=', 10)
                        ->whereMonth('tanggal', '<=', 12);
                    break;
            }
        }

        // Filter Tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $monev = $query->orderBy('tanggal', 'desc')->paginate(10)->withQueryString();

        // Untuk dropdown tahun (ambil dari kolom tanggal, bukan tahun)
        $tahun_list = Monev::selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');


        return view('admin.MonitoringEvaluasi.index', compact('monev', 'tahun_list'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::guard('pengguna')->user();

        if ($user->level === 'Super Admin') {
            // Super Admin lihat semua subprogram yang dipakai di Rencana Kerja
            $subprogram = Subprogram::whereIn('id', RencanaKerja::pluck('id_subprogram'))->get();
            $rencana = RencanaKerja::all();
        } else {
            // User biasa hanya subprogram dari Rencana Kerja miliknya
            $subprogram = Subprogram::whereIn(
                'id',
                RencanaKerja::where('id_pengguna', $user->id)->pluck('id_subprogram')
            )->get();

            $rencana = RencanaKerja::where('id_pengguna', $user->id)->get();
        }

        $opd = Opd::all();

        return view('admin.MonitoringEvaluasi.create', compact('subprogram', 'rencana', 'opd'));
    }

    public function getRencanaKerja($id_subprogram)
    {
        $user = Auth::guard('pengguna')->user();

        if ($user->level === 'Super Admin') {
            // Super Admin bisa lihat semua
            $rencanaKerja = RencanaKerja::where('id_subprogram', $id_subprogram)
                ->get([
                    'id',
                    'rencana_aksi',
                    'sub_kegiatan',
                    'kegiatan',
                    'nama_program',
                    'tahun'
                ]);
        } else {
            // User biasa hanya data miliknya
            $rencanaKerja = RencanaKerja::where('id_subprogram', $id_subprogram)
                ->where('id_pengguna', $user->id)
                ->get([
                    'id',
                    'rencana_aksi',
                    'sub_kegiatan',
                    'kegiatan',
                    'nama_program',
                    'tahun'
                ]);
        }

        return response()->json($rencanaKerja);
    }





    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $user = Auth::guard('pengguna')->user();

        $validate = $request->validate([
            'id_subprogram'  => 'required|exists:subprograms,id',
            'rencanaAksi' => 'required|string',
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
            'rka' => 'required',
            'realisasi' => 'required',
            'tanggal' => 'required',
            'keterangan'     => 'required|string'
        ]);

        Monev::create([
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
            'rka'       => $validate['rka'],
            'realisasi'       => $validate['realisasi'],
            'tanggal'       => $validate['tanggal'],
            'keterangan'       => $validate['keterangan'],
        ]);
        LogHelper::add('Menambah data Monev');
        return redirect()->route('monev')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function updatePesan(Request $request, $id)
    {
        $request->validate([
            'pesan' => 'nullable|string',
        ]);

        $monev = Monev::findOrFail($id);
        $monev->pesan = $request->pesan;
        $monev->save();

        return redirect()->route('monev')->with('success', 'Pesan berhasil disimpan');
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


    public function exportPDF(Request $request)
    {
        $tahun = $request->tahun;
        $triwulan = $request->triwulan;

        $user = Auth::guard('pengguna')->user();

        $query = Monev::with(['subprogram', 'opd']);

        // Filter data kalau bukan superadmin
        if ($user->level !== 'Super Admin') {
            $query->where('id_pengguna', $user->id);
        }

        // Kalau mau filter tahun/triwulan juga:
        if ($tahun) {
            $query->where('tahun', $tahun);
        }
        if ($triwulan) {
            $query->where('triwulan', $triwulan);
        }

        $monev = $query->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'admin.MonitoringEvaluasi.export',
            compact('monev', 'tahun', 'triwulan')
        )
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan_monev.pdf');
    }



    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::guard('pengguna')->user();
        $monev = Monev::findOrFail($id);

        if ($user->level === 'Super Admin') {
            // Subprogram dari semua rencana kerja
            $subprogram = Subprogram::whereIn('id', RencanaKerja::pluck('id_subprogram'))->get();
            $rencana = RencanaKerja::all();
        } else {
            // Subprogram hanya dari rencana kerja user
            $subprogram = Subprogram::whereIn(
                'id',
                RencanaKerja::where('id_pengguna', $user->id)->pluck('id_subprogram')
            )->get();

            $rencana = RencanaKerja::where('id_pengguna', $user->id)->get();
        }

        $opd = Opd::all();

        return view('admin.MonitoringEvaluasi.update', compact('monev', 'subprogram', 'rencana', 'opd'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $user = Auth::guard('pengguna')->user();
        $validate = $request->validate([
            'id_subprogram'  => 'required|exists:subprograms,id',
            'rencanaAksi' => 'required|string',
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
            'rka' => 'required',
            'realisasi' => 'required',
            'tanggal' => 'required',
            'pesan' => 'nullable|string|max:255',
            'keterangan'     => 'required|string'
        ]);

        $monev = Monev::findOrFail($id);
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
