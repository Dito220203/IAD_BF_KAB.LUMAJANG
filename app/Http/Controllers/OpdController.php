<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $opd = Opd::all();
        return view('admin.Opd.index', compact('opd'));
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
        $validate = $request->validate([
            'nama' => 'required',
            'status' => 'required',
        ]);

        Opd::create($validate);
        return redirect()->route('opd')->with('success', 'Data Berhasil Ditambahkan');
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
        $opd = Opd::findOrFail($id);
        $request->validate([
            'e_nama' => 'required',
            'e_status' => 'required',
        ]);

        $opd->update([
            'nama' => $request->input('e_nama'),
            'status' => $request->input('e_status'),
        ]);

        return redirect()->route('opd')->with('success', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Opd::where('id', $id)->delete();
        return redirect()->route('opd')->with('success', 'Data Berhasil Dihapus');
    }
}
