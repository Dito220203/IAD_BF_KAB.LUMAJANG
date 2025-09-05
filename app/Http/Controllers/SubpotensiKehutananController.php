<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\PotensiKehutanan;
use App\Models\SubpotensiKehutanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubpotensiKehutananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $potensi = PotensiKehutanan::all();
        $subpotensi = SubpotensiKehutanan::all();
        return view('admin.subpotensiKehutanan.index', compact('subpotensi', 'potensi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sub_potensi' => 'required',
            'keterangan' => 'required',
        ]);

        SubpotensiKehutanan::create([
            'id_pengguna' => Auth::guard('pengguna')->id(),
            'sub_potensi' => $request->sub_potensi,
            'keterangan' => $request->keterangan,
        ]);
        LogHelper::add('Menambah Sub Potensi Kehutanan');
        return redirect()->route('SubpotensiKehutanan')->with('success', 'Sub Potensi Kehutanan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */

    public function update(Request $request, string $id)
    {
        $subpotensi = SubpotensiKehutanan::findOrFail($id);
        $request->validate([
            'e_sub_potensi' => 'required',
            'e_keterangan' => 'required',
        ]);
        $subpotensi->update([
            'sub_potensi' => $request->e_sub_potensi,
            'keterangan' => $request->e_keterangan,
        ]);
        LogHelper::add('Mengubah Sub Potensi Kehutanan');
        return redirect()->route('SubpotensiKehutanan')->with('success', 'Sub Potensi Kehutanan berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subpotensi = SubpotensiKehutanan::findOrFail($id);
        $subpotensi->delete();
        LogHelper::add('Menghapus Sub Potensi Kehutanan');
        return redirect()->route('SubpotensiKehutanan')->with('success', 'Sub Potensi Kehutanan berhasil dihapus.');
    }


    public function potensiKehutananStore(Request $request)
    {
        $request->validate([
            'id_subpotensi' => 'required|exists:subpotensi_kehutanans,id',
            'gambar' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'judul' => 'required',
            'keterangan' => 'required',
        ]);

        $filePath = $request->file('gambar')->store('potensikehutanan', 'public');

        PotensiKehutanan::create([
            'id_pengguna' => Auth::guard('pengguna')->id(),
            'id_subpotensi' => $request->id_subpotensi,
            'judul' => $request->judul,
            'gambar' => $filePath,
            'keterangan' => $request->keterangan,
        ]);

        LogHelper::add('Menambah Potensi Kehutanan');
        return redirect()->route('SubpotensiKehutanan')
            ->with('success', 'Potensi Kehutanan berhasil ditambahkan.');
    }

    public function potensiKehutananUpdate(Request $request, $id)
    {
        $potensi = PotensiKehutanan::findOrFail($id);

        $request->validate([
            'id_subpotensi' => 'required|exists:subpotensi_kehutanans,id',
            'e_judul' => 'required',
            'e_keterangan' => 'required',
        ]);

        $data = [
            'id_subpotensi' => $request->id_subpotensi,
            'judul' => $request->e_judul,
            'keterangan' => $request->e_keterangan,
        ];


        if ($request->hasFile('e_gambar')) {
            $request->validate(['e_gambar' => 'file|mimes:jpg,jpeg,png|max:2048']);


            if ($potensi->gambar && Storage::disk('public')->exists($potensi->gambar)) {
                Storage::disk('public')->delete($potensi->gambar);
            }

            $data['gambar'] = $request->file('e_gambar')->store('potensikehutanan', 'public');
        }

        $potensi->update($data);

        LogHelper::add('Mengubah Potensi Kehutanan');
        return redirect()->route('SubpotensiKehutanan')
            ->with('success', 'Potensi Kehutanan berhasil diubah.');
    }


    public function potensiKehutananDelete($id)
    {
        $potensi = PotensiKehutanan::findOrFail($id);

        if ($potensi->gambar && Storage::disk('public')->exists($potensi->gambar)) {
            Storage::disk('public')->delete($potensi->gambar);
        }
        $potensi->delete();

        LogHelper::add('Menghapus Potensi Kehutanan');
        return redirect()->route('SubpotensiKehutanan')
            ->with('success', 'Potensi Kehutanan berhasil dihapus.');
    }
}
