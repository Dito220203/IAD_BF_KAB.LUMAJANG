<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KontakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil kontak pertama (jika ada)
        $kontak = Kontak::first();
        return view('admin.Kontak.index', compact('kontak'));
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
    $request->validate([
        'telepon' => 'required|string|max:20',
        'email'   => 'required|email|max:255',
        'namafb'  => 'nullable|string|max:255',
        'linkfb'  => 'nullable|url|max:255',
        'namaig'  => 'nullable|string|max:255',
        'linkig'  => 'nullable|url|max:255',
        'namayt'  => 'nullable|string|max:255',
        'linkyt'  => 'nullable|url|max:255',
    ]);

    // gabungkan data request + id_pengguna
    $data = $request->all();
    $data['id_pengguna'] = Auth::guard('pengguna')->id();

    // cek apakah data sudah ada untuk user ini
    $kontak = Kontak::where('id_pengguna', $data['id_pengguna'])->first();

    if ($kontak) {
        $kontak->update($data);
    } else {
        Kontak::create($data);
    }
     LogHelper::add('Menambah data Kontak');
    return redirect()->back()->with('success', 'Kontak berhasil disimpan!');
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
