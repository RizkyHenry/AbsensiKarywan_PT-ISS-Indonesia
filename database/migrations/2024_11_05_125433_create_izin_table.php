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
        if (!Schema::hasTable('izin')) {
            Schema::create('izin', function (Blueprint $table) {
                $table->id('id_izin'); // Primary key
                $table->unsignedBigInteger('id_absensi'); // Foreign key to absensis
                $table->string('jenis_izin');
                $table->date('tanggal_mulai');
                $table->date('tanggal_selesai');
                $table->text('keterangan');
                $table->string('foto_bukti');
                $table->timestamps();

                // Foreign key constraint
                $table->foreign('id_absensi')->references('id_absensi')->on('absensis')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin');
    }
};