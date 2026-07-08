<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            MembershipSeeder::class,
            PelangganSeeder::class,
            RoomSeeder::class,
            OperatorSeeder::class,
            PcSeeder::class,
            GameSeeder::class,
            GamingSessionSeeder::class,
            PaymentSeeder::class,
            SessionGameSeeder::class,
            PcGameSeeder::class,
            UserGameSeeder::class,
            FoodBeverageSeeder::class,
            FoodOrderSeeder::class,
        ]);
    }
}

