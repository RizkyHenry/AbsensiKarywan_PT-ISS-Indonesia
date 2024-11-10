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
                $table->unsignedBigInteger('id_jabatan'); // Job position foreign key
                $table->enum('kehadiran_absen', ['sakit', 'izin', 'hadir', 'alpa']); // Attendance status
                $table->unsignedBigInteger('user_id'); // User foreign key
                $table->date('tanggal_absen'); // Attendance date
                $table->unsignedBigInteger('id_detail'); // Foreign key to details
                $table->timestamps(); // Created and updated timestamps
                
                // Foreign key constraints
                $table->foreign('id_jabatan')->references('id_jabatan')->on('jabatans')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('id_detail')->references('id_detail')->on('details')->onDelete('cascade');
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