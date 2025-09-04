<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\FotoProgres;
use App\Models\Map;
use App\Models\Notifikasi;
use App\Models\Pengguna;
use App\Models\ProgresKerja;
use App\Models\Subprogram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProgreskerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard('pengguna')->user();
        $user->level == 'Super Admin' ? $progres = ProgresKerja::all() : $progres = ProgresKerja::where('id_pengguna', $user->id)->get();
        return view('admin.ProgresKerja.index', compact('progres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subprogram = Subprogram::all();
        return view('admin.ProgresKerja.create', compact('subprogram'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi
        $validatedData = $request->validate([
            'subprogram'       => 'required|exists:subprograms,id',
            'judul'            => 'required|string|max:255',
            'tahun'            => 'required|digits:4',
            'sumber_dana'      => 'required|string|max:255',
            'jumlah_anggaran'  => 'required|numeric',
            'penerima'         => 'required|string|max:255',
            'uraian'           => 'required|string',
            'latitude'         => 'nullable|numeric',
            'longitude'        => 'nullable|numeric',
            'foto.*'           => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'foto.*.max' => 'Setiap foto maksimal 2MB.',
        ]);

        // Simpan progres kerja
        $progres = ProgresKerja::create([
            'id_subprogram'     => $validatedData['subprogram'],
            'id_pengguna'       => Auth::guard('pengguna')->id(),
            'judul'             => $validatedData['judul'],
            'tahun'             => $validatedData['tahun'],
            'sumber_dana'       => $validatedData['sumber_dana'],
            'jumlah_anggaran'   => $validatedData['jumlah_anggaran'],
            'penerima'          => $validatedData['penerima'],
            'uraian'            => $validatedData['uraian'],
            'status'            => 'Belum Validasi',
        ]);

        // Simpan titik koordinat
        if ($request->filled(['latitude', 'longitude'])) {
            Map::create([
                'id_progres'  => $progres->id,
                'id_pengguna' => $progres->id_pengguna,
                'latitude'    => $request->latitude,
                'longitude'   => $request->longitude,
            ]);
        }

        // Simpan banyak foto
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $namaFile = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('foto_progres', $namaFile, 'public');

                FotoProgres::create([
                    'id_progres'  => $progres->id,
                    'id_pengguna' => $progres->id_pengguna,
                    'foto'        => $namaFile,
                ]);
            }
        }

        LogHelper::add('Menambah data Progres Kerja');
        return redirect()->route('progres')->with('success', 'Data Berhasil Ditambahkan');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $progres = ProgresKerja::with('maps')->findOrFail($id);
        $subprogram = Subprogram::all();
        LogHelper::add('Melihat detail data Progres Kerja');
        return view('admin.ProgresKerja.show', compact('progres', 'subprogram'));
    }


    public function validasi(string $id)
    {
        $progres = ProgresKerja::findOrFail($id);
        $progres->status = 'Valid';
        $progres->save();
        LogHelper::add('Memvalidasi data Progres Kerja');
        return redirect()->route('progres')->with('success', 'Status berhasil divalidasi');
    }
    public function updateStatus(Request $request, string $id)
    {
        $progres = ProgresKerja::findOrFail($id);

        // ganti status progres
        if ($progres->status === 'Valid') {
            $progres->status = 'Belum Validasi';
        } else {
            $progres->status = 'Valid';
        }
        $progres->save();

        LogHelper::add('Mengubah status data Progres Kerja');
        return redirect()->route('progres')->with('success', 'Status berhasil diperbarui');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $progres = ProgresKerja::findOrFail($id);
        $subprogram = Subprogram::all();

        return view('admin.ProgresKerja.update', compact('progres', 'subprogram'));
    }

    /**
     * Update the specified resource in storage.
     */
 public function update(Request $request, string $id)
{
    $validatedData = $request->validate([
        'subprogram'      => 'required|exists:subprograms,id',
        'judul'           => 'required|string|max:255',
        'tahun'           => 'required|digits:4',
        'sumber_dana'     => 'required|string|max:255',
        'jumlah_anggaran' => 'required|numeric',
        'penerima'        => 'required|string|max:255',
        'uraian'          => 'required|string',
        'status'          => 'nullable|string',
        'latitude'        => 'nullable|numeric',
        'longitude'       => 'nullable|numeric',
        'foto.*'          => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        'foto_lama.*'     => 'nullable|exists:foto_progres,id',
    ], [
        'foto.*.max' => 'Setiap foto maksimal 2MB.',
    ]);

    $progres = ProgresKerja::findOrFail($id);
    $progres->update([
        'id_subprogram'   => $validatedData['subprogram'],
        'judul'           => $validatedData['judul'],
        'tahun'           => $validatedData['tahun'],
        'sumber_dana'     => $validatedData['sumber_dana'],
        'jumlah_anggaran' => $validatedData['jumlah_anggaran'],
        'penerima'        => $validatedData['penerima'],
        'uraian'          => $validatedData['uraian'],
        'status'          => $request->input('status', 'Belum Validasi'),
    ]);

    // Update Map
    $progres->maps()->delete();
    if ($request->filled(['latitude', 'longitude'])) {
        Map::create([
            'id_progres'  => $progres->id,
            'id_pengguna' => $progres->id_pengguna,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
        ]);
    }

    // ====================== FOTO ======================
    // Hapus foto lama yang tidak dikirim lagi dari form
    $fotoLamaIds = $request->input('foto_lama', []);
    $fotoProgresAll = $progres->fotoProgres()->get();

    foreach ($fotoProgresAll as $foto) {
        if (!in_array($foto->id, $fotoLamaIds)) {
            $path = 'foto_progres/' . $foto->foto;
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $foto->delete();
        }
    }

    // Simpan foto baru jika ada
    if ($request->hasFile('foto')) {
        foreach ($request->file('foto') as $file) {
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('foto_progres', $namaFile, 'public');

            FotoProgres::create([
                'id_progres'  => $progres->id,
                'id_pengguna' => $progres->id_pengguna,
                'foto'        => $namaFile,
            ]);
        }
    }

    LogHelper::add('Memperbarui data Progres Kerja');
    return redirect()->route('progres')->with('success', 'Data berhasil diperbarui');
}



    public function destroy(string $id)
    {
        $progres = ProgresKerja::findOrFail($id);

        // Hapus semua foto
        $fotoProgres = FotoProgres::where('id_progres', $progres->id)->get();
        foreach ($fotoProgres as $foto) {
            $path = 'foto_progres/' . $foto->foto;
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $foto->delete();
        }

        $progres->delete();
        LogHelper::add('Menghapus data Progres Kerja');
        return redirect()->route('progres')->with('success', 'Data Berhasil Dihapus');
    }
}
