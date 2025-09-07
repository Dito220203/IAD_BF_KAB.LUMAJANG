<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
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
        $potensi = Potensi::paginate(10);
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

    public function getDesa($code)
    {
        try {


            $desa = Desa::where('district_code', $code)->get();

            return response()->json([
                'code' => $code,
                'desa' => $desa
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage(),
                'code' => $code
            ], 500);
        }
    }





    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul'     => 'required',
            'kecamatan' => 'required|exists:kecamatans,id',
            'desa'      => 'required|exists:desas,id',
            'image'     => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'tanggal'   => 'required',
            'uraian'    => 'required',
        ]);


        // Simpan gambar ke storage (sama kayak Informasi)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $originalName = time() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('potensi', $originalName, 'public');
        }


        Potensi::create([
            'id_pengguna' => Auth::guard('pengguna')->id(),
            'judul'       => $validatedData['judul'],
            'id_kecamatan' => $validatedData['kecamatan'], // simpan ID
            'id_desa'     => $validatedData['desa'],      // simpan ID
            'gambar'      => $imagePath,
            'tanggal'     => $validatedData['tanggal'],
            'uraian'      => $validatedData['uraian'],
        ]);


        LogHelper::add('Menambah data Potensi');
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

        // Ambil kode kecamatan dari potensi
        $kodeKecamatan = Kecamatan::find($potensi->id_kecamatan)->code ?? null;

        // Ambil desa sesuai kode kecamatan
        $desa = $kodeKecamatan ? Desa::where('district_code', $kodeKecamatan)->get() : collect();

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
            'kecamatan' => 'required|exists:kecamatans,id',
            'desa'      => 'required|exists:desas,id',
            'image'     => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'tanggal'   => 'required',
            'uraian'    => 'required',
        ]);

        // Jika ada upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if (!empty($potensi->gambar) && Storage::disk('public')->exists($potensi->gambar)) {
                Storage::disk('public')->delete($potensi->gambar);
            }

            $originalName = time() . '_' . $request->file('image')->getClientOriginalName();
            $validatedData['gambar'] = $request->file('image')->storeAs('potensi', $originalName, 'public');
        }

        // Update data hanya dengan ID, sesuai kolom di DB
        $potensi->update([
            'judul'         => $validatedData['judul'],
            'id_kecamatan'  => $validatedData['kecamatan'],
            'id_desa'       => $validatedData['desa'],
            'gambar'        => $validatedData['gambar'] ?? $potensi->gambar,
            'tanggal'       => $validatedData['tanggal'],
            'uraian'        => $validatedData['uraian'],
        ]);

        LogHelper::add('Mengubah data Potensi');
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
        LogHelper::add('Menghapus data Potensi');
        return redirect()->route('potensi')->with('success', 'Data potensi berhasil dihapus.');
    }
}
