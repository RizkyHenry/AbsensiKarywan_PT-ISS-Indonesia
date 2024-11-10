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
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id(); // Primary key
                $table->string('username');
                $table->string('password');
                $table->unsignedBigInteger('id_jabatan'); // Foreign key for job position
                $table->string('nik'); // Employee ID
                $table->enum('kelamin', ['L', 'P']); // Gender
                $table->enum('role', ['admin', 'karyawan']); // User role
                $table->rememberToken();
                $table->timestamps();
                
                // Foreign key constraints
                $table->foreign('id_jabatan')->references('id_jabatan')->on('jabatans')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};