<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
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
            LogHelper::add('Login Halaman Admin');
            return redirect()->intended('/admin'); // Sesuaikan tujuan redirect
        }

        return back()->withErrors([
            'username' => 'Username tidak ditemukan',
            'password' => 'Password salah'
        ]);
    }


    public function logout(Request $request)
    {
        LogHelper::add('Logout Halaman Admin');
        Auth::guard('pengguna')->logout(); // Logout user dari guard 'pengguna'

        $request->session()->invalidate(); // Hapus semua session
        $request->session()->regenerateToken(); // Buat CSRF token baru

        return redirect('/login');
    }

    public function update_password(Request $request)
    {


        $user = Auth::guard('pengguna')->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'errors' => ['current_password' => ['Password saat ini tidak sesuai']]
            ], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();
        LogHelper::add('Mengubah password');

        return response()->json([
            'status' => 'success',
            'message' => 'Password berhasil diubah'
        ]);
    }
}
