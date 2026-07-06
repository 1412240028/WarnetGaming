<?php

namespace Database\Seeders;

use App\Models\Pc;
use App\Models\Game;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PcGameSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $pcs = Pc::query()->get();
        $games = Game::query()->get();

        if ($pcs->isEmpty() || $games->isEmpty()) {
            return;
        }

        foreach ($pcs as $pc) {
            $pickCount = rand(3, 7);
            $picked = $games->random(min($pickCount, $games->count()));

            $pickedGames = $picked instanceof \Illuminate\Support\Collection
                ? $picked
                : collect([$picked]);

            foreach ($pickedGames as $game) {
                \DB::table('pc_games')->updateOrInsert(
                    [
                        'pc_id' => $pc->id,
                        'game_id' => $game->id,
                    ],
                    []
                );
            }

        }
    }
}

