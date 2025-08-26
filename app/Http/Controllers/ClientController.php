<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\GambaranUmum;
use App\Models\Kontak;
use App\Models\Subprogram;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\ReturnValueGenerator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gambaran = GambaranUmum::where('status', 'Aktif')->get();
        $banner = Banner::where('status', 'Aktif')->get();
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.index', compact('banner','gambaran', 'subprograms', 'contact'));
    }

    public function footer()
    {
        $contact = Kontak::all();
        return view('about', compact('contact'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
