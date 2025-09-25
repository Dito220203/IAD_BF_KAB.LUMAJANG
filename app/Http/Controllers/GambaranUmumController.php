<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\GambaranUmum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GambaranUmumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index(Request $request)
{
    $search = $request->input('search');

    $query = GambaranUmum::query();

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('judul', 'like', "%{$search}%")
              ->orWhere('uraian', 'like', "%{$search}%")
              ->orWhere('status', 'like', "%{$search}%");
        })
        ->orWhereHas('penggunas', function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%");
        });
    }

    $gambaran = $query->paginate(10);
    $gambaran->appends($request->only('search'));

    return view('admin.GambaranUmum.index', compact('gambaran', 'search'));
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
        LogHelper::add('Menambah data Gambaran Umum');
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
        LogHelper::add('Mengubah data Gambaran Umum');

        return redirect()->route('gambaran')->with('success', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        GambaranUmum::where('id', $id)->delete();
        LogHelper::add('Menghapus data Gambaran Umum');
        return redirect()->route('gambaran')->with('success', 'Data Berhasil Dihapus');
    }
}
