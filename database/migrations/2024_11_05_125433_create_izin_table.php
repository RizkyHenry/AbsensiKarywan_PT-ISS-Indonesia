<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIzinTable extends Migration
{
    public function up()
    {
        Schema::create('izin', function (Blueprint $table) {
            $table->id('id_izin'); // Primary key
            $table->unsignedBigInteger('id_absensi'); // Foreign key
            $table->string('jenis_izin');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->text('keterangan');
            $table->string('foto_bukti');
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('id_absensi')->references('id')->on('absensi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('izin');
    }
}
