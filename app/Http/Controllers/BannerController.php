<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
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
        // return view('admin.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'status' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Upload file image
        // $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        // $request->file('image')->move(public_path('images'), $imageName);

        if ($request->hasFile('image')) {
            $documentPath = $request->file('image')->store('banners', 'public');
        }

        // Simpan data ke database
        Banner::create([
            'judul'       => $validated['judul'],
            'status'      => $validated['status'],
            'image'       => $documentPath,
            'id_pengguna' => Auth::guard('pengguna')->id(), // ini ambil id user yang login
        ]);

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
        $bannerEdit = Banner::findOrFail($id);
    $banner = Banner::all();
    return view('admin.banner.index', compact('banner', 'bannerEdit'));
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
            // Hapus gambar lama dari storage
            if (!empty($banner->image) && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }

            // Simpan gambar baru (sama seperti store)
            $documentPath = $request->file('e_image')->store('banners', 'public');
            $data['image'] = $documentPath;
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

        // Hapus file image di storage (folder public/banners)
        if (!empty($banner->image) && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        // Hapus data dari database
        $banner->delete();

        return redirect()->route('banner')->with('success', 'Data Berhasil Dihapus');
    }
}
