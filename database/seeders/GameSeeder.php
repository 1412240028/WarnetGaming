<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $games = [
            'Valorant',
            'DOTA 2',
            'CS2',
            'PUBG',
            'EA FC 26',
            'League of Legends',
            'Minecraft',
            'GTA V',
            'Apex Legends',
            'Roblox',
            'Point Blank',
            'Left 4 Dead 2',
            'Overwatch 2',
            'Rocket League',
            'Fortnite',
        ];

        foreach ($games as $name) {
            Game::query()->updateOrCreate(['name' => $name], ['name' => $name]);
        }
    }
}

