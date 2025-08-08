<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use Illuminate\Http\Request;

class InformasiConroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $informasi = Informasi::all();
        return view('admin.Informasi.index', compact('informasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.Informasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'judul' => 'required',
            'foto' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'tanggal' => 'required',
            'status' => 'required',
            'isi' => 'required',
        ]);


        // Upload file image terlebih dahulu
        $imageName = time() . '_' . $request->file('foto')->getClientOriginalName();
        $request->file('foto')->move(public_path('images'), $imageName);

        // Simpan nama file ke dalam kolom 'foto'
        $validatedData['foto'] = $imageName;


        Informasi::create($validatedData);

        return redirect()->route('informasi')->with('success', 'Data Berhasil Ditambahkan');
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
        $informasi = Informasi::findOrFail($id);
        return view('admin.Informasi.edit', compact('informasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $informasi = Informasi::findOrFail($id);

        $validatedData = $request->validate([
            'judul'   => 'required',
            'foto'    => 'nullable|image|mimes:jpeg,jpg,png',
            'tanggal' => 'required',
            'status'  => 'required',
            'isi'     => 'required',
        ]);

        // Jika ada foto baru diupload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($informasi->foto && file_exists(public_path('images/' . $informasi->foto))) {
                unlink(public_path('images/' . $informasi->foto));
            }

            // Upload foto baru
            $imageName = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move(public_path('images'), $imageName);
            $validatedData['foto'] = $imageName;
        }

        // Update data
        $informasi->update($validatedData);

        return redirect()->route('informasi')->with('success', 'Data Berhasil Diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $informasi = Informasi::findOrFail($id);

        // Hapus file gambar dari folder public/images
        $imagePath = public_path('images/' . $informasi->foto);
        if (file_exists($imagePath) && is_file($imagePath)) {
            unlink($imagePath);
        }

        // Hapus data dari database
        $informasi->delete();

        return redirect()->route('informasi')->with('success', 'Data Berhasil Dihapus');
    }
}
