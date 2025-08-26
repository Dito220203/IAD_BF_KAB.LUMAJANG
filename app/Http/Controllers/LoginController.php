<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.Login.index');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::guard('pengguna')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin'); // Sesuaikan tujuan redirect
        }

        return back()->withErrors([
            'username' => 'Username tidak ditemukan',
            'password' => 'Password salah'
        ]);
    }


    public function logout(Request $request)
    {
        Auth::guard('pengguna')->logout(); // Logout user dari guard 'pengguna'

        $request->session()->invalidate(); // Hapus semua session
        $request->session()->regenerateToken(); // Buat CSRF token baru

        return redirect('/');
    }



}
