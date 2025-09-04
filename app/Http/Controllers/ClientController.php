<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\FotoSubprogram;
use App\Models\GambaranUmum;
use App\Models\Informasi;
use App\Models\Kontak;
use App\Models\Kth;
use App\Models\Kups;
use App\Models\Map;
use App\Models\Monev;
use App\Models\Opd;
use App\Models\ProgresKerja;
use App\Models\Regulasi;
use App\Models\RencanaKerja;
use App\Models\Subprogram;
use App\Models\Video;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\ReturnValueGenerator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $jumlahKups = Kups::count();
        $jumlahKth = Kth::count();
        $gambaran = GambaranUmum::where('status', 'Aktif')->get();
        $informasi = Informasi::orderBy('tanggal', 'asc')->get();
        $videos = Video::all();
        $banner = Banner::where('status', 'Aktif')->get();
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.index', compact('banner', 'gambaran', 'informasi', 'videos', 'subprograms','jumlahKth','jumlahKups', 'contact'));
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
    public function monev($id)
    {
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        $subprogram = Subprogram::findOrFail($id);
        $monevs = Monev::with(['rencanaKerja', 'opd'])
            ->where('id_subprogram', $id)->where('status', 'valid')
            ->get();

        // kelompokkan per triwulan berdasarkan bulan di created_at
        $triwulan = [
            1 => $monevs->filter(fn($item) => $item->created_at->month >= 1 && $item->created_at->month <= 3),
            2 => $monevs->filter(fn($item) => $item->created_at->month >= 4 && $item->created_at->month <= 6),
            3 => $monevs->filter(fn($item) => $item->created_at->month >= 7 && $item->created_at->month <= 9),
            4 => $monevs->filter(fn($item) => $item->created_at->month >= 10 && $item->created_at->month <= 12),
        ];
        return view('client.monev', compact('contact', 'subprograms', 'subprogram', 'monevs', 'triwulan'));
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


    public function progreskegiatandetail()
    {
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.progreskegiatandetail', compact('contact', 'subprograms'));
    }
    public function profilkawasan()
    {
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.profilkawasan', compact('contact', 'subprograms'));
    }

    //sub profil kawasanadetail
    public function profilkawasandetail()
    {
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.profilkawasandetail', compact('contact', 'subprograms'));
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
    public function daftarpotensi ()
    {
      $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.daftarpotensi', compact('contact', 'subprograms'));
     
    }
    public function detailpotensi ()
    {
      $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.detailpotensi', compact('contact', 'subprograms'));
     
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
