<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use Illuminate\Http\Request;

class ControllerDetail extends Controller
{
    // Menampilkan daftar detail
    public function index()
    {
        $details = Detail::all(); // Mengambil semua data absensi dari tabel `details`
        return view('user.absenkaryawan', compact('details')); // Ganti 'your_view_name' dengan nama file blade kamu
    }

    // Menampilkan form tambah detail
    public function create()
    {
        return view('details.create');
    }

    // Menyimpan data detail baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'foto_selfie' => 'required|string',
          
            'hadir_datang' => 'required|date_format:H:i', // Gunakan format waktu yang sesuai
            'hadir_pulang' => 'required|date_format:H:i',
        ]);

        // Membuat detail baru di database
        Detail::create($validatedData);
        return redirect()->route('details.index')->with('success', 'Detail berhasil ditambahkan!');
    }

    // Menampilkan detail
    public function show($id)
    {
        // Ambil detail berdasarkan absensi ID
        $detail = Detail::where('id_detail', $id)->firstOrFail();
        
        // Kembalikan data detail dalam format JSON
        return response()->json([
            'detail' => $detail
        ]);
    }

    // Menampilkan form edit detail
    public function edit($id)
    {
        $detail = Detail::findOrFail($id);
        return view('details.edit', compact('detail'));
    }

    // Mengupdate data detail
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'foto_selfie' => 'required|string',
       
            'hadir_datang' => 'required|date_format:H:i', // Gunakan format waktu yang sesuai
            'hadir_pulang' => 'required|date_format:H:i',
        ]);

        // Mengupdate detail di database
        $detail = Detail::findOrFail($id);
        $detail->update($validatedData);
        return redirect()->route('details.index')->with('success', 'Detail berhasil diupdate!');
    }

    // Menghapus data detail
    public function destroy($id)
    {
        $detail = Detail::findOrFail($id);
        $detail->delete();
        return redirect()->route('details.index')->with('success', 'Detail berhasil dihapus!');
    }
}
