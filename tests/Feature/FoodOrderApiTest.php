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
use App\Models\GamingSession;
use App\Models\FoodBeverage;

class FoodOrderApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Pelanggan $pelanggan;
    protected Operator $operator;
    protected Room $room;
    protected Pc $pc;
    protected GamingSession $session;
    protected FoodBeverage $food;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->pelanggan = Pelanggan::create(['user_id' => $this->user->id, 'status' => 'active']);
        $this->room = Room::create(['name' => 'VIP', 'type' => 'VIP']);
        
        $operatorUser = User::factory()->create(['role' => 'operator']);
        $this->operator = Operator::create(['user_id' => $operatorUser->id, 'room_id' => $this->room->id, 'shift' => 'pagi']);
        
        $this->pc = Pc::create(['code' => 'PC-01', 'status' => 'tersedia', 'room_id' => $this->room->id]);
        
        $this->session = GamingSession::create([
            'pelanggan_id' => $this->pelanggan->id,
            'operator_id' => $this->operator->id,
            'pc_id' => $this->pc->id,
            'room_id' => $this->room->id,
            'started_at' => now(),
            'status' => 'active',
        ]);
        
        $this->food = FoodBeverage::create([
            'name' => 'Indomie',
            'category' => 'food',
            'price' => 10000,
            'stock' => 10,
            'is_available' => true,
        ]);
    }

    public function test_can_create_food_order()
    {
        $payload = [
            'gaming_session_id' => $this->session->id,
            'pelanggan_id' => $this->pelanggan->id,
            'items' => [
                [
                    'food_beverage_id' => $this->food->id,
                    'quantity' => 2,
                ]
            ]
        ];

        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/food-orders', $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('food_orders', [
            'total_amount' => 20000,
            'status' => 'pending'
        ]);
        
        $this->assertDatabaseHas('food_beverages', [
            'id' => $this->food->id,
            'stock' => 8 // Stock decreased
        ]);
    }

    public function test_fails_when_insufficient_stock()
    {
        $payload = [
            'gaming_session_id' => $this->session->id,
            'pelanggan_id' => $this->pelanggan->id,
            'items' => [
                [
                    'food_beverage_id' => $this->food->id,
                    'quantity' => 20, // lebih dari stock (10)
                ]
            ]
        ];

        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/food-orders', $payload);

        $response->assertStatus(409);
        $response->assertJson(['error' => 'insufficient_stock']);

        // pastiin rollback beneran jalan, stock gak berubah
        $this->assertDatabaseHas('food_beverages', [
            'id' => $this->food->id,
            'stock' => 10,
        ]);
    }


    public function test_validation_fails_for_invalid_items()
    {
        $payload = [
            'gaming_session_id' => $this->session->id,
            'pelanggan_id' => $this->pelanggan->id,
            'items' => [] // empty items
        ];

        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/food-orders', $payload);
        $response->assertStatus(422);
    }
    
    public function test_unauthorized_access()
    {
        $response = $this->getJson('/api/food-orders');
        $response->assertStatus(401);
    }
}
