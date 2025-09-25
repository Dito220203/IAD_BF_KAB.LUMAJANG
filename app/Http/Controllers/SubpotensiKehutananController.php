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
   public function index(Request $request)
{
    $search = $request->input('search');

    $query = SubpotensiKehutanan::where('delete_at', '0');

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('sub_potensi', 'like', "%{$search}%")
              ->orWhere('keterangan', 'like', "%{$search}%");
        })
        ->orWhereHas('penggunas', function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%");
        });
    }

    $subpotensi = $query->paginate(10);
    $subpotensi->appends($request->only('search'));

    return view('admin.subpotensiKehutanan.index', compact('subpotensi', 'search'));
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
        $subpotensi->update([
            'delete_at' => '1'
        ]);
        LogHelper::add('Menghapus Sub Potensi Kehutanan');
        return redirect()->route('SubpotensiKehutanan')->with('success', 'Sub Potensi Kehutanan berhasil dihapus.');
    }

}
