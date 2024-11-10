<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('username');
        $table->string('password');
        $table->integer('id_jabatan');
        $table->string('nik'); // Tambahkan kolom NIK
        $table->enum('kelamin', ['L', 'P']); // Tambahkan kolom kelamin
        $table->enum('role', ['admin', 'karyawan']);
        $table->rememberToken();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
