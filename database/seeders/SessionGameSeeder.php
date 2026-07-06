<?php

namespace Database\Seeders;

use App\Models\GamingSession;
use App\Models\Game;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class SessionGameSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $sessions = GamingSession::query()->get();
        $games = Game::query()->get();

        if ($sessions->isEmpty() || $games->isEmpty()) {
            return;
        }

        foreach ($sessions as $session) {
            $pickCount = rand(1, 3);

            // Collection::random() bisa return Collection (jika $count > 1) atau Model.
            $picked = $games->random(min($pickCount, $games->count()));

            $pickedGames = $picked instanceof \Illuminate\Support\Collection
                ? $picked
                : collect([$picked]);

            foreach ($pickedGames as $game) {
                \DB::table('session_games')->updateOrInsert(
                    [
                        'gaming_session_id' => $session->id,
                        'game_id' => $game->id,
                    ],
                    []
                );
            }

        }

    }
}

