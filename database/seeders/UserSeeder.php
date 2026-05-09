<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin Stockify',
            'email'    => 'admin@stockify.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Manajer Gudang',
            'email'    => 'manajer@stockify.com',
            'password' => Hash::make('password'),
            'role'     => 'manajer_gudang',
        ]);

        User::create([
            'name'     => 'Staff Gudang',
            'email'    => 'staff@stockify.com',
            'password' => Hash::make('password'),
            'role'     => 'staff_gudang',
        ]);
    }
}