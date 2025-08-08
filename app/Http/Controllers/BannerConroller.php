<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerConroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banner = Banner::all();
        return view('admin.banner.index', compact('banner'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi termasuk image wajib
        $validated = $request->validate([
            'judul' => 'required',
            'status' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Upload file image terlebih dahulu
        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('images'), $imageName);

        // Simpan data awal ke database dengan image
        $validated = Banner::create([
            'judul' => $validated['judul'],
            'status' => $validated['status'],
            'image' => $imageName,
        ]);

        // Tidak perlu create lagi, cukup simpan satu kali
        // Tidak perlu lagi:
        // $banner = Banner::create($request->all());

        return redirect()->route('banner')->with('success', 'Data Berhasil Ditambahkan');
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
        $banner = Banner::findOrFail($id);
        return view('admin.banner.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner = Banner::findOrFail($id);

        // Validasi
        $request->validate([
            'e_judul' => 'required',
            'e_status' => 'required',
            'e_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $data = [
            'judul' => $request->input('e_judul'),
            'status' => $request->input('e_status'),
        ];

        if ($request->hasFile('e_image')) {
            // Hapus gambar lama jika ada
            $oldImagePath = public_path('images/' . $banner->image);
            if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                unlink($oldImagePath);
            }

            // Simpan gambar baru
            $imageName = time() . '_' . $request->file('e_image')->getClientOriginalName();
            $request->file('e_image')->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }

        $banner->update($data);

        return redirect()->route('banner')->with('success', 'Data Berhasil Diupdate');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);

        // Hapus file gambar dari folder public/images
        $imagePath = public_path('images/' . $banner->image);
        if (file_exists($imagePath) && is_file($imagePath)) {
            unlink($imagePath);
        }

        // Hapus data dari database
        $banner->delete();

        return redirect()->route('banner')->with('success', 'Data Berhasil Dihapus');
    }
}
