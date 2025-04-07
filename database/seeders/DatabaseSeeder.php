<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Buat role pegawai jika belum ada
        if (!Role::where('name', 'pegawai')->exists()) {
            Role::create(['name' => 'pegawai']);
        }

        // Buat user pegawai baru
        $user = User::create([
            'name' => 'Pegawai1',
            'email' => 'pegawai1bkkbn@bkkbn.com',
            'password' => 'bcrypt'('tugaspegawaijanganganggu'),
        ]);

        // Assign role pegawai
        $user->assignRole('pegawai');

        echo "Seeder selesai! Pegawai berhasil dibuat.\n";
    }
}
