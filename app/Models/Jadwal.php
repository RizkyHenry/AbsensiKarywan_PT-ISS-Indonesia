<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    
    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal'; // Ganti dengan nama kolom primary key yang sesuai

    protected $fillable = [
        'jadwal_hadir',
        'jadwal_pulang',
        'id_jabatan',
    ];

    // Relasi ke model Jabatan 
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }
    

}
