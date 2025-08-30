<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\LogAktivitas;
use App\Models\Opd;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengguna = Pengguna::all();
        return view ('admin.Pengguna.index', compact('pengguna'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $opd = Opd::all();
        return view('admin.Pengguna.create', compact('opd'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'nama' => 'required',
            'password' => 'required',
            'level' => 'required',
            'id_opd' => 'required|exists:opds,id',
        ]);

        // Ambil nama opd berdasarkan id

        //Simpan ke DB dengan password di-hash
        Pengguna::create([
            'id_opd'    => $request->id_opd,
            'username'  => $request->username,
            'nama'      => $request->nama,
            'password'  => Hash::make($request->password),
            'level'     => $request->level,

        ]);
         LogHelper::add('Menambah data Pengguna');
        return redirect()->route('pengguna')->with('success', 'Data Berhasil Ditambahkan');
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
        // Ambil data pengguna berdasarkan ID
        $pengguna = Pengguna::findOrFail($id);

        // Ambil semua OPD untuk pilihan dropdown
        $opd = Opd::all();
        return view('admin.Pengguna.update', compact('pengguna', 'opd'));
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, string $id)
{
    $pengguna = Pengguna::findOrFail($id);

    $request->validate([
        'e_username' => 'required',
        'e_nama'     => 'required',
        'e_id_opd'   => 'required|exists:opds,id',
        'e_level'    => 'required',
        'e_password' => 'nullable|string|min:8',
    ]);

    $data = [
        'username' => $request->e_username,
        'nama'     => $request->e_nama,
        'id_opd'   => $request->e_id_opd,
        'level'    => $request->e_level,
    ];

    // Jika password diisi, hash dan update
    if ($request->filled('e_password')) {
        $data['password'] = Hash::make($request->e_password);
    }

    $pengguna->update($data);

    LogHelper::add('Mengubah data Pengguna');

    return redirect()->route('pengguna')->with('success', 'Data Berhasil Di Update');
}




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Pengguna::where('id', $id)->delete();
        LogHelper::add('Menghapus data Pengguna');
        return redirect()->route('pengguna')->with('success', 'Data Berhasil Dihapus');
    }
}
