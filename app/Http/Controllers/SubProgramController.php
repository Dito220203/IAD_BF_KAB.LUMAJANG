<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\FotoSubprogram;
use App\Models\Subprogram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = FotoSubprogram::with('subprogram')->get();
        $subprogram = Subprogram::all();
        return view('admin.Subprogram.index', compact('subprogram','produk'));
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
            'judul' => 'required',
            'keterangan' => 'nullable',
            'foto' => 'required|image|max:2048',
        ]);


        $filePath = $request->file('foto')->store('produk', 'public');

        FotoSubprogram::create([
            'id_pengguna' => Auth::guard('pengguna')->id(),
            'id_subprogram' => $request->id_subprogram,
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
            'foto' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Produk Subprogram berhasil ditambahkan!');
    }

    public function updateProduk(Request $request, string $id)
    {
        $produk = FotoSubprogram::findOrFail($id);

        // Validasi
        $request->validate([
            'e_id_subprogram' => 'required|exists:subprograms,id',
            'e_judul' => 'required',
            'e_keterangan' => 'nullable',
            'e_foto' => 'nullable|image|max:2048', // foto opsional, max 2MB
        ]);

        // Siapkan data update
        $data = [
            'id_subprogram' => $request->input('e_id_subprogram'),
            'judul' => $request->input('e_judul'),
            'keterangan' => $request->input('e_keterangan'),
        ];

        // Jika ada foto baru
        if ($request->hasFile('e_foto')) {
            $fileName = time() . '_' . $request->file('e_foto')->getClientOriginalName();
            $request->file('e_foto')->storeAs('produk', $fileName, 'public');

            // Hapus file lama
            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }

            $data['foto'] = 'produk/' . $fileName;
        }

        $produk->update($data);

        return redirect()->back()->with('success', 'Produk Subprogram berhasil diperbarui!');
    }





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

    public function destroyProduk(string $id)
    {
        $produk = FotoSubprogram::findOrFail($id);

        if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return redirect()->back()->with('success', 'Produk Subprogram berhasil dihapus!');
    }
}
