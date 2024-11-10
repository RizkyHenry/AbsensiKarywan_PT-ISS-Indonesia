<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Izin;
use App\Models\Absensi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TerimarequestController extends Controller
{
    public function index()
{
    // Get the currently authenticated user
    $user = Auth::user();

    // Retrieve all izin records
    $allIzin = Izin::all();

    // Retrieve all absensi records
    $contabsensi = Absensi::all();

    // Retrieve all users
    $contuser = User::all();

    // Pass the retrieved data to the view
    return view('admin.terimarequest', compact('user', 'allIzin', 'contabsensi', 'contuser'));
}



   public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'jenis_izin' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'required|string',
            'foto_bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Upload file foto bukti
        $path = $request->file('foto_bukti')->store('public/foto_bukti');

        // Ambil data user berdasarkan username
        $username = User::where('username', $request->username)->first();

        // Ambil data absensi berdasarkan ID user
        $absensi = Absensi::where('id', $username->id)->first();

        // Simpan data ke tabel izin
        Izin::create([
            'id_absensi' => $absensi->id_absensi,
            'jenis_izin' => $request->jenis_izin,
            'status' => $request->status, // Pastikan status tersedia dalam request
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keterangan' => $request->keterangan,
            'foto_bukti' => $path
        ]);

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Pengajuan berhasil diterima!');
    }
    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:Direquest,Diterima,Ditolak',
    ]);

    $izin = Izin::find($id);
    
    if ($izin) {
        $izin->status = $request->status;
        $izin->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }

    return redirect()->back()->with('error', 'Terjadi kesalahan. Coba lagi nanti.');
}
}
