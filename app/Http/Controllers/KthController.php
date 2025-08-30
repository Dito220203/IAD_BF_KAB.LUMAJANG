<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\Kth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kth = Kth::all();
        return view('admin.Kth.index', compact('kth'));
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
        $validatedData = $request->validate([
            'kth' => 'required',
            'luas' => 'required',
        ]);

        Kth::create([
            'id_pengguna' => Auth::guard('pengguna')->id(),
            'kth' => $validatedData['kth'],
            'luas' => $validatedData['luas'],
        ]);
        LogHelper::add('Menambah data KTH');
        return redirect()->route('kth')->with('success', 'KTH berhasil ditambahkan.');
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
        $kthEdit = Kth::findOrFail($id);
        $kth = Kth::all();
        return view('admin.Kth.index', compact('kth', 'kthEdit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kth = Kth::findOrFail($id);
        $validatedData = $request->validate([
            'e_kth' => 'required',
            'e_luas' => 'required',
        ]);

        $kth->update([
            'kth' => $validatedData['e_kth'],
            'luas' => $validatedData['e_luas'],
        ]);
        LogHelper::add('Mengubah data KTH');
        return redirect()->route('kth')->with('success', 'KTH berhasil di Update.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kth = Kth::findOrFail($id);
        $kth->delete();
        LogHelper::add('Menghapus data KTH');
        return redirect()->route('kth')->with('success', 'KTH berhasil dihapus.');
    }
}
