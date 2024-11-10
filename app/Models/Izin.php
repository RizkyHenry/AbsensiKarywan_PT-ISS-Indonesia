<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;

    protected $table = 'izin';
    protected $primaryKey = 'id_izin'; // Set primary key menjadi id_izin

    protected $fillable = [
        'id_absensi',
        'username',
        'jenis_izin',
        'status',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan',
        'foto_bukti'
    ];

    // Relasi ke Absensi
    public function absensi()
    {
        return $this->belongsTo(Absensi::class, 'id_absensi', 'id_absensi');
    }

    // Relasi ke User (should be id_absensi, but it's probably incorrect)
    // The user is related to absensi via id, not via id_absensi. This is fixed here:
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id'); // Fixed relation to user
    }
}
