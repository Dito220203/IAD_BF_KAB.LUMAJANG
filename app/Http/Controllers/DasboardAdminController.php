<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use App\Models\Monev;
use App\Models\Pengguna;
use App\Models\ProgresKerja;
use App\Models\RencanaKerja;
use Illuminate\Http\Request;

class DasboardAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Hitung jumlah pengguna
        $totalPengguna = Pengguna::count();

        // Ambil pengguna terbaru (misal 5)
        $penggunaTerbaru = Pengguna::latest()->take(5)->get();

        $informasi = Informasi::all();

        // Contoh data progres tiap OPD (nanti bisa diambil dari tabel monitoring/evaluasi)
        $progresOpd = [
            ['nama' => 'Dinas Pendidikan', 'persentase' => 80],
            ['nama' => 'Dinas Kesehatan',  'persentase' => 60],
            ['nama' => 'Dinas PU',         'persentase' => 90],
            ['nama' => 'Dinas Sosial',     'persentase' => 50],
        ];

        return view('admin.Dasboard.index', compact(
            'totalPengguna',
            'penggunaTerbaru',
            'informasi',
            'progresOpd'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function navbarNotifikasi()
    {
        $rencana = RencanaKerja::latest()->take(5)->get();
        $progres = ProgresKerja::latest()->take(5)->get();
        $monev   = Monev::latest()->take(5)->get();

        // Gabung jadi satu collection
        $notifikasi = $rencana->concat($progres)->concat($monev)
            ->sortByDesc('created_at')
            ->take(5); // ambil 5 terbaru dari gabungan

        return view('components.navbar', compact('notifikasi'));
    }
}
