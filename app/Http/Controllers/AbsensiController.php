<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Jabatan;
use App\Models\Detail;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    // Menampilkan daftar absensi
    // Your controller remains the same, as it retrieves a collection of Absensi.
    public function index()
    {
        $user = Auth::user();

        // Ensure the user has a valid id_jabatan
        if (!$user || is_null($user->id_jabatan)) {
            return redirect()->back()->with('error', 'User tidak memiliki jabatan yang valid.');
        }

        // Retrieve absensi records for the user's jabatan, along with related detail data
        $absensi = Absensi::where('id', $user->id) // Adjust this to ensure it's correct (user_id should be your foreign key)
            ->with('detail', 'jabatan')  // Load the related 'detail' and 'jabatan' data
            ->get();

        // Debugging: Log the content of $absensi
        \Log::info('Absensi data for user: ' . $user->id, ['absensi' => $absensi]);

        // Check if the absensi data is empty
        if ($absensi->isEmpty()) {
            \Log::info('ga ada data untuk absensi ini : ' . $user->id);
        }

        // Ambil data jabatan pengguna berdasarkan id_jabatan mereka
        $jabatan = Jabatan::find($user->id_jabatan);
        $currentTime = Carbon::now();

        // Pastikan jabatan ada dan ambil jadwal terbaru
        $latestJadwal = null;
        if ($jabatan) {
            // Retrieve the latest Jadwal for the jabatan
            $latestJadwal = Jadwal::where('id_jabatan', $user->id_jabatan)->latest()->first();
        }

        // If there is no Jadwal, you can return a message or a fallback value here
        if (!$latestJadwal) {
            \Log::info('No jadwal found for jabatan: ' . $user->id_jabatan);
        }

        // Kirim data yang diperlukan ke tampilan
        return view('user.absenkaryawan', compact('absensi', 'jabatan', 'user', 'latestJadwal', 'currentTime'));
    }

    public function getCalendarData()
    {
        $user = Auth::user();
    
        // 1. Fetch all tap-in dates with different statuses
        $tapInDates = Absensi::where('id', $user->id)
            ->whereNotNull('tanggal_absen')
            ->get(['tanggal_absen', 'kehadiran_absen'])
            ->map(function ($absensi) {
                $status = $absensi->kehadiran_absen;
                $color = match ($status) {
                    'hadir' => 'green',
                    'telat' => 'orange',
                    'alpha' => 'red',
                    default => 'blue'
                };
                return [
                    'date' => $absensi->tanggal_absen,
                    'status' => $status,
                    'color' => $color
                ];
            });
    
        // 2. Fetch leave or sick dates from izin data in the Absensi model
        $leaveOrSickDates = Absensi::where('id', $user->id)
            ->whereNotNull('tanggal_mulai')
            ->whereNotNull('tanggal_selesai')
            ->get(['tanggal_mulai', 'tanggal_selesai'])
            ->flatMap(function ($izin) {
                $dates = [];
                $startDate = Carbon::parse($izin->tanggal_mulai);
                $endDate = Carbon::parse($izin->tanggal_selesai);
    
                // Iterate over each day in the izin range
                for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                    $dates[] = [
                        'date' => $date->toDateString(),
                        'status' => 'izin', // yellow for leave or sick days
                        'color' => 'yellow'
                    ];
                }
                return $dates;
            });
    
        // 3. Merge all date data without duplicates
        $calendarData = $tapInDates->merge($leaveOrSickDates)->unique('date');
    
        // Return as JSON for frontend
        return response()->json($calendarData);
    }
    

    public function store(Request $request)
    {
        $userId = $request->user()->id; // Ambil ID user
        $today = now()->format('Y-m-d');

        $hasCheckedInToday = Absensi::where('id', $userId)
            ->whereDate('tanggal_absen', $today)
            ->exists();

        // Jika sudah ada absensi hari ini, kembalikan dengan pesan error
        if ($hasCheckedInToday) {
            return redirect()->back()->with('error', 'Anda sudah absen hari ini.');
        }

        // Cek apakah sudah melakukan absensi hadir hari ini
        $existingAbsensi = Absensi::where('id', Auth::id())
            ->whereDate('tanggal_absen', $request->tanggal_absen)
            ->first();

        // Logika untuk tap in
        if (!$existingAbsensi) {
            // Ambil jadwal terkait
            $jabatan = Jabatan::findOrFail($request->id_jabatan);
            $latestJadwal = $jabatan->jadwals()->latest()->first();

            $currentTime = Carbon::now('Asia/Jakarta');
            $hadirThreshold = Carbon::parse($latestJadwal->jadwal_hadir, 'Asia/Jakarta');

            // Telat dan alpha thresholds
            $telatThreshold = $hadirThreshold->copy()->setTime(8, 30, 0);
            $alphaThreshold = $hadirThreshold->copy()->setTime(24, 0, 0);

            // Menentukan status kehadiran
            if ($currentTime->lessThanOrEqualTo($hadirThreshold)) {
                $kehadiran_absen = 'hadir';
            } elseif ($currentTime->between($hadirThreshold, $telatThreshold)) {
                $kehadiran_absen = 'telat';
            } else {
                $kehadiran_absen = 'alpha'; // Auto alpha jika lewat waktu pulang
            }

            // Upload file foto
            $fotoPath = $request->file('foto_selfie')->store('foto_selfie', 'public');

            $detail = Detail::create([
                'foto_selfie' => $fotoPath,
                'hadir_datang' => $request->tanggal_absen,

            ]);

            // Buat data absensi baru
            Absensi::create([
                'id' => Auth::id(), // Menyimpan id user yang sedang login
                'id_jabatan' => $request->id_jabatan,
                'id_detail' => $detail->id_detail,
                'kehadiran_absen' => $kehadiran_absen, // Set status kehadiran
                'tanggal_absen' => $request->tanggal_absen,
            ]);

            // Redirect atau beri pesan sukses
            return redirect()->back()->with('success', 'Absensi berhasil disimpan!');
        } else {
            return redirect()->back()->with('error', 'Anda sudah melakukan absensi hari ini.');
        }
    }

    // Menampilkan form untuk absensi
    public function showAbsensiForm()
    {
        $jabatanList = Jabatan::all(); // Ambil semua jabatan
        return view('absensi.form', compact('jabatanList')); // Kirim ke view
    }

    // Menampilkan detail absensi
    public function show($id)
    {
        $absensi = Absensi::with('detail', 'jabatan', 'user')->findOrFail($id);
        return view('absensi.show', compact('absensi'));
    }


    // Mengupdate data absensi
    public function update(Request $request, $id)
    {
        // Debugging: Tampilkan data yang diterima
        \Log::info('Data yang diterima untuk update:', $request->all());

        $validatedData = $request->validate([
            'id_jabatan' => 'required|exists:jabatans,id_jabatan',
            'jadwal_hadir' => 'required|date_format:H:i',
            'jadwal_pulang' => 'required|date_format:H:i',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update($validatedData);
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diupdate!');
    }

    // Mengupdate detail dengan waktu pulang jika sesuai jadwal


    // Store untuk menyimpan waktu pulang
    public function storePulang(Request $request)
    {
        $request->validate([
            'waktu_pulang' => 'required|date_format:Y-m-d\TH:i:s',
            'id_absensi' => 'required',
        ]);

        // Temukan record absensi berdasarkan id_absensi
        // dd($request->id_absensi);
        $absensi = Absensi::findOrFail($request->id_absensi); // error
        $today = now()->format('Y-m-d');

        // Cek apakah sudah melakukan absensi pulang hari ini berdasarkan id_absensi
        $existingAbsensiPulang = Detail::where('id_detail', $absensi->id_detail)
            ->whereNotNull('hadir_pulang')
            ->whereDate('hadir_pulang', $today)
            ->first();

        if ($existingAbsensiPulang) {
            return redirect()->back()->withErrors('Kamu sudah melakukan absensi pulang hari ini.');
        }
        // Ambil jadwal pulang berdasarkan jabatan dari absensi
        $jadwalPulang = Jadwal::where('id_jabatan', $absensi->id_jabatan)->value('jadwal_pulang');
        if (!$jadwalPulang) {
            return redirect()->back()->withErrors('Jadwal pulang tidak ditemukan.');
        }

        // Validasi waktu pulang
        // Parse the input and jadwal pulang as Carbon instances
        $waktuPulang = Carbon::parse($request->waktu_pulang); // No formatting to string
        $jadwalPulangTimestamp = Carbon::parse($jadwalPulang); // No formatting to string

        // Check if waktu pulang is less than jadwal pulang
        if ($waktuPulang->lessThan($jadwalPulangTimestamp)) {
            return redirect()->back()->withErrors('Anda belum bisa pulang sesuai jadwal.');
        }
        // dd($request);

        // Update waktu_pulang di detail
        $detail = Detail::where('id_detail', '=', $absensi->id_detail)->first();
        if ($detail) {
            $detail->update(['hadir_pulang' => $request->waktu_pulang]);
        } else {
            return redirect()->back()->withErrors('Detail tidak ditemukan.');
        }

        return redirect()->route('absensi.index')->with('success', 'Waktu pulang berhasil disimpan!');
    }



    // Menghapus kolom id_absensi jika rollback
    public function down()
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropColumn('id'); // Menghapus kolom id
        });
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropColumn('foto_selfie');
        });


    }



    public function up()
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->string('foto_selfie')->nullable();
        });
    }



}