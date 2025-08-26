<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use App\Models\Pengguna;
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

        // Contoh data progres tiap OPD (bisa dari tabel lain)
        $progresOpd = [
            'Dinas Pendidikan' => 80,
            'Dinas Kesehatan'  => 60,
            'Dinas PU'         => 90,
            'Dinas Sosial'     => 50,
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
