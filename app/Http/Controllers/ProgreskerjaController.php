<?php

namespace App\Http\Controllers;

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
        $user->level == 'Admin' ? $progres = ProgresKerja::all() : $progres = ProgresKerja::where('id_pengguna',$user->id)->get();
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
        // Validasi input
        $validatedData = $request->validate([
            'subprogram' => 'required|exists:subprograms,id',
            'judul' => 'required|string|max:255',
            'tahun' => 'required|digits:4',
            'sumber_dana' => 'required|string|max:255',
            'jumlah_anggaran' => 'required|numeric',
            'penerima' => 'required|string|max:255',
            'uraian' => 'required|string',
            'latitude.*' => 'nullable|numeric',
            'longitude.*' => 'nullable|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'foto.max' => 'Gambar yang kamu aplud terlalu besar, batasan nya 2 MB',
        ]);

        // Simpan progres kerja
        $progres = ProgresKerja::create([
            'id_subprogram' => $validatedData['subprogram'],
            'id_pengguna'   => Auth::guard('pengguna')->id(),
            'judul'         => $validatedData['judul'],
            'tahun'         => $validatedData['tahun'],
            'sumber_dana'   => $validatedData['sumber_dana'],
            'jumlah_anggaran' => $validatedData['jumlah_anggaran'],
            'penerima'      => $validatedData['penerima'],
            'uraian'        => $validatedData['uraian'],
            'status'        => 'Belum Validasi',
        ]);

        // Simpan titik koordinat ke tabel map
        // Simpan titik koordinat ke tabel map
        if ($request->filled('latitude') && $request->filled('longitude')) {
            Map::create([
                'id_progres'  => $progres->id,
                'id_pengguna' => $progres->id_pengguna,
                'latitude'    => $request->latitude,
                'longitude'   => $request->longitude,
            ]);
        }


        // Simpan foto ke tabel foto_progres
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFile = $foto->getClientOriginalName(); // hanya nama file asli, misal: foto.jpg
            $foto->storeAs('foto_progres', $namaFile, 'public'); // simpan ke storage/app/public/foto_progres

            FotoProgres::create([
                'id_progres' => $progres->id,
                'id_pengguna' => $progres->id_pengguna,
                'foto' => $namaFile, // hanya nama file
            ]);
        }


        return redirect()->route('progres')->with('success', 'Data Berhasil Ditambahkan');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $progres = ProgresKerja::with('maps')->findOrFail($id);
        $subprogram = Subprogram::all();

        return view('admin.ProgresKerja.show', compact('progres', 'subprogram'));
    }


    public function validasi(string $id)
    {
        $progres = ProgresKerja::findOrFail($id);
        $progres->status = 'Valid';
        $progres->save();

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

        // update notifikasi: hilangkan angka "baru"
        // atau ganti status notifikasi menjadi "diba
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
            'subprogram' => 'required|exists:subprograms,id',
            'judul' => 'required|string|max:255',
            'tahun' => 'required|digits:4',
            'sumber_dana' => 'required|string|max:255',
            'jumlah_anggaran' => 'required|numeric',
            'penerima' => 'required|string|max:255',
            'uraian' => 'required|string',
            'status' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'latitude.*' => 'nullable|numeric',
            'longitude.*' => 'nullable|numeric',
        ], [
            'foto.max' => 'Gambar yang kamu aplud terlalu besar, batasan nya 2 MB',
        ]);

        $progres = ProgresKerja::findOrFail($id);
        $progres->update([
            'id_subprogram' => $validatedData['subprogram'],
            'judul' => $validatedData['judul'],
            'tahun' => $validatedData['tahun'],
            'sumber_dana' => $validatedData['sumber_dana'],
            'jumlah_anggaran' => $validatedData['jumlah_anggaran'],
            'penerima' => $validatedData['penerima'],
            'uraian' => $validatedData['uraian'],
            'status' => $request->input('status', 'Belum Validasi'),
        ]);

        // 🔹 Update Koordinat
        if ($request->has('latitude') && $request->has('longitude')) {
            // Hapus map lama dulu
            $progres->maps()->delete();

            // Buat data baru
            if (!empty($request->latitude) && !empty($request->longitude)) {
                Map::create([
                    'id_progres'  => $progres->id,
                    'id_pengguna' => $progres->id_pengguna,
                    'latitude'    => $request->latitude,
                    'longitude'   => $request->longitude,
                ]);
            }
        }



        // 🔹 Update Foto (sudah benar)
        if ($request->hasFile('foto')) {
            $fotoBaru = $request->file('foto');
            $namaFile = time() . '_' . $fotoBaru->getClientOriginalName();
            $fotoBaru->storeAs('foto_progres', $namaFile, 'public');

            $fotoProgres = $progres->fotoProgres()->first();
            if ($fotoProgres) {
                if ($fotoProgres->foto && Storage::disk('public')->exists('foto_progres/' . $fotoProgres->foto)) {
                    Storage::disk('public')->delete('foto_progres/' . $fotoProgres->foto);
                }
                $fotoProgres->update([
                    'foto' => $namaFile,
                ]);
            } else {
                FotoProgres::create([
                    'id_progres'  => $progres->id,
                    'id_pengguna' => $progres->id_pengguna,
                    'foto'        => $namaFile,
                ]);
            }
        }

        return redirect()->route('progres')->with('success', 'Data berhasil diperbarui');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $progres = ProgresKerja::findOrFail($id);

        // Hapus foto dari storage dan tabel foto_progres
        $fotoProgres = FotoProgres::where('id_progres', $progres->id)->first();
        if ($fotoProgres) {
            $path = 'foto_progres/' . $fotoProgres->foto;

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            $fotoProgres->delete();
        }

        // Hapus progres kerja
        $progres->delete();

        return redirect()->route('progres')->with('success', 'Data Berhasil Dihapus');
    }
}
