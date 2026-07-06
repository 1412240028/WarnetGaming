<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Game;
use App\Models\Membership;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserGameSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $users = User::query()->where('email', '!=', 'test@example.com')->get();
        $games = Game::query()->get();

        if ($users->isEmpty() || $games->isEmpty()) {
            return;
        }

        foreach ($users as $user) {
            $pickCount = rand(4, 10);
            $picked = $games->random(min($pickCount, $games->count()));

            $pickedGames = $picked instanceof \Illuminate\Support\Collection
                ? $picked
                : collect([$picked]);

            foreach ($pickedGames as $game) {
                \DB::table('user_games')->updateOrInsert(
                    [
                        'user_id' => $user->id,
                        'game_id' => $game->id,
                    ],
                    [
                        'play_time_minutes' => rand(30, 250) * 60, // 30-250 jam (aproksimasi)
                    ]
                );
            }

        }
    }
}

