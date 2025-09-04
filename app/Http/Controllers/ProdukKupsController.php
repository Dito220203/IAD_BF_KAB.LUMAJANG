<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\ProdukKups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukKupsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produkKups = ProdukKups::all();
        return view('admin.ProdukKups.index', compact('produkKups'));
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
            'nama' => 'required',
            'keterangan' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            'gambar.image' => 'File harus berupa gambar (jpg/jpeg/png).'
        ]);
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('produk_kups', 'public');
        }
        ProdukKups::create([
            'id_pengguna' => Auth::guard('pengguna')->id(),
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
            'gambar'      => $gambarPath,

        ]);
        LogHelper::add('Menambah data Produk KUPS');
        return redirect()->route('produkKups')->with('success', 'Produk KUPS berhasil ditambahkan.');
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
        $produkKupsEdit = ProdukKups::findOrFail($id);
        $produkKups = ProdukKups::all();
        return view('admin.ProdukKups.index', compact('produkKups', 'produkKupsEdit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'e_nama' => 'required',
            'e_keterangan' => 'required',
            'e_gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            'gambar.image' => 'File harus berupa gambar (jpg/jpeg/png).'
        ]);
        $produkKups = ProdukKups::findOrFail($id);
        $gambarPath = $produkKups->gambar; // Default gambar lama
        if ($request->hasFile('e_gambar')) {
            // Hapus gambar lama kalau ada
            if ($produkKups->gambar && Storage::disk('public')->exists($produkKups->gambar)) {
                Storage::disk('public')->delete($produkKups->gambar);
            }
            // Upload gambar baru
            $gambarPath = $request->file('e_gambar')->store('produk_kups', 'public');
        }
        $produkKups->update([
            'nama' => $request->e_nama,
            'keterangan' => $request->e_keterangan,
            'gambar'     => $gambarPath,
        ]);
        LogHelper::add('Mengubah data Produk KUPS');
        return redirect()->route('produkKups')->with('success', 'Produk KUPS berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produkKups = ProdukKups::findOrFail($id);
        if ($produkKups->gambar && Storage::disk('public')->exists($produkKups->gambar)) {
            Storage::disk('public')->delete($produkKups->gambar);
        }

        $produkKups->delete();
        LogHelper::add('Menghapus data Produk KUPS');
        return redirect()->route('produkKups')->with('success', 'Produk KUPS berhasil dihapus.');
    }
}
