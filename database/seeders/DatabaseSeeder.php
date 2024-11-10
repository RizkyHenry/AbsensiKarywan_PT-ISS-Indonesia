<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Import Hash

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Membuat jabatan baru 
        Jabatan::create([
            'jabatan' => 'admin',
        ]);

        // Membuat user admin dengan password ter-hash menggunakan bcrypt
        User::create([
            'username' => 'admin',
            'role' => 'admin',
            'id_jabatan' => '1',
            'password' => ('admin123'),
            'nik' => ('098008080989'),
            'kelamin' => ('p')
        ]);
    }
}
