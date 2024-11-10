<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('absensis')) {
            Schema::create('absensis', function (Blueprint $table) {
                $table->id('id_absensi'); // Primary key
                $table->unsignedBigInteger('id_jabatan'); // Kolom jabatan
                $table->enum('kehadiran_absen', allowed: ['sakit', 'izin', 'hadir', 'alpa']); // Status kehadiran
                $table->unsignedBigInteger('user_id'); // Mengganti 'id' dengan 'user_id'
                $table->date('tanggal_absen'); // Tanggal kehadiran
                $table->unsignedBigInteger('id_detail'); // Foreign key ke detail
                $table->timestamps(); // Kolom created_at dan updated_at
                
                // Tambahkan relasi foreign key
                $table->foreign('id_jabatan')->references('id_jabatan')->on('jabatans')->onDelete('cascade'); // Pastikan nama tabel sesuai
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Menggunakan user_id sebagai foreign key
                $table->foreign('id_detail')->references('id_detail')->on('details')->onDelete('cascade'); // Relasi ke tabel details
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
