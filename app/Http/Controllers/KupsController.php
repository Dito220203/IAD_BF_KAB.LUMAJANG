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
   public function index(Request $request)
{
    $search = $request->input('search');

    $query = Kups::query();

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('kups', 'like', "%{$search}%")
              ->orWhere('kategori', 'like', "%{$search}%")
              ->orWhere('tahun', 'like', "%{$search}%")
              ->orWhere('pendapatan', 'like', "%{$search}%");
        })
        ->orWhereHas('penggunas', function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%");
        })
        ->orWhereHas('kth', function ($q) use ($search) {
            $q->where('kth', 'like', "%{$search}%")
              ->orWhere('kecamatan', 'like', "%{$search}%")
              ->orWhere('desa', 'like', "%{$search}%");
        });
    }

    $kups = $query->paginate(5);
    $kups->appends($request->only('search'));

    $kth = Kth::where('delete_at', '0')->get();

    return view('admin.Kups.index', compact('kups', 'kth', 'search'));
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
        $kups = Kups::with('kth')->paginate(10);
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
