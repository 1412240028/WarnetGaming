<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\GamingSession;
use App\Models\Operator;
use App\Models\Pc;
use App\Models\Pelanggan;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DuplicateSessionGameTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_add_same_game_twice_to_same_session(): void
    {
        $operatorUser = User::factory()->create(['role' => 'operator']);
        $adminUser = $operatorUser; // actingAs will use this user

        $room = Room::create(['name' => 'Reguler', 'type' => 'reguler']);
        $operator = Operator::create([
            'user_id' => $operatorUser->id,
            'room_id' => $room->id,
            'shift' => 'pagi',
        ]);

        $pelangganUser = User::factory()->create(['role' => 'pelanggan']);
        $pelanggan = Pelanggan::create([
            'user_id' => $pelangganUser->id,
            'status' => 'active',
        ]);

        $pc = Pc::create([
            'code' => 'PC-01',
            'room_id' => $room->id,
            'status' => 'in_use',
        ]);

        $gamingSession = GamingSession::create([
            'pelanggan_id' => $pelanggan->id,
            'operator_id' => $operator->id,
            'room_id' => $room->id,
            'pc_id' => $pc->id,
            'started_at' => now(),
            'status' => 'active',
        ]);

        $game = Game::create(['name' => 'Game A']);

        $this->actingAs($adminUser, 'sanctum');

        $resp1 = $this->postJson("/api/gaming-sessions/{$gamingSession->id}/games", [
            'game_id' => $game->id,
        ]);
        $resp1->assertStatus(201);

        $resp2 = $this->postJson("/api/gaming-sessions/{$gamingSession->id}/games", [
            'game_id' => $game->id,
        ]);
        $resp2->assertStatus(409);
        $resp2->assertJson(['error' => 'duplicate_session_game']);
    }
}

