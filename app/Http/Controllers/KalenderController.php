<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Izin;

class KalenderController extends Controller
{
    // Method to display the calendar page
    public function index()
    {
        // Fetch absensi data for the authenticated user
        $dataAbsensi = Absensi::where('id', Auth::id())->get();
        // Ambil tanggal absen terakhir
        $latestTanggalAbsen = $dataAbsensi->max('tanggal_absen');


        // Tentukan tanggal hari ini
        $today = Carbon::today();
        $currentMonth = $today->month;
        $currentYear = $today->year;


        // Ambil data absensi berdasarkan bulan dan tahun saat ini
        $dataAbsensi = Absensi::where('id', Auth::id())
            ->whereMonth('tanggal_absen', $currentMonth)
            ->whereYear('tanggal_absen', $currentYear)
            ->get();

        // Loop untuk memeriksa status absensi dan menetapkan 'alpha' jika tidak ada status pada tanggal sebelum hari ini
        foreach ($dataAbsensi as $absensi) {
            // Periksa apakah tanggal absen lebih kecil dari hari ini dan status absen kosong
            if (Carbon::parse($absensi->tanggal_absen)->lt($today) && empty($absensi->kehadiran_absen)) {
                // Set status alpha jika tidak ada status kehadiran
                $absensi->kehadiran_absen = 'alpha';
                $absensi->save(); // Simpan perubahan
            }
        }


        // Fetch izin data for the authenticated user
        $izinData = Izin::whereIn('id_absensi', $dataAbsensi->pluck('id_absensi'))
            ->whereIn('status', ['Diterima', 'Ditolak', 'Direquest'])
            ->get(['tanggal_mulai', 'tanggal_selesai', 'status', 'jenis_izin']);

        // Hitung total status
        $totalStatus = $this->calculateTotalStatus($dataAbsensi, $izinData);

        return view('user.kalender', [
            'dataAbsensi' => $dataAbsensi,
            'izinData' => $izinData,
            'totalStatus' => $totalStatus,
            'latestTanggalAbsen' => $latestTanggalAbsen
        ]);
    }

    // Method to get izin data as JSON
    public function getIzinData()
    {
        // Fetch izin data for the authenticated user
        $izinData = Izin::whereIn('id_absensi', Absensi::where('id', Auth::id())->pluck('id_absensi'))
            ->whereIn('status', ['Diterima', 'Ditolak', 'Direquest'])
            ->get(['tanggal_mulai', 'tanggal_selesai', 'status', 'jenis_izin']);

        // Format the data to include all dates in the range between tanggal_mulai and tanggal_selesai
        $formattedIzinData = $izinData->map(function ($izin) {
            $dates = [];
            $currentDate = Carbon::parse($izin->tanggal_mulai);
            $endDate = Carbon::parse($izin->tanggal_selesai);

            while ($currentDate <= $endDate) {
                $dates[] = $currentDate->format('Y-m-d');
                $currentDate->addDay();
            }

            return [
                'dates' => $dates,  // Array of dates for each izin
                'status' => $izin->status,
                'jenis_izin' => $izin->jenis_izin,
            ];
        });

        return response()->json($formattedIzinData);
    }

    // Method to display the calendar with filtered absensi and izin data by month and year
    public function kalender(Request $request)
    {
        // Ambil bulan dan tahun dari request atau gunakan bulan dan tahun sekarang jika tidak ada
        $currentMonth = $request->input('month', Carbon::now()->month);
        $currentYear = $request->input('year', Carbon::now()->year);


        // Ambil data absensi berdasarkan bulan dan tahun yang dipilih
        $dataAbsensi = Absensi::where('id', Auth::id())
            ->whereMonth('tanggal_absen', $currentMonth)
            ->whereYear('tanggal_absen', $currentYear)
            ->get();

        // Ambil data izin berdasarkan absensi yang ada
        $izinData = Izin::whereIn('id_absensi', $dataAbsensi->pluck('id_absensi'))
            ->whereIn('status', ['Diterima', 'Ditolak', 'Direquest'])
            ->get();

        // Hitung jumlah status (hadir, telat, izin, sakit, alpha)
        $totalStatus = $this->calculateTotalStatus($dataAbsensi, $izinData);

        // Ambil tanggal absen terakhir
        $latestTanggalAbsen = $dataAbsensi->max('tanggal_absen');

        // Kirim data ke view
        return view('user.kalender', [
            'dataAbsensi' => $dataAbsensi,
            'izinData' => $izinData,
            'totalStatus' => $totalStatus,
            'latestTanggalAbsen' => $latestTanggalAbsen,
            'currentMonth' => $currentMonth,
            'currentYear' => $currentYear,
        ]);
    }

    // Method to calculate total status for absensi and izin
    private function calculateTotalStatus($dataAbsensi, $izinData)
    {
        // Inisialisasi counter untuk setiap status
        $hadirCount = 0;
        $telatCount = 0;
        $izinCount = 0;
        $sakitCount = 0;
        $alphaCount = 0;

        // Hitung status absensi
        foreach ($dataAbsensi as $absensi) {
            if ($absensi->kehadiran_absen == 'hadir') {
                $hadirCount++;
            } elseif ($absensi->kehadiran_absen == 'telat') {
                $telatCount++;
            } elseif ($absensi->kehadiran_absen == 'alpha') {
                $alphaCount++;
            } elseif ($absensi->kehadiran_absen == null) {
                // Menambahkan logika untuk otomatis set "alpha" jika tidak ada status
                $alphaCount++;
            }
            
        }

 


        // Hitung izin dan sakit berdasarkan rentang tanggal
        foreach ($izinData as $izin) {
            $tanggalMulai = Carbon::parse($izin->tanggal_mulai);
            $tanggalSelesai = Carbon::parse($izin->tanggal_selesai);

            // Hitung total hari dalam rentang tanggal
            $jumlahHari = $tanggalMulai->diffInDays($tanggalSelesai) + 1;

            if ($izin->status == 'Diterima') {
                if ($izin->jenis_izin == 'izin') {
                    $izinCount += $jumlahHari;  // Tambahkan jumlah hari untuk izin
                } elseif ($izin->jenis_izin == 'sakit') {
                    $sakitCount += $jumlahHari;  // Tambahkan jumlah hari untuk sakit
                }
            }
        }
  


        return [
            'hadir' => $hadirCount,
            'telat' => $telatCount,
            'izin' => $izinCount,
            'sakit' => $sakitCount,
            'alpha' => $alphaCount
        ];
    }

    // Method to get absensi data (API for calendar rendering)
    public function getAbsensiData(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);

        // Fetch absensi data based on month and year
        $dataAbsensi = Absensi::where('id', Auth::id())
            ->whereMonth('tanggal_absen', $month)
            ->whereYear('tanggal_absen', $year)
            ->get();

        // Fetch izin data based on id_absensi
        $izinData = Izin::whereIn('id_absensi', $dataAbsensi->pluck('id_absensi'))
            ->whereIn('status', ['Diterima', 'Ditolak', 'Direquest'])
            ->get();

        // Add izin ranges to response
        $formattedData = $dataAbsensi->map(function ($absensi) use ($izinData) {
            $izin = $izinData->firstWhere('id_absensi', $absensi->id_absensi);
            $absensi->izin_tanggal_mulai = $izin ? $izin->tanggal_mulai : null;
            $absensi->izin_tanggal_selesai = $izin ? $izin->tanggal_selesai : null;
            return $absensi;
        });

        return response()->json($formattedData);
    }


}