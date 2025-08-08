<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat user default
        User::create([
            'name' => 'Admin Kasir',
            'email' => 'admin@kasir.com',
            'password' => Hash::make('password'), // password default: password
        ]);
    }
}
