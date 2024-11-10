<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Jabatan; // Don't forget to import the model

use Illuminate\Support\Facades\Auth;

class CrudjadwalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $jadwals = Jadwal::with('jabatan')->get()->map(function ($jadwal) {
            return [
                'id_jadwal' => $jadwal->id_jadwal,
                'jabatan' => $jadwal->jabatan->jabatan,
                'jadwal_hadir' => date('H:i', strtotime($jadwal->jadwal_hadir)),
                'jadwal_pulang' => date('H:i', strtotime($jadwal->jadwal_pulang)),
            ];
        });
        $jadwals = Jadwal::all(); // Retrieve all jadwals
        $jabatans = Jabatan::all(); // Retrieve all jabatans

        return view('admin.crudjadwal', compact('jadwals', 'jabatans', 'user')); // Pass both variables to the view
    }

    public function create()
    {
        $jabatans = Jabatan::all(); // Retrieve all jabatans

        return view('admin.crudjadwal.create', compact('jabatans')); // If you have a separate create view
    }

    public function store(Request $request)
    {
        // Validate your request here if needed

        $jadwal = new Jadwal;
        $jadwal->jadwal_hadir = $request->jadwal_hadir;
        $jadwal->jadwal_pulang = $request->jadwal_pulang;
        $jadwal->id_jabatan = $request->id_jabatan;
        $jadwal->save();

        return redirect()->route('crudjadwal.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jabatans = Jabatan::all(); // Ambil semua jabatan untuk dropdown

        return view('admin.crudjadwal.edit', compact('jabatans')); // Pastikan view yang benar
    }


    public function update(Request $request, $id_jadwal)
    {
        // Cari data jadwal berdasarkan id_jadwal
        $jadwal = Jadwal::findOrFail($id_jadwal);

        // Update data jadwal dengan input dari form
        $jadwal->update([
            'jadwal_hadir' => $request->input('jadwal_hadir'),
            'jadwal_pulang' => $request->input('jadwal_pulang'),
            'id_jabatan' => $request->input('id_jabatan'),
        ]);

        return redirect()->route('crudjadwal.index')->with('success', 'Jadwal berhasil diupdate');
    }



    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('crudjadwal.index')->with('success', 'Jadwal berhasil dihapus!');
    }
}
