<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SessionController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan username
        $user = User::where('username', $request->username)->first();

       
        // Cek apakah user ada dan password cocok dengan hash bcrypt
        if ($user && Hash::check($request->password, $user->password)) {
            // Login user
            Auth::login($user);
            $request->session()->regenerate();
        
           // Cek role user
            if ($user->role === 'admin') {
                \Log::info('Role Admin Terdeteksi');
                return redirect()->route('dashboard')->with('success', 'Login berhasil sebagai admin!');
            } elseif ($user->role === 'karyawan') {
                \Log::info('Role Karyawan Terdeteksi');
                return redirect()->route('formuser')->with('success', 'Login berhasil sebagai karyawan!');
            } else {
                Auth::logout();
                return redirect()->route('loginForm')->withErrors([
                    'username' => 'Role tidak dikenali.',
                ]);
            }
        }

        // Kembalikan error jika login gagal
        return back()->with('fail', 'Username atau password salah.')->onlyInput('username');
    }
    
    
    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('loginForm')->with('success', 'Anda berhasil logout.');
    }
}
