<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Akun Admin
        User::create([
            'name' => 'Admin PC IPNU',
            'email' => 'admin@ipnu.com',
            'password' => Hash::make('password'), // passwordnya: password
            'role' => 'admin',
        ]);

        // Buat 1 Akun Member buat ngetes nanti
        User::create([
            'name' => 'Rekan Kader',
            'email' => 'kader@ipnu.com',
            'password' => Hash::make('password'),
            'role' => 'member',
        ]);
    }
}