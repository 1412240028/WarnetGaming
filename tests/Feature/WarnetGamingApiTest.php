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

    protected User $admin;
    protected User $operatorUser;
    protected User $pelangganUser;
    
    protected Pelanggan $pelanggan;
    protected Operator $operator;
    protected Room $room;
    protected Pc $pc;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create 3 different roles
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->operatorUser = User::factory()->create(['role' => 'operator']);
        $this->pelangganUser = User::factory()->create(['role' => 'pelanggan']);
        
        // Setup initial relations
        $this->pelanggan = Pelanggan::create(['user_id' => $this->pelangganUser->id, 'status' => 'active']);
        $this->room = Room::create(['name' => 'Reguler', 'type' => 'reguler']);
        $this->operator = Operator::create(['user_id' => $this->operatorUser->id, 'room_id' => $this->room->id, 'shift' => 'pagi']);
        $this->pc = Pc::create(['code' => 'PC-01', 'status' => 'tersedia', 'room_id' => $this->room->id]);
    }

    // ---------------------------------------------------------
    // ROLE: ADMIN SCENARIOS
    // ---------------------------------------------------------
    public function test_admin_can_create_room()
    {
        $payload = [
            'name' => 'VVIP Room',
            'type' => 'VIP',
        ];

        $response = $this->actingAs($this->admin, 'sanctum')->postJson('/api/rooms', $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('rooms', [
            'name' => 'VVIP Room',
            'type' => 'VIP'
        ]);
    }

    // ---------------------------------------------------------
    // ROLE: PELANGGAN SCENARIOS
    // ---------------------------------------------------------
    public function test_pelanggan_cannot_create_room()
    {
        $payload = [
            'name' => 'Hacker Room',
            'type' => 'Esport',
        ];

        // Pelanggan trying to create a room should be forbidden (403)
        $response = $this->actingAs($this->pelangganUser, 'sanctum')->postJson('/api/rooms', $payload);

        $response->assertStatus(403);
    }

    public function test_pelanggan_can_create_gaming_session_with_valid_data()
    {
        $payload = [
            'pelanggan_id' => $this->pelanggan->id,
            'room_id' => $this->room->id,
            'pc_id' => $this->pc->id,
            'operator_id' => $this->operator->id,
        ];

        $response = $this->actingAs($this->pelangganUser, 'sanctum')->postJson('/api/booking-sessions', $payload);

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
            'pelanggan_id' => 9999, // Invalid / Fictional ID
            'room_id' => $this->room->id,
            'pc_id' => $this->pc->id,
            'operator_id' => $this->operator->id,
        ];

        $response = $this->actingAs($this->pelangganUser, 'sanctum')->postJson('/api/booking-sessions', $payload);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['pelanggan_id']);
    }

    // ---------------------------------------------------------
    // ROLE: OPERATOR SCENARIOS
    // ---------------------------------------------------------
    public function test_operator_can_fetch_gaming_sessions_with_eager_loaded_relations()
    {
        // Setup initial session via booking
        $this->actingAs($this->pelangganUser, 'sanctum')->postJson('/api/booking-sessions', [
            'pelanggan_id' => $this->pelanggan->id,
            'room_id' => $this->room->id,
            'pc_id' => $this->pc->id,
            'operator_id' => $this->operator->id,
        ]);

        // Operator accesses the index to monitor sessions
        $response = $this->actingAs($this->operatorUser, 'sanctum')->getJson('/api/gaming-sessions');
        $response->assertStatus(200);

        // Check if eager loaded relations are present in the response
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'pelanggan' => ['id', 'user_id'],
                    'pc' => ['id', 'code'],
                    'room' => ['id', 'name'],
                    'operator' => ['id', 'user_id'] // Ensure your resource/model matches these keys
                ]
            ]
        ]);
    }

    // ---------------------------------------------------------
    // UNAUTHENTICATED SCENARIOS
    // ---------------------------------------------------------
    public function test_unauthenticated_user_cannot_access_booking()
    {
        $payload = [
            'pelanggan_id' => $this->pelanggan->id,
            'room_id' => $this->room->id,
            'pc_id' => $this->pc->id,
            'operator_id' => $this->operator->id,
        ];

        // Access without token
        $response = $this->postJson('/api/booking-sessions', $payload);
        
        // Sanctum will throw 401 Unauthorized
        $response->assertStatus(401);
    }
}
