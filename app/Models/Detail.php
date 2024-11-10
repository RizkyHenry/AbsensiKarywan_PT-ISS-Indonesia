<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Absensi;

class Detail extends Model
{
    use HasFactory;
    protected $table = 'details'; // Nama tabel
    protected $primaryKey = 'id_detail'; // Ganti dengan primary key yang Anda gunakan

    protected $fillable = [
        'id_detail',
        'foto_selfie',
        'hadir_datang',
        'hadir_pulang',
        'id_absensi'
    ];

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'id_detail', 'id_detail');
    }

}
