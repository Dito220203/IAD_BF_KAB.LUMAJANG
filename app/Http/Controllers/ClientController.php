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
        return view('client.index', compact('banner', 'gambaran', 'subprograms', 'contact'));
    }


    //navbar

    public function tentangkegiatan(){
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.tentangkegiatan', compact('contact', 'subprograms')); 
    }
    public function rencanakegiatan(){
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.rencanakegiatan', compact('contact', 'subprograms')); 
    }
    public function progreskegiatan(){
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.progreskegiatan', compact('contact', 'subprograms')); 
    }
    //sub progres kgiatan
    public function progreskegiatandetail(){
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.progreskegiatandetail', compact('contact', 'subprograms')); 
    }
    public function monev(){
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.monev', compact('contact', 'subprograms')); 
    }
    public function petasebarankegiatan(){
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.petasebarankegiatan', compact('contact', 'subprograms')); 
    }


    public function profilkawasan(){
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.profilkawasan', compact('contact', 'subprograms')); 
    }
    //sub profil kawasanadetail
    public function profilkawasandetail(){
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.profilkawasandetail', compact('contact', 'subprograms')); 
    }


    public function detailluasperhutanan(){
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.detailluasperhutanan', compact('contact', 'subprograms')); 
    }
    public function detailkth_kups(){
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.detailkth_kups', compact('contact', 'subprograms')); 
    }
    public function detailekonomi(){
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.detailekonomi', compact('contact', 'subprograms')); 
    }


    //detail informasi &video
    public function detailinformasi(){
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.detailinformasi', compact('contact', 'subprograms')); 
    }
    public function detailvideo(){
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.detailvideo', compact('contact', 'subprograms')); 
    }







    // detail card index
    public function regulasi()
    {
        $contact = Kontak::all();
        $subprograms = Subprogram::all();
        return view('client.regulasi', compact('contact', 'subprograms'));
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
