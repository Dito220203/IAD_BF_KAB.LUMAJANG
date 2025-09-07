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
use App\Models\RencanaKerja;
use App\Models\SubpotensiKehutanan;
use App\Models\Subprogram;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\ReturnValueGenerator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentYear = Carbon::now()->year;

        // Ambil data KUPS untuk tahun sekarang
        $kupsData = Kups::where('tahun', $currentYear)
            ->select('kups', 'pendapatan')
            ->get();

        // Format data untuk Highcharts
        $chartData = $kupsData->map(function ($item) {
            return [$item->kups, (float)$item->pendapatan];
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

        $subpotensis = SubpotensiKehutanan::all();
        $produkKups = ProdukKups::all();
        $countpotensiKehutanan = PotensiKehutanan::count();
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
            'countpotensiKehutanan',
            'chartData',
            'currentYear',
            'years',
            'contact'

        ));
    }
    public function chartData($tahun)
    {
        $kupsData = Kups::where('tahun', $tahun)
            ->select('kups', 'pendapatan')
            ->get();

        $chartData = $kupsData->map(function ($item) {
            return [$item->kups, (float)$item->pendapatan];
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
    public function rencanakegiatan($id)
    {

        $subprograms = Subprogram::all();
        $subprogram = Subprogram::findOrFail($id);
        $rencanaKegiatan = RencanaKerja::where('id_subprogram', $id)->where('status', 'valid')->get();
        $opd = Opd::all();
        $contact = Kontak::all();
        return view('client.rencanakegiatan', compact('contact', 'subprograms', 'rencanaKegiatan', 'subprogram', 'opd'));
    }
    public function progreskegiatan($id)
    {
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        $subprogram = Subprogram::findOrFail($id);
        $progres = ProgresKerja::where('id_subprogram', $id)->where('status', 'valid')->get();

        return view('client.progreskegiatan', compact('contact', 'subprograms', 'subprogram', 'progres'));
    }


    public function monev(Request $request, $id)
    {
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        $subprogram = Subprogram::findOrFail($id);

        // Ambil semua tahun yang ada di tabel monevs untuk dropdown
        $years = Monev::selectRaw('YEAR(tahun) as year')->distinct()->pluck('year');

        $query = Monev::with(['rencanaKerja', 'opd'])
            ->where('id_subprogram', $id)
            ->where('status', 'valid');

        // Filter tahun kalau ada di request
        if ($request->filled('tahun')) {
            $query->whereYear('tahun', $request->tahun);
        }

        $monevs = $query->get();

        // Kelompokkan per triwulan
        $triwulan = [
            1 => $monevs->filter(fn($item) => \Carbon\Carbon::parse($item->tahun)->month >= 1 && \Carbon\Carbon::parse($item->tahun)->month <= 3),
            2 => $monevs->filter(fn($item) => \Carbon\Carbon::parse($item->tahun)->month >= 4 && \Carbon\Carbon::parse($item->tahun)->month <= 6),
            3 => $monevs->filter(fn($item) => \Carbon\Carbon::parse($item->tahun)->month >= 7 && \Carbon\Carbon::parse($item->tahun)->month <= 9),
            4 => $monevs->filter(fn($item) => \Carbon\Carbon::parse($item->tahun)->month >= 10 && \Carbon\Carbon::parse($item->tahun)->month <= 12),
        ];

        return view('client.monev', compact('contact', 'subprograms', 'subprogram', 'monevs', 'triwulan', 'years'));
    }



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
        return view('client.progreskegiatandetail', compact('contact', 'subprograms', 'progres'));
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
        $item        = Regulasi::where('status', 'Aktif')->findOrFail($id);
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.detailregulasi', compact('contact', 'subprograms', 'item'));
    }

    public function detailluasperhutanan()
    {
        $kth = Kth::all();
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.detailluasperhutanan', compact('contact', 'subprograms', 'kth'));
    }
    public function detailkth_kups()
    {

        $kthKups = Kups::all();
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.detailkth_kups', compact('contact', 'subprograms', 'kthKups'));
    }
    public function detailkups()
    {
        $Kups = Kups::all();
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.detailkups', compact('contact', 'subprograms', 'Kups'));
    }
    public function detailekonomi()
    {
        $Kups = Kups::all();
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.detailekonomi', compact('contact', 'subprograms', 'Kups'));
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
