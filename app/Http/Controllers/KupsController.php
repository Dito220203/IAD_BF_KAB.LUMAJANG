<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\Kth;
use App\Models\Kups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KupsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kups = Kups::all();
        $kth = Kth::all();
        return view('admin.Kups.index', compact('kups', 'kth'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_kth' => 'required|exists:kths,id',
            'kups' => 'required',
            'kategori' => 'required',
            'tahun' => 'required',
            'pendapatan' => 'required',
        ]);

        Kups::create([
            'id_pengguna' => Auth::guard('pengguna')->id(),
            'id_kth' => $request->id_kth,
            'kups' => $request->kups,
            'kategori' => $request->kategori,
            'tahun' => $request->tahun,
            'pendapatan' => $request->pendapatan,
        ]);
        LogHelper::add('Menambah data KUPS');
        return redirect()->route('kups')->with('success', 'Data KUPS berhasil ditambahkan.');
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

        $kupsEdit = Kups::findOrFail($id);
        $kth = Kth::all();
        $kups = Kups::with('kth')->get();
        return view('admin.Kups.index', compact('kups', 'kupsEdit', 'kth'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kups = Kups::findOrFail($id);
        $request->validate([
            'id_kth' => 'required|exists:kths,id',
            'e_kups' => 'required',
            'e_kategori' => 'required',
            'e_tahun' => 'required',
            'e_pendapatan' => 'required',
        ]);
        $kups->update([
            'id_pengguna' => Auth::guard('pengguna')->id(),
            'id_kth' => $request->id_kth,
            'kups' => $request->e_kups,
            'kategori' => $request->e_kategori,
            'tahun' => $request->e_tahun,
            'pendapatan' => $request->e_pendapatan,
        ]);
        LogHelper::add('Mengubah data KUPS');
      return redirect()->route('kups')->with('success', 'Data KUPS berhasil di Update.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kups = Kups::findOrFail($id);
        $kups->delete();
        LogHelper::add('Menghapus data KUPS');
        return redirect()->route('kups')->with('success', 'Data KUPS berhasil dihapus.');
    }
}
