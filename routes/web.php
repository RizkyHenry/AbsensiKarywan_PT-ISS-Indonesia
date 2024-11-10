<?php
use App\Http\Controllers\SessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormuserController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\CrudjabatanController;
use App\Http\Controllers\CrudjadwalController;
use App\Http\Controllers\ControllerDetail;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\KalenderController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\TerimarequestController;

use Illuminate\Support\Facades\Route;

// Tampilkan form login
Route::get('/', function () {
    return redirect()->route('loginForm');
});
Route::get('login', [SessionController::class, 'showLoginForm'])->name('loginForm');

// Proses login
Route::post('login', [SessionController::class, 'login'])->name('login');

// Rute lainnya
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('formuser', [FormuserController::class, 'index'])->name('formuser')->middleware('auth');
Route::post('logout', [SessionController::class, 'logout'])->name('logout');

// Rute untuk jabatan
Route::resource('jabatan', CrudjabatanController::class)->middleware('auth');

// Rute untuk jadwal
Route::resource('jadwal', CrudjadwalController::class)->middleware('auth');

// Route to display the calendar page
Route::get('/kalender', [KalenderController::class, 'index'])->name('kalender.index');

// Route to fetch izin data as JSON for specific dates (used in AJAX to highlight dates)
Route::get('/kalender/get-izin-data', [KalenderController::class, 'getIzinData'])->name('kalender.getIzinData');

// Route to fetch absensi data for a specific month and year
Route::get('/kalender/get-absensi', [KalenderController::class, 'getAbsensiData'])->name('kalender.getAbsensiData');


// Rute untuk karyawan (CRUD resource routes)
Route::post('/karyawan/delete', [KaryawanController::class, 'destroy'])->name('karyawan.deletes')->middleware('auth');
// 
Route::put('/karyawan/update/{id}', [KaryawanController::class, 'update'])->name('karyawan.update')->middleware('auth');
Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
Route::post('/karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');



// Route untuk halaman CRUD Jadwal
Route::get('/crudjadwal', [CrudjadwalController::class, 'index'])->name('crudjadwal.index');
Route::post('/crudjadwal', [CrudjadwalController::class, 'store'])->name('crudjadwal.store');
Route::get('/crudjadwal/{id}', [CrudjadwalController::class, 'show'])->name('crudjadwal.show'); // Untuk menampilkan detail jadwal
Route::get('/crudjadwal/{id}/edit', [CrudjadwalController::class, 'edit'])->name('crudjadwal.edit'); // Route untuk form edit jadwal
Route::put('/crudjadwal/{id}', [CrudjadwalController::class, 'update'])->name('crudjadwal.update');
Route::delete('/crudjadwal/{id}', [CrudjadwalController::class, 'destroy'])->name('crudjadwal.destroy');


// Rute untuk absensi
// Route::resource('absensi', AbsensiController::class)->middleware('auth');
Route::get('absensi', [AbsensiController::class, 'index'])->name('absensi.index');
Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');

// Route untuk menyimpan absen pulang
Route::post('/absensi/post/pulang', [AbsensiController::class, 'storePulang'])->name('absensi.store.pulang');


// Route untuk menampilkan semua detail
Route::get('/details', [ControllerDetail::class, 'index']);

// Route untuk menampilkan satu detail berdasarkan ID
Route::get('/api/details/{id}', [ControllerDetail::class, 'show']);

// Route untuk membuat detail baru
Route::post('/details', [ControllerDetail::class, 'store']);

// Route untuk mengupdate detail yang ada
Route::put('/details/{id}', [ControllerDetail::class, 'update']);

// Route untuk menghapus detail
Route::delete('/details/{id}', [ControllerDetail::class, 'destroy']);

// Route untuk menampilkan halaman izin
Route::get('/izin', [IzinController::class, 'index'])->name('izin.index');

// Route untuk menyimpan data izin
Route::post('/izin/store', [IzinController::class, 'store'])->name('izin.store');

Route::post('/update-status/{id_izin}', [IzinController::class, 'updateStatus'])->name('updateStatus');

Route::get('izin/{id_izin}/bukti', [IzinController::class, 'showBukti'])->name('izin.showBukti');





Route::get('/terimarequest/{id}', [TerimarequestController::class, 'index'])->name('terimarequest.index');
Route::post('/terimarequest/{id}', [TerimarequestController::class, 'store'])->name('terimarequest.store');
// Route::post('/update-status/{id}', [TerimarequestController::class, 'updateStatus'])->name('updateStatus');





