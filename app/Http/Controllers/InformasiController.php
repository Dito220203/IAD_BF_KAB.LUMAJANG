<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InformasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard('pengguna')->user();

        if ($user->level == 'Super Admin') {
            $informasi = Informasi::paginate(10);
        } else {
            $informasi = Informasi::where('id_pengguna', $user->id)->paginate(10);
        }

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
        // dd($request->all());

        $validatedData = $request->validate([
            'judul' => 'required',
            'foto'    => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'tanggal' => 'required',
            'status' => 'required',
            'isi' => 'required|string',
        ], [
            'foto.max' => 'Ukuran foto tidak boleh lebih dari 2 MB', // Pesan error custom
        ]);


        if ($request->hasFile('foto')) {
            $originalName = time() . '_' . $request->file('foto')->getClientOriginalName();
            $documentPath = $request->file('foto')->storeAs('informasi', $originalName, 'public');
        }



        Informasi::create([
            'id_pengguna' => Auth::guard('pengguna')->id(),
            'judul'       => $validatedData['judul'],
            'foto'       => $documentPath,
            'tanggal'      => $validatedData['tanggal'],
            'status'      => $validatedData['status'],
            'isi'      => $validatedData['isi'],
        ]);

        LogHelper::add('Menambah data Informasi');
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
            'foto'    => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'tanggal' => 'required',
            'status'  => 'required',
            'isi'     => 'required',
        ], [
            'foto.max' => 'Ukuran foto tidak boleh lebih dari 2 MB',
        ]);

        // Jika ada foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if (!empty($informasi->foto) && Storage::disk('public')->exists($informasi->foto)) {
                Storage::disk('public')->delete($informasi->foto);
            }

            // Simpan foto baru
            $originalName = time() . '_' . $request->file('foto')->getClientOriginalName();
            $validatedData['foto'] = $request->file('foto')->storeAs('informasi', $originalName, 'public');
        }

        $informasi->update($validatedData);

        LogHelper::add('Memperbarui data Informasi');

        return redirect()->route('informasi')->with('success', 'Data Berhasil Diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $informasi = Informasi::findOrFail($id);

        // Hapus file di storage jika ada
        if (!empty($informasi->foto) && Storage::disk('public')->exists($informasi->foto)) {
            Storage::disk('public')->delete($informasi->foto);
        }

        // Hapus data dari database
        $informasi->delete();
        LogHelper::add('Menghapus data Informasi');
        return redirect()->route('informasi')->with('success', 'Data Berhasil Dihapus');
    }
}
