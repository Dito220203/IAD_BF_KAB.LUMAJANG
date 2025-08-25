<?php

namespace App\Http\Controllers;

use App\Models\GambaranUmum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GambaranUmumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gambaran = GambaranUmum::all();
        return view('admin.GambaranUmum.index', compact('gambaran'));
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
        $data = $request->validate([
            'judul' => 'required',
            'uraian' => 'required',
            'status' => 'required',
        ]);

        GambaranUmum::create([
            'id_pengguna' => Auth::guard('pengguna')->id(),
            'judul' => $data['judul'],
            'uraian' => $data['uraian'],
            'status' => $data['status'],
        ]);

        return redirect()->route('gambaran')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = GambaranUmum::findOrFail($id);
        $request->validate([
            'e_judul' => 'required',
            'e_uraian' => 'required',
            'e_status' => 'required',
        ]);

        $data->update([
            'judul' => $request->input('e_judul'),
            'uraian' => $request->input('e_uraian'),
            'status' => $request->input('e_status'),
        ]);

        return redirect()->route('gambaran')->with('success', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        GambaranUmum::where('id', $id)->delete();
        return redirect()->route('gambaran')->with('success', 'Data Berhasil Dihapus');
    }
}
