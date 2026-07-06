<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Room;
use App\Models\Pc;
use App\Models\Operator;

class WarnetGamingApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Pelanggan $pelanggan;
    protected Operator $operator;
    protected Room $room;
    protected Pc $pc;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create(['role' => 'pelanggan']);
        $this->pelanggan = Pelanggan::create(['user_id' => $this->user->id, 'status' => 'active']);
        $this->operator = Operator::create(['nama' => 'Budi', 'shift' => 'pagi']);
        $this->room = Room::create(['nama_room' => 'Reguler', 'tipe' => 'reguler']);
        $this->pc = Pc::create(['nomor_pc' => 1, 'status' => 'tersedia', 'room_id' => $this->room->id]);
    }

    public function test_can_create_gaming_session_with_valid_data()
    {
        $payload = [
            'pelanggan_id' => $this->pelanggan->id,
            'room_id' => $this->room->id,
            'pc_id' => $this->pc->id,
            'operator_id' => $this->operator->id,
        ];

        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/gaming-sessions', $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('gaming_sessions', [
            'pelanggan_id' => $this->pelanggan->id,
            'pc_id' => $this->pc->id,
            'status' => 'active',
        ]);
    }

    public function test_validation_fails_for_invalid_foreign_keys_on_gaming_session()
    {
        $payload = [
            'pelanggan_id' => 9999, // Invalid
            'room_id' => $this->room->id,
            'pc_id' => $this->pc->id,
            'operator_id' => $this->operator->id,
        ];

        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/gaming-sessions', $payload);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['pelanggan_id']);
    }

    public function test_can_fetch_gaming_sessions_with_eager_loaded_relations()
    {
        // Setup initial session
        $this->actingAs($this->user, 'sanctum')->postJson('/api/gaming-sessions', [
            'pelanggan_id' => $this->pelanggan->id,
            'room_id' => $this->room->id,
            'pc_id' => $this->pc->id,
            'operator_id' => $this->operator->id,
        ]);

        $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/gaming-sessions');
        $response->assertStatus(200);

        // Check if eager loaded relations are present in the response
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'pelanggan' => ['id', 'user_id'],
                    'pc' => ['id', 'nomor_pc'],
                    'room' => ['id', 'nama_room'],
                    'operator' => ['id', 'nama']
                ]
            ]
        ]);
    }
}
