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



        // ===== Bagian untuk Rencana Kerja =====
        $totalRencanaKerja = RencanaKerja::count();
        $rencanaSelesai    = RencanaKerja::where('status', 'Valid')->count();
        $rencanaProgress   = RencanaKerja::where('status', 'Belum divalidasi')->count();

        // ===== Bagian untuk Monev =====
        // ambil semua data monev
        $allMonev = Monev::all();

        // filter data lengkap
        $monevLengkap = $allMonev->filter(function ($item) {
            // kolom yang WAJIB diisi
            $requiredFields = [
                'id_pengguna',
                'id_subprogram',
                'rencana_aksi',
                'sub_kegiatan',
                'kegiatan',
                'nama_program',
                'lokasi',
                'volume',
                'satuan',
                'anggaran',
                'sumberdana',
                'tahun',
                'id_opd',
                'realisasi',
                'rka',
                'tanggal'
            ];

            // cek kalau ada yang kosong/null
            foreach ($requiredFields as $field) {
                if (empty($item->$field)) {
                    return false; // tidak lengkap
                }
            }

            return true; // lengkap
        })->count();

        // total monev
        $totalMonev = $allMonev->count();

        // sisanya = belum lengkap
        $monevBelumLengkap = $totalMonev - $monevLengkap;



        return view('admin.Dasboard.index', compact(
            'totalPengguna',
            'penggunaTerbaru',

            'totalRencanaKerja',
            'rencanaSelesai',
            'rencanaProgress',
            'totalMonev',
            'monevLengkap',
            'monevBelumLengkap'
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
