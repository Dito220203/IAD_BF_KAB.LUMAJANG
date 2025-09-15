<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Desa;
use App\Models\FotoSubprogram;
use App\Models\GambaranUmum;
use App\Models\Informasi;
use App\Models\Kecamatan;
use App\Models\Kontak;
use App\Models\Kth;
use App\Models\Kups;
use App\Models\Map;
use App\Models\Monev;
use App\Models\Opd;
use App\Models\Potensi;
use App\Models\PotensiKehutanan;
use App\Models\ProdukKups;
use App\Models\ProgresKerja;
use App\Models\Regulasi;
use App\Models\RencanaAksi_6_tahun;
use App\Models\RencanaKerja;
use App\Models\SubpotensiKehutanan;
use App\Models\Subprogram;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\MockObject\ReturnValueGenerator;
use Barryvdh\DomPDF\Facade\Pdf;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentYear = Carbon::now()->year;

        // Ambil data KUPS untuk tahun sekarang
        $kupsData = Kups::with('kth') // <-- TAMBAHKAN BARIS INI
            ->where('tahun', $currentYear)
            ->get();

        // Format data untuk Highcharts
        $chartData = $kupsData->map(function ($item) {
            return [
                'name' => $item->kups,
                'y' => (float) $item->pendapatan,
                'kth' => $item->kth->kth ?? 'KTH tidak diketahui' // Menambahkan nama KTH
            ];
            ;
        });

        // Ambil daftar tahun unik dari tabel KUPS untuk dropdown
        $years = Kups::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
        // $kupsData = Kups::select('kups', 'pendapatan')->get();

        // // Format data untuk Highcharts
        // $chartData = $kupsData->map(function ($item) {
        //     return [$item->kups, (float)$item->pendapatan];
        // });


        $produkKups = ProdukKups::all();
        $subpotensis = SubpotensiKehutanan::all();
        $counts = PotensiKehutanan::select('id_subpotensi', DB::raw('COUNT(*) as total'))
            ->groupBy('id_subpotensi')
            ->pluck('total', 'id_subpotensi');

        $jumlahKups = Kups::count();
        $jumlahKth = Kth::count();
        $gambaran = GambaranUmum::where('status', 'Aktif')->get();
        $informasi = Informasi::orderBy('tanggal', 'asc')->get();
        $videos = Video::all();
        $banner = Banner::where('status', 'Aktif')->get();
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.index', compact(
            'banner',
            'gambaran',
            'informasi',
            'videos',
            'subprograms',
            'jumlahKth',
            'jumlahKups',
            'produkKups',
            'subpotensis',
            'counts',
            'chartData',
            'currentYear',
            'years',
            'contact'

        ));
    }

    public function chartData($tahun)
    {
        // Gunakan with() untuk memuat relasi 'kth' secara efisien
        $kupsData = Kups::with('kth')
            ->where('tahun', $tahun)
            ->get();

        $chartData = $kupsData->map(function ($item) {
            return [
                'name' => $item->kups,
                'y' => (float) $item->pendapatan,
                // KUNCI PERBAIKAN: Cek dulu apakah relasi 'kth' ada
                'kth' => $item->kth ? $item->kth->kth : 'KTH tidak diketahui'
            ];
        });

        return response()->json($chartData);
    }

    public function tentangkegiatan($id)
    {
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        $subprogram = Subprogram::findOrFail($id);
        $fotosubprogram = FotoSubprogram::where('id_subprogram', $id)->get();
        return view('client.tentangkegiatan', compact('contact', 'subprograms', 'subprogram', 'fotosubprogram'));
    }

    public function rencanaaksi(Request $request, $id)
    {
        // 1. Ambil input tahun dari request
        $selectedYear = $request->input('tahun');
        if ($selectedYear == 'semua') {
            $selectedYear = null;
        }

        // 2. Ambil daftar tahun unik dari model
        $years = RencanaAksi_6_tahun::selectRaw("DISTINCT TRIM(tahun) as tahun")
            ->where('id_subprogram', $id) // Pastikan ini nama kolom yang benar
            ->whereNotNull('tahun')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // 3. Bangun query dasar
        $rencanaAksiQuery = RencanaAksi_6_tahun::where('id_subprogram', $id); // <-- PERBAIKI DI SINI

        // 4. Tambahkan filter tahun jika ada tahun yang dipilih
        if ($selectedYear) {
            $rencanaAksiQuery->whereRaw("TRIM(tahun) = ?", [$selectedYear]);
        }

        // 5. Eksekusi query yang SUDAH difilter
        $rencanaAksi = $rencanaAksiQuery->orderBy('tahun', 'desc')->paginate(10);

        // Variabel lain yang dibutuhkan view
        $contact = Kontak::all();
        $subprogram = Subprogram::findOrFail($id);
        $subprograms = Subprogram::all();

        return view('client.rencanaaksi', compact('contact', 'subprograms', 'subprogram', 'rencanaAksi', 'years', 'selectedYear'));
    }
    public function rencanakegiatan(Request $request, $id)
{
    // 1. Ambil input tahun dari request
    $selectedYear = $request->input('tahun');
    if ($selectedYear == 'semua') {
        $selectedYear = null;
    }

    // 2. Ambil daftar tahun unik untuk dropdown
    $years = RencanaKerja::selectRaw("DISTINCT TRIM(tahun) as tahun")
        ->where('id_subprogram', $id) // Pastikan 'id_subprogram' adalah nama kolom yang benar
        ->where('status', 'valid')
        ->whereNotNull('tahun')
        ->orderBy('tahun', 'desc')
        ->pluck('tahun');

    // 3. Bangun query dasar dengan filter wajib (subprogram dan status)
    $rencanaKegiatanQuery = RencanaKerja::where('id_subprogram', $id) // Pastikan 'id_subprogram' adalah nama kolom yang benar
                                         ->where('status', 'valid');

    // 4. Tambahkan filter tahun jika ada tahun yang dipilih
    if ($selectedYear) {
        $rencanaKegiatanQuery->whereRaw("TRIM(tahun) = ?", [$selectedYear]);
    }

    // 5. Eksekusi query yang sudah lengkap dengan semua filter
    $rencanaKegiatan = $rencanaKegiatanQuery->orderBy('tahun', 'desc')->paginate(10);

    // Ambil data lain yang dibutuhkan oleh view
    $subprograms = Subprogram::all();
    $subprogram = Subprogram::findOrFail($id);
    $opd = Opd::all();
    $contact = Kontak::all();
    
    // 6. Kirim semua data ke view
    return view('client.rencanakegiatan', compact('contact', 'subprograms', 'rencanaKegiatan', 'subprogram', 'opd', 'years', 'selectedYear'));
}
    public function progreskegiatan($id)
    {
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        $subprogram = Subprogram::findOrFail($id);
        $progres = ProgresKerja::where('id_subprogram', $id)->where('status', 'valid')->get();

        return view('client.progreskegiatan', compact('contact', 'subprograms', 'subprogram', 'progres'));
    }

    // public function monev(Request $request, $id)
    // {
    //     $contact = Kontak::all();
    //     $subprograms = Subprogram::all();
    //     $subprogram = Subprogram::findOrFail($id);

    //     // Ambil semua tahun dari kolom tanggal untuk dropdown
    //     $years = Monev::selectRaw('YEAR(tanggal) as year')
    //         ->distinct()
    //         ->orderBy('year', 'desc')
    //         ->pluck('year');

    //     $query = Monev::with(['rencanaKerja', 'opd'])
    //         ->where('id_subprogram', $id)
    //         ->where('status', 'valid');

    //     // Filter Tahun
    //     if ($request->filled('tahun')) {
    //         $query->whereYear('tanggal', $request->tahun);
    //     }

    //     // Filter Triwulan (sama persis dengan admin)
    //     if ($request->filled('triwulan')) {
    //         switch ($request->triwulan) {
    //             case 1: // Jan - Mar
    //                 $query->whereMonth('tanggal', '>=', 1)
    //                     ->whereMonth('tanggal', '<=', 3);
    //                 break;
    //             case 2: // Apr - Jun
    //                 $query->whereMonth('tanggal', '>=', 4)
    //                     ->whereMonth('tanggal', '<=', 6);
    //                 break;
    //             case 3: // Jul - Sep
    //                 $query->whereMonth('tanggal', '>=', 7)
    //                     ->whereMonth('tanggal', '<=', 9);
    //                 break;
    //             case 4: // Okt - Des
    //                 $query->whereMonth('tanggal', '>=', 10)
    //                     ->whereMonth('tanggal', '<=', 12);
    //                 break;
    //         }
    //     }

    //     $monevs = $query->orderBy('tanggal', 'asc')->get();

    //     // Kelompokkan per triwulan untuk ditampilkan
    //     $triwulan = [
    //         1 => $monevs->filter(fn($item) => \Carbon\Carbon::parse($item->tanggal)->month >= 1 && \Carbon\Carbon::parse($item->tanggal)->month <= 3),
    //         2 => $monevs->filter(fn($item) => \Carbon\Carbon::parse($item->tanggal)->month >= 4 && \Carbon\Carbon::parse($item->tanggal)->month <= 6),
    //         3 => $monevs->filter(fn($item) => \Carbon\Carbon::parse($item->tanggal)->month >= 7 && \Carbon\Carbon::parse($item->tanggal)->month <= 9),
    //         4 => $monevs->filter(fn($item) => \Carbon\Carbon::parse($item->tanggal)->month >= 10 && \Carbon\Carbon::parse($item->tanggal)->month <= 12),
    //     ];

    //     return view('client.monev', compact('contact', 'subprograms', 'subprogram', 'monevs', 'triwulan', 'years'));
    // }



    public function petasebarankegiatan($id)
    {
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        $subprogram = Subprogram::findOrFail($id);

        $maps = Map::whereHas('progres', function ($q) use ($id) {
            $q->where('id_subprogram', $id)
                ->where('status', 'valid');
        })
            ->with('progres')
            ->get();

        return view('client.petasebarankegiatan', compact('contact', 'subprograms', 'subprogram', 'maps'));
    }


    public function progreskegiatandetail($id)
    {
        $progres = ProgresKerja::with('fotoProgres', 'maps', 'subprogram')
            ->findOrFail($id);
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        $photoCount = $progres->fotoProgres->count();
        return view('client.progreskegiatandetail', compact(
            'contact',
            'subprograms',
            'progres',
            'photoCount'
        ));
    }

    public function profilkawasan()
    {
        $contact = Kontak::all();
        $subprograms = Subprogram::all();

        // Ambil kecamatan yang ada di tabel potensi
        $kecamatanIds = Potensi::distinct('id_kecamatan')->pluck('id_kecamatan');
        $kecamatan = Kecamatan::whereIn('id', $kecamatanIds)->get();

        return view('client.profilkawasan', compact('contact', 'subprograms', 'kecamatan'));
    }

    // API untuk ambil desa sesuai kecamatan
    public function getDesaByKecamatan($kecamatanId)
    {
        // Ambil code kecamatan
        $kecamatan = Kecamatan::find($kecamatanId);

        if (!$kecamatan) {
            return response()->json([]);
        }

        // Ambil id_desa yang sudah dipakai di potensi sesuai kecamatan terpilih
        $desaIds = Potensi::where('id_kecamatan', $kecamatanId)
            ->distinct()
            ->pluck('id_desa');

        // Ambil data desa hanya dari desa yang ada di potensi
        $desa = Desa::whereIn('id', $desaIds)->get();

        return response()->json($desa);
    }

    public function searchPotensi(Request $request)
    {
        $contact = Kontak::all();
        $subprograms = Subprogram::all();

        // Ambil kecamatan yg sudah ada potensi
        $kecamatanIds = Potensi::distinct('id_kecamatan')->pluck('id_kecamatan');
        $kecamatan = Kecamatan::whereIn('id', $kecamatanIds)->get();

        // Query potensi
        $query = Potensi::with(['kecamatan', 'desa']);

        if ($request->filled('kecamatan')) {
            $query->where('id_kecamatan', $request->kecamatan);
        }

        if ($request->filled('desa')) {
            $query->where('id_desa', $request->desa);
        }

        $potensis = $query->get();

        return view('client.profilkawasan', compact('contact', 'subprograms', 'kecamatan', 'potensis'));
    }

    public function Daftarprofilkawasan(Request $request)
    {
        $kecamatanId = $request->query('kecamatan');
        $desaId = $request->query('desa');

        $contact = Kontak::all();
        $subprograms = Subprogram::all(); // ini tetap semua (statis)

        // filter potensi berdasarkan kecamatan & desa
        $potensis = Potensi::query()
            ->when($kecamatanId, fn($q) => $q->where('id_kecamatan', $kecamatanId))
            ->when($desaId, fn($q) => $q->where('id_desa', $desaId))
            ->get();

        return view('client.profilkawasan', compact('contact', 'subprograms', 'potensis'));
    }


    public function profilkawasandetail($id)
    {
        // Ambil data potensi berdasarkan ID
        $profilkawasanDetail = Potensi::findOrFail($id);

        // Data tambahan
        $contact = Kontak::all();
        $subprograms = Subprogram::all();

        // Kirim ke view
        return view('client.profilkawasandetail', compact('profilkawasanDetail', 'contact', 'subprograms'));
    }

    public function regulasi()
    {
        $regulasi = Regulasi::orderBy('tanggal', 'desc')->where('status', 'Aktif')->get();
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.regulasi', compact('contact', 'subprograms', 'regulasi'));
    }
    public function detailregulasi($id)
    {
        $item = Regulasi::where('status', 'Aktif')->findOrFail($id);
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.detailregulasi', compact('contact', 'subprograms', 'item'));
    }

    public function detailluasperhutanan()
    {
        $kth = Kth::paginate(10);
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.detailluasperhutanan', compact('contact', 'subprograms', 'kth'));
    }
    public function detailkth_kups()
    {

        $kthKups = Kth::paginate(10);
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.detailkth_kups', compact('contact', 'subprograms', 'kthKups'));
    }
    public function detailkups()
    {
        $Kups = Kups::paginate(10);
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.detailkups', compact('contact', 'subprograms', 'Kups'));
    }


    public function detailekonomi(Request $request)
    {
        $selectedYear = $request->input('tahun');
        if ($selectedYear == 'semua') {
            $selectedYear = null;
        }

        // rapikan daftar tahun
        $years = Kups::selectRaw("DISTINCT TRIM(tahun) as tahun")
            ->whereNotNull('tahun')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $kupsQuery = Kups::with('kth');

        if ($selectedYear) {
            $kupsQuery->whereRaw("TRIM(tahun) = ?", [$selectedYear]);
        }

        $kups = $kupsQuery->orderBy('tahun', 'desc')->paginate(10);

        $contact = Kontak::all();
        $subprograms = Subprogram::all();

        return view('client.detailekonomi', compact('contact', 'subprograms', 'kups', 'years', 'selectedYear'));
    }



    //detail informasi &video
    public function detailinformasi($id)
    {
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        $info = Informasi::findOrFail($id);
        return view('client.detailinformasi', compact('contact', 'subprograms', 'info'));
    }
    public function detailvideo()
    {
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.detailvideo', compact('contact', 'subprograms'));
    }







    //potensi
    public function daftarpotensi($id)
    {
        $subpotensiKehutanan = SubpotensiKehutanan::findOrFail($id);
        $potensiKehutanan = PotensiKehutanan::where('id_subpotensi', $id)->get();
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.daftarpotensi', compact('contact', 'subprograms', 'subpotensiKehutanan', 'potensiKehutanan'));
    }
    public function detailpotensi($id)
    {
        $detailpotensiKehutanan = PotensiKehutanan::findOrFail($id);
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.detailpotensi', compact('contact', 'subprograms', 'detailpotensiKehutanan'));
    }


    // detail card index



    public function footer()
    {
        $contact = Kontak::all();
        return view('about', compact('contact'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
