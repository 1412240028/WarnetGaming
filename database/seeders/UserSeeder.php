<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::query()->firstOrCreate([
            'email' => 'admin@warnet.com',
        ], [
            'name' => 'Administrator',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::query()->firstOrCreate([
            'email' => 'operator@warnet.com',
        ], [
            'name' => 'Operator Penjaga',
            'password' => Hash::make('password'),
            'role' => 'operator',
        ]);

        User::query()->firstOrCreate([
            'email' => 'pelanggan@warnet.com',
        ], [
            'name' => 'Pelanggan Setia',
            'password' => Hash::make('password'),
            'role' => 'pelanggan',
        ]);
    }
}

