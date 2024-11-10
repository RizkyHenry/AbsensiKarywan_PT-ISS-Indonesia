<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Menggunakan model User
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Jabatan; // Pastikan model Jabatan di-import

class KaryawanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $karyawan = User::all();
        $jabatans = Jabatan::all(); // Ambil semua data jabatan
        return view('admin.crudkaryawan', compact('karyawan','jabatans', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|max:255',
            'password' => 'required|min:8',
            'role' => 'required',
            'id_jabatan' => 'required',
           'nik' => 'required|min:16',       // Validasi NIK unik
            'kelamin' => 'required|in:L,P',             // Validasi kelamin (Laki-laki atau Perempuan)
        ]);
    
        $userexist = User::where('username', $request->username)->first();
        
        if($userexist) {
            return redirect()->back()->with('error', 'Username sudah digunakan.');
        }
    
        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role, 
            'id_jabatan' => $request->id_jabatan,
            'nik' => $request->nik,
            'kelamin' => $request->kelamin,
        ]);
    
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }
    
    

    public function update(Request $request, $id)
    {
        \Log::info($request->all()); // Untuk debugging
        
        $request->validate([
            'username' => 'required|string|max:255',
            'role' => 'required|string',
            'id_jabatan' => 'required|integer',
            'nik' => 'required|min:16', 
            'kelamin' => 'required|in:L,P',
            // Password tidak wajib diisi jika tidak ingin diubah
            'password' => 'nullable|string|min:8', 
        ]);
    
        $user = User::findOrFail($id);
        $user->username = $request->username;
        $user->role = $request->role;
        $user->id_jabatan = $request->id_jabatan;
        $user->nik = $request->nik;
        $user->kelamin = $request->kelamin;
    
        // Hanya update password jika field diisi
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
    
        $user->save();
    
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil diperbarui.');
    }
    
    

    public function destroy(Request $request)
    {
        $id = $request->id;

        $user = User::findOrFail($id);
        $user->delete();
    
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
    }

    public function create()
    {
        $jabatans = Jabatan::all(); // Ambil semua data jabatan
        return view('admin.crudkaryawan', compact('jabatans')); // Kirim variabel ke tampilan
    }

    public function edit(Request $request)
    {
        $id = $request->id;

        $karyawan = User::findOrFail($id); // Ambil satu karyawan berdasarkan ID
        $jabatans = Jabatan::all(); // Ambil semua jabatan
        return view('admin.crudkaryawan.edit', compact('karyawan', 'jabatans'));
    }
}    
