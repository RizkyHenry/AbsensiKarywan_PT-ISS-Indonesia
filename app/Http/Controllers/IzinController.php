<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Izin; // Pastikan model Izin sudah ada
use App\Models\Absensi;
use App\Models\User;

class IzinController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('user.izin', compact('user'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Diterima,Ditolak',
        ]);

        $izin = Izin::find($id);

        if ($izin) {
            $izin->status = $request->status;
            $izin->save();

            // Jika status diperbarui menjadi "Disetujui", buat entri baru di tabel absensis
            if ($request->status == 'Disetujui') {
                $user = User::find($izin->user_id); // Assuming user_id exists in Izin model
                
                // Cek jenis izin dan atur kehadiran_absen berdasarkan jenis izin
                $kehadiranAbsen = $izin->jenis_izin === 'sakit' ? 'Sakit' : 'Izin';

                // Buat entri baru di tabel absensis
                Absensi::create([
                    'id_jabatan' => $user->id_jabatan,
                    'kehadiran_absen' => $kehadiranAbsen,
                    'id' => $user->id,
                    'tanggal_absen' => now(), // Atur ke tanggal saat ini atau sesuai kebutuhan
                    'id_detail' => $izin->id_detail ?? null,
                    'foto_selfie' => $izin->foto_bukti, // Salin foto bukti izin sebagai foto selfie absen
                ]);
            }

            return redirect()->back()->with('success', 'Status berhasil diperbarui');
        }

        return redirect()->back()->with('error', 'Terjadi kesalahan. Coba lagi nanti.');
    }

    public function showBukti($id_izin)
    {
        $izin = Izin::findOrFail($id_izin);

        if ($izin->foto_bukti) {
            // Gunakan asset() untuk mengakses file dengan benar
            return response()->redirectTo(asset('storage/' . $izin->foto_bukti));
        } else {
            return redirect()->back()->with('error', 'Bukti izin tidak ditemukan.');
        }
    }



    public function store(Request $request)
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        $request->validate([
            'jenis_izin' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'required|string',
            'foto_bukti' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan foto bukti ke dalam folder public/izin_bukti
        $fotoBuktiPath = $request->file('foto_bukti')->store('public/izin_bukti');
        // Gunakan path relatif untuk disimpan di database
        $fotoBuktiUrl = str_replace('public/', 'storage/', $fotoBuktiPath);

        $absensi = Absensi::where('id', $user->id)->first();

        // Simpan data izin ke dalam database
        Izin::create([
            'id_absensi' => $absensi->id_absensi, // Pastikan ini sesuai dengan id pengguna yang sesuai
            'jenis_izin' => $request->jenis_izin,
            'status' => 'Direquest', // Set status ke "Direquest"
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keterangan' => $request->keterangan,
            'foto_bukti' => $fotoBuktiUrl,
        ]);

        return redirect()->route('izin.index')->with('success', 'Pengajuan izin berhasil diajukan.');
    }

}
