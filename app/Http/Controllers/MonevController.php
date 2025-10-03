<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\FotoProgres;
use App\Models\Monev;
use App\Models\Notifikasi;
use App\Models\Opd;
use App\Models\Pengguna;
use App\Models\Pesan;
use App\Models\ProgresKerja;
use App\Models\RencanaKerja;
use App\Models\Subprogram;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MonevController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('pengguna')->user();
        $query = Monev::query();

        // ✅ Load relasi
        $query->with(['opd', 'subprogram', 'fotoProgres']);

        // ✅ Ambil daftar tahun
        $tahuns = Monev::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        // ✅ Batasi berdasarkan user (kecuali Super Admin)
        if ($user->level !== 'Super Admin') {
            $query->where('id_pengguna', $user->id);
        }

        // ✅ Filter Tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        // ✅ Filter Search (dibungkus supaya tidak merusak filter tahun)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('rencana_aksi', 'like', "%{$search}%")
                    ->orWhere('nama_program', 'like', "%{$search}%")
                    ->orWhere('kegiatan', 'like', "%{$search}%")
                    ->orWhere('sub_kegiatan', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%")
                    ->orWhere('anggaran', 'like', "%{$search}%")
                    ->orWhere('volume', 'like', "%{$search}%")
                    ->orWhere('satuan', 'like', "%{$search}%")
                    ->orWhere('sumberdana', 'like', "%{$search}%")
                    ->orWhere('uraian', 'like', "%{$search}%")
                    ->orWhereHas('opd', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('subprogram', function ($q) use ($search) {
                        $q->where('subprogram', 'like', "%{$search}%");
                    });
            });
        }

        // ✅ Pagination (DIUBAH DARI latest() MENJADI oldest())
        $monev = $query->oldest()->paginate(10)->appends($request->query());

        return view('admin.MonitoringEvaluasi.index', compact('monev', 'tahuns'));
    }





    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::guard('pengguna')->user();

        $subprogram = Subprogram::where('delete_at', '0')->get();

        if ($user->level === 'Super Admin') {
            $rencana = RencanaKerja::where('delete_at', '0')->get();
        } else {
            $rencana = RencanaKerja::where('id_pengguna', $user->id)
                ->where('delete_at', '0')
                ->get();
        }

        $opd = Opd::where('delete_at', '0')->get();

        return view('admin.MonitoringEvaluasi.create', compact('subprogram', 'rencana', 'opd'));
    }

    // Ambil daftar rencana kerja berdasarkan subprogram
    public function getRencanaKerja($id_subprogram)
    {
        $user = Auth::guard('pengguna')->user();

        if ($user->level === 'Super Admin') {
            $rencanaKerja = RencanaKerja::where('id_subprogram', $id_subprogram)
                ->where('delete_at', '0')
                ->get(['id', 'rencana_aksi']);
        } else {
            $rencanaKerja = RencanaKerja::where('id_subprogram', $id_subprogram)
                ->where('id_pengguna', $user->id)
                ->where('delete_at', '0')
                ->get(['id', 'rencana_aksi']);
        }

        return response()->json($rencanaKerja);
    }

    // Ambil detail rencana kerja
    public function getDetailRencanaKerja($id)
    {
        $rencana = RencanaKerja::where('delete_at', '0')->findOrFail($id);

        return response()->json([
            'sub_kegiatan' => $rencana->sub_kegiatan,
            'kegiatan'     => $rencana->kegiatan,
            'nama_program' => $rencana->nama_program,
            'tahun'        => $rencana->tahun,
        ]);
    }





    /**
     * Store a newly created resource in storage.
     */
    // MonevController.php

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_subprogram' => 'required|exists:subprograms,id',
            'rencanaAksi'   => 'required|exists:rencana_kerjas,id',
            'sub_kegiatan'  => 'required',
            'kegiatan'      => 'required',
            'nama_program'  => 'required',
            'tahun'         => 'required',
            'volume'        => 'required',
            'satuan'        => 'required',
            'anggaran'     => 'required|array',
            'anggaran.*'   => 'required|string',
            'sumberdana'   => 'required|array',
            'sumberdana.*' => 'required|string',
            'lokasi'        => 'required',
            'id_opd'        => 'required|exists:opds,id',
            'uraian'    => 'required',
            'tw'            => 'nullable|array',
            'realisasi'     => 'nullable|array',
            'volumeTarget'  => 'nullable|array',

        ]);
        $anggaranString = implode('; ', $validatedData['anggaran']);
        $sumberdanaString = implode('; ', $validatedData['sumberdana']);


        $monev = Monev::create([
            'id_pengguna'    => Auth::guard('pengguna')->id(),
            'id_subprogram'  => $validatedData['id_subprogram'],
            'rencana_aksi'   => $validatedData['rencanaAksi'],
            'sub_kegiatan'   => $validatedData['sub_kegiatan'],
            'kegiatan'       => $validatedData['kegiatan'],
            'nama_program'   => $validatedData['nama_program'],
            'tahun'          => $validatedData['tahun'],
            'volume'         => $validatedData['volume'],
            'satuan'         => $validatedData['satuan'],
            'anggaran'      => $anggaranString,
            'sumberdana'    => $sumberdanaString,
            'lokasi'         => $validatedData['lokasi'],
            'id_opd'         => $validatedData['id_opd'],
            'uraian'     => $validatedData['uraian'],

            // Simpan data array
            'realisasi'        => $validatedData['realisasi'] ?? null,
            'dokumen_anggaran' => $validatedData['tw'] ?? null,
            'volumeTarget'     => $validatedData['volumeTarget'] ?? null,
        ]);

        ProgresKerja::create([
            'id_pengguna' => $monev->id_pengguna,
            'id_monev'    => $monev->id,

        ]);


        return redirect()->route('monev')->with('success', 'Data Monitoring Evaluasi berhasil disimpan.');
    }


    public function storeFoto(Request $request)
    {
        $validatedData = $request->validate([
            'monev_id'  => 'required|exists:monevs,id',
            'foto.*'    => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'deskripsi' => 'nullable|string|max:255', // Diubah dari array menjadi string
        ], [
            'foto.*.max' => 'Setiap foto maksimal berukuran 2MB.',
        ]);

        // Hapus foto lama jika ada (logika dari sebelumnya)
        $existingFotos = FotoProgres::where('id_monev', $validatedData['monev_id'])->get();
        if ($existingFotos->isNotEmpty()) {
            foreach ($existingFotos as $foto) {
                Storage::disk('public')->delete($foto->foto);
                $foto->delete();
            }
        }

        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $index => $file) {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension    = $file->getClientOriginalExtension();
                $safeName     = Str::slug($originalName);
                $uniqueName   = $safeName . '-' . uniqid() . '.' . $extension;
                $path         = $file->storeAs('foto_progres', $uniqueName, 'public');

                FotoProgres::create([
                    'id_monev'    => $validatedData['monev_id'],
                    'id_pengguna' => Auth::guard('pengguna')->id(),
                    'foto'        => $path,
                    // Gunakan deskripsi tunggal untuk semua foto
                    'deskripsi'   => $validatedData['deskripsi'] ?? null,
                ]);
            }
        }

        return redirect()->route('monev')->with('success', 'Foto dokumentasi berhasil diperbarui.');
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
        $tahun    = $request->tahun;
        $triwulan = $request->triwulan;

        $user = Auth::guard('pengguna')->user();

        $query = Monev::with(['subprogram', 'opd']);

        // Filter data kalau bukan superadmin
        if ($user->level !== 'Super Admin') {
            $query->where('id_pengguna', $user->id);
        }

        // Filter Triwulan (pakai kolom tanggal, bukan kolom 'triwulan')
        if ($triwulan) {
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

        // Filter Tahun (juga pakai kolom tanggal)
        if ($tahun) {
            $query->whereYear('tahun', $tahun);
        }

        $monev = $query->orderBy('created_at', 'desc')->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'admin.MonitoringEvaluasi.export',
            compact('monev', 'tahun', 'triwulan')
        )->setPaper('a4', 'landscape');

        return $pdf->download('laporan_monev.pdf');
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

        $opd = Opd::where('delete_at', '0')->get();
        $monev->anggaran = explode('; ', $monev->anggaran);
        $monev->sumberdana = explode('; ', $monev->sumberdana);

        return view('admin.MonitoringEvaluasi.update', compact('monev', 'subprogram', 'rencana', 'opd'));
    }


    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Temukan data yang akan diupdate
        $monev = Monev::findOrFail($id);

        // 2. Validasi semua input dari request
        $validatedData = $request->validate([
            'id_subprogram' => 'required|exists:subprograms,id',
            'rencanaAksi'   => 'required|exists:rencana_kerjas,id',
            'sub_kegiatan'  => 'required|string',
            'kegiatan'      => 'required|string',
            'nama_program'  => 'required|string',
            'tahun'         => 'required|string',
            'volume'        => 'required|string',
            'satuan'        => 'required|string',
            'anggaran'     => 'required|array',
            'anggaran.*'   => 'required|string',
            'sumberdana'   => 'required|array',
            'sumberdana.*' => 'required|string',
            'lokasi'        => 'required|string',
            'id_opd'        => 'required|exists:opds,id',
            'uraian'    => 'required|string',

            // Validasi untuk data triwulan sebagai array
            'tw'            => 'nullable|array',
            'realisasi'     => 'nullable|array',
            'volumeTarget'  => 'nullable|array',
        ]);

        $anggaranString = implode('; ', $validatedData['anggaran']);
        $sumberdanaString = implode('; ', $validatedData['sumberdana']);

        // 3. Siapkan data untuk diupdate dengan memetakan nama field
        $updateData = [
            'id_subprogram'    => $validatedData['id_subprogram'],
            'rencana_aksi'     => $validatedData['rencanaAksi'], // Peta 'rencanaAksi' ke 'rencana_aksi'
            'sub_kegiatan'     => $validatedData['sub_kegiatan'],
            'kegiatan'         => $validatedData['kegiatan'],
            'nama_program'     => $validatedData['nama_program'],
            'tahun'            => $validatedData['tahun'],
            'volume'           => $validatedData['volume'],
            'satuan'           => $validatedData['satuan'],
            'anggaran'      => $anggaranString,
            'sumberdana'    => $sumberdanaString,
            'lokasi'           => $validatedData['lokasi'],
            'id_opd'           => $validatedData['id_opd'],
            'uraian'       => $validatedData['uraian'],

            // Peta nama input ke nama kolom database untuk data array
            'dokumen_anggaran' => $validatedData['tw'] ?? [],
            'realisasi'        => $validatedData['realisasi'] ?? [],
            'volumeTarget'     => $validatedData['volumeTarget'] ?? [],
        ];

        // 4. Lakukan update pada data
        $monev->update($updateData);

        // 5. Tambahkan log dan redirect dengan pesan sukses
        LogHelper::add('Mengupdate data Monev dengan');
        return redirect()->route('monev')->with('success', 'Data Monitoring Evaluasi berhasil diperbarui.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $monev = Monev::with('fotoProgres')->findOrFail($id);

        // 3. Looping untuk menghapus setiap file foto dari storage
        if ($monev->fotoProgres->isNotEmpty()) {
            foreach ($monev->fotoProgres as $foto) {
                // Hapus file dari folder 'public/foto_progres'
                Storage::disk('public')->delete($foto->foto);
            }
        }

        $monev->delete();

        LogHelper::add('Menghapus data Monev beserta foto terkait');
        return redirect()->route('monev')->with('success', 'Data Berhasil Dihapus');
    }
}
