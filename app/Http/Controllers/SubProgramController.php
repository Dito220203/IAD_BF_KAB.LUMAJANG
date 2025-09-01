<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\FotoSubprogram;
use App\Models\Subprogram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subprogram = Subprogram::all();
        return view('admin.Subprogram.index', compact('subprogram'));
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
            'program' => 'required',
            'subprogram' => 'required',
            'uraian' => 'required',
        ]);

        // Simpan data subprogram
        Subprogram::create([
            'id_pengguna' => Auth::guard('pengguna')->id(),
            'program' => $request->program,
            'subprogram' => $request->subprogram,
            'uraian' => $request->uraian,
        ]);
        LogHelper::add('Menambah data Subprogram');

        return redirect()->route('subprogram')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function storeProduk(Request $request)
    {
        $request->validate([
            'id_subprogram' => 'required|exists:subprograms,id',
            'nama_produk' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'foto' => 'required|image|max:2048',
        ]);

        $file = $request->file('foto')->store('produk', 'public');

        FotoSubprogram::create([
            'id_subprogram' => $request->id_subprogram,
            'nama_produk' => $request->nama_produk,
            'keterangan' => $request->keterangan,
            'foto' => $file,
        ]);

        return redirect()->back()->with('success', 'Produk Subprogram berhasil ditambahkan!');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validasi = Subprogram::findOrFail($id);
        $request->validate([
            'e_program' => 'required',
            'e_subprogram' => 'required',
            'e_uraian' => 'required',
        ]);

        $validasi->update([
            'program' => $request->input('e_program'),
            'subprogram' => $request->input('e_subprogram'),
            'uraian' => $request->input('e_uraian'),
        ]);
        LogHelper::add('Mengubah data Subprogram');
        return redirect()->route('subprogram')->with('success', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Subprogram::where('id', $id)->delete();
        LogHelper::add('Menghapus data Subprogram');
        return redirect()->route('subprogram')->with('success', 'Data Berhasil Dihapus');
    }
}
