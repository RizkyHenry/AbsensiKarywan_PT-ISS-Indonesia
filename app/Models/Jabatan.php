<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory; // Gunakan HasFactory untuk factory

    protected $table = 'jabatans'; // Pastikan nama tabel sesuai

    protected $primaryKey = 'id_jabatan'; // Nama primary key

    public $timestamps = true; // Aktifkan timestamps jika tabel memiliki kolom created_at dan updated_at

    protected $fillable = [
        'jabatan', 
    ];

    // Jika model  memiliki relasi dengan model lain
    public function users()
    {
        return $this->hasMany(User::class, 'id');
    }


    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'id_jabatan');
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_jabatan');
    }
   
}
