<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $video = Video::all();
        return view('admin.Video.index', compact('video'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.Video.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valiadate = $request->validate([
            'judul' => 'required',
            'link' => 'required',
        ]);

        Video::create($valiadate);
        return redirect()->route('video')->with('success', 'Data Berhasil Ditambahkan');
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
         $video = Video::findOrFail($id);
        return view('admin.Video.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Video::findOrFail($id);
        $request->validate([
            'e_judul' => 'required',
            'e_link' => 'required',
        ]);

        $validate->update([
            'judul' => $request->input('e_judul'),
            'link' => $request->input('e_link'),
        ]);

        return redirect()->route('video')->with('success', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Video::where('id', $id)->delete();
        return redirect()->route('gambaran')->with('success', 'Data Berhasil Dihapus');
    }
}
