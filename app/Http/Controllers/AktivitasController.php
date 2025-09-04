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
    public function index()
    {

        $log = LogAktivitas::with('pengguna')
            ->orderBy('id', 'desc')
           ->paginate(10);
        return view('admin.Aktivitas.index', compact('log'));
    }
}
