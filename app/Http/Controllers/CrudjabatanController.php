<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class CrudjabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::all(); // Ambil semua data jabatan
        $user = Auth::user();
        return view('admin/crudjabatan', compact('jabatans', 'user')); // Kirim variabel ke tampilan
    }
    

    public function create()
    {
        $jabatans = Jabatan::all();
        return view('admin/crudjabatan.create', compact('jabatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jabatan' => 'required|string|max:255',
        ]);

        Jabatan::create($request->all());
        return redirect()->back()->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function update(Request $request, $jabatan)
    {
        $request->validate([
            'jabatan' => 'required|string|max:255',
        ]);

        $jabatans = Jabatan::findOrFail($jabatan);
        $jabatans->update($request->all());
        return redirect()->back()->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();
        return redirect()->back()->with('success', 'Jabatan berhasil dihapus.');
    }
}
