<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Detail;
use App\Models\Jabatan;
use App\Models\User;
use App\Models\Izin;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensis';

    protected $primaryKey = 'id_absensi';

    public $timestamps = true;

    protected $fillable = [
        'id_absensi',
        'id_jabatan',
        'kehadiran_absen',
        'id',
        'tanggal_absen',
        'id_detail',
        'foto_selfie'
    ];

    // Relasi ke tabel jabatan
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id_jabatan');
    }

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    // Relasi ke tabel detail
    public function detail()
    {
        return $this->belongsTo(Detail::class, 'id_detail', 'id_detail');
    }

    // Relasi ke tabel izin (should be hasMany if user can have multiple izin records)
    public function izin()
    {
        return $this->hasMany(Izin::class, 'id_absensi', 'id_absensi');  // Changed to hasMany
    }
}
