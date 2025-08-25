<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Potensi;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PotensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $potensi = Potensi::all();
        return view('admin.Potensi.index', compact('potensi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kecamatan = Kecamatan::all(); // ambil semua data
        return view('admin.Potensi.create', compact('kecamatan'));
    }
    public function getDesa($id_kec)
    {
        $desa = Desa::where('id_kec', $id_kec)->get();
        return response()->json($desa);
    }






    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul'     => 'required',
            'kecamatan' => 'required',
            'desa'      => 'required',
            'image'     => 'required|image|mimes:jpg,jpeg,png,gif',
            'tanggal'   => 'required',
            'uraian'    => 'required',
        ]);

        // Ambil nama kecamatan & desa berdasarkan ID
        $namaKecamatan = Kecamatan::findOrFail($validatedData['kecamatan'])->kecamatan;
        $namaDesa = Desa::findOrFail($validatedData['desa'])->desa;

         // Simpan gambar ke storage (sama kayak Informasi)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $originalName = time().'_'.$request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('potensi', $originalName, 'public');
        }

        Potensi::create([
            'id_pengguna' => Auth::guard('pengguna')->id(),
            'judul'     => $validatedData['judul'],
            'kecamatan' => $namaKecamatan,
            'desa'      => $namaDesa,
            'gambar'    => $imagePath,
            'tanggal'   => $validatedData['tanggal'],
            'uraian'    => $validatedData['uraian'],
        ]);

        return redirect()->route('potensi')->with('success', 'Data potensi berhasil disimpan.');
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
    public function edit($id)
    {
        $potensi = Potensi::findOrFail($id);
        $kecamatan = Kecamatan::all();
        $desa = Desa::where('id_kec', $potensi->id_kec)->get(); // kalau mau load otomatis desa sesuai kecamatan

        return view('admin.Potensi.update', compact('potensi', 'kecamatan', 'desa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $potensi = Potensi::findOrFail($id);

        $validatedData = $request->validate([
            'judul'     => 'required',
            'kecamatan' => 'required',
            'desa'      => 'required',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'tanggal'   => 'required',
            'uraian'    => 'required',
        ]);

        $namaKecamatan = Kecamatan::findOrFail($validatedData['kecamatan'])->kecamatan;
        $namaDesa      = Desa::findOrFail($validatedData['desa'])->desa;

        // Jika ada upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if (!empty($potensi->gambar) && Storage::disk('public')->exists($potensi->gambar)) {
                Storage::disk('public')->delete($potensi->gambar);
            }

            $originalName = time().'_'.$request->file('image')->getClientOriginalName();
            $validatedData['gambar'] = $request->file('image')->storeAs('potensi', $originalName, 'public');
        }

        $potensi->update([
            'judul'     => $validatedData['judul'],
            'kecamatan' => $namaKecamatan,
            'desa'      => $namaDesa,
            'gambar'    => $validatedData['gambar'] ?? $potensi->gambar,
            'tanggal'   => $validatedData['tanggal'],
            'uraian'    => $validatedData['uraian'],
        ]);

        return redirect()->route('potensi')->with('success', 'Data potensi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $potensi = Potensi::findOrFail($id);

        // Hapus gambar dari storage
        if (!empty($potensi->gambar) && Storage::disk('public')->exists($potensi->gambar)) {
            Storage::disk('public')->delete($potensi->gambar);
        }

        $potensi->delete();

        return redirect()->route('potensi')->with('success', 'Data potensi berhasil dihapus.');
    }
}
