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
        
        
        Schema::create('details', function (Blueprint $table) {
            $table->id('id_detail'); // Primary key
            $table->string('foto_selfie'); // Kolom untuk path foto selfie
            $table->time('hadir_datang'); // Waktu kehadiran datang
            $table->time('hadir_pulang'); // Waktu kehadiran pulang

            $table->timestamps(); // Kolom created_at dan updated_at


        });
    }
        
        
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('details');
    }
};
