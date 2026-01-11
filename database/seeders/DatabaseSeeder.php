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
            'name' => 'Admin SIKUT',
            'email' => 'admin@sikut.com',
            'password' => Hash::make('password'), // passwordnya: password
            'role' => 'admin',
        ]);
    }
}