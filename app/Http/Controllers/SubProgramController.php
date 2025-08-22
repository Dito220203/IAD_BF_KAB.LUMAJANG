<?php

namespace App\Http\Controllers;

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
        $validasi = $request->validate([
            'program' => 'required',
            'subprogram' => 'required',
            'uraian' => 'required',
        ]);

        Subprogram::create([
             'id_pengguna' => Auth::guard('pengguna')->id(),
            'program' => $validasi['program'],
            'subprogram' => $validasi['subprogram'],
            'uraian' => $validasi['uraian'],
        ]);

        return redirect()->route('subprogram')->with('success', 'Data Berhasil Ditambahkan');
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

        return redirect()->route('subprogram')->with('success', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Subprogram::where('id', $id)->delete();
        return redirect()->route('subprogram')->with('success', 'Data Berhasil Dihapus');
    }
}
