<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AktivitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {

    //     $log = LogAktivitas::with('pengguna')
    //         ->orderBy('id', 'desc')
    //        ->paginate(10);
    //     return view('admin.Aktivitas.index', compact('log'));
    // }

    public function index(Request $request)
{
    $search = $request->input('search');

    $query = LogAktivitas::with('pengguna')->orderBy('id', 'desc');

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('aktivitas', 'like', "%{$search}%")
              ->orWhere('ip', 'like', "%{$search}%")
              ->orWhere('waktu', 'like', "%{$search}%");
        })
        ->orWhereHas('pengguna', function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%");
        });
    }

    $log = $query->paginate(10);
    $log->appends($request->only('search'));

    return view('admin.Aktivitas.index', compact('log', 'search'));
}

}
