<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Room;
use App\Models\Pc;
use App\Models\Operator;
use App\Models\FoodBeverage;
use App\Models\GamingSession;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $operatorUser;
    protected User $pelangganUser;

    protected Pelanggan $pelanggan;
    protected Operator $operator;
    protected Room $room;
    protected Pc $pc;
    protected FoodBeverage $food;
    protected GamingSession $session;

    protected function setUp(): void
    {
        parent::setUp();

        // 3 user dengan role berbeda, ini yang jadi fokus pengujian middleware
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->operatorUser = User::factory()->create(['role' => 'operator']);
        $this->pelangganUser = User::factory()->create(['role' => 'pelanggan']);

        $this->room = Room::create(['name' => 'Reguler', 'type' => 'reguler']);
        $this->pelanggan = Pelanggan::create(['user_id' => $this->pelangganUser->id, 'status' => 'active']);
        $this->operator = Operator::create(['user_id' => $this->operatorUser->id, 'room_id' => $this->room->id, 'shift' => 'pagi']);
        $this->pc = Pc::create(['code' => 'PC-01', 'status' => 'tersedia', 'room_id' => $this->room->id]);

        $this->food = FoodBeverage::create([
            'name' => 'Mie Goreng',
            'category' => 'food',
            'price' => 12000,
            'stock' => 15,
            'is_available' => true,
        ]);

        $this->session = GamingSession::create([
            'pelanggan_id' => $this->pelanggan->id,
            'operator_id' => $this->operator->id,
            'pc_id' => $this->pc->id,
            'room_id' => $this->room->id,
            'started_at' => now(),
            'status' => 'active',
        ]);
    }

    // =========================================================
    // GRUP: role:admin  →  POST/PUT/DELETE /food-beverages
    // =========================================================

    public function test_admin_can_create_food_beverage()
    {
        $response = $this->actingAs($this->admin, 'sanctum')->postJson('/api/food-beverages', [
            'name' => 'Es Teh',
            'category' => 'drink',
            'price' => 5000,
            'stock' => 20,
            'is_available' => true,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('food_beverages', ['name' => 'Es Teh']);
    }

    public function test_operator_cannot_create_food_beverage()
    {
        $response = $this->actingAs($this->operatorUser, 'sanctum')->postJson('/api/food-beverages', [
            'name' => 'Es Teh',
            'category' => 'drink',
            'price' => 5000,
            'stock' => 20,
            'is_available' => true,
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('food_beverages', ['name' => 'Es Teh']);
    }

    public function test_pelanggan_cannot_create_food_beverage()
    {
        $response = $this->actingAs($this->pelangganUser, 'sanctum')->postJson('/api/food-beverages', [
            'name' => 'Es Teh',
            'category' => 'drink',
            'price' => 5000,
            'stock' => 20,
            'is_available' => true,
        ]);

        $response->assertStatus(403);
    }

    public function test_pelanggan_cannot_update_food_beverage()
    {
        $response = $this->actingAs($this->pelangganUser, 'sanctum')
            ->putJson("/api/food-beverages/{$this->food->id}", ['price' => 99999]);

        $response->assertStatus(403);
        $this->assertDatabaseHas('food_beverages', ['id' => $this->food->id, 'price' => 12000]);
    }

    public function test_pelanggan_cannot_delete_food_beverage()
    {
        $response = $this->actingAs($this->pelangganUser, 'sanctum')
            ->deleteJson("/api/food-beverages/{$this->food->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('food_beverages', ['id' => $this->food->id]);
    }

    public function test_admin_can_delete_food_beverage()
    {
        $response = $this->actingAs($this->admin, 'sanctum')
            ->deleteJson("/api/food-beverages/{$this->food->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('food_beverages', ['id' => $this->food->id]);
    }

    // =========================================================
    // GRUP: semua role login boleh index/show food-beverages
    // =========================================================

    public function test_pelanggan_can_view_food_beverage_list()
    {
        $response = $this->actingAs($this->pelangganUser, 'sanctum')->getJson('/api/food-beverages');
        $response->assertStatus(200);
    }

    // =========================================================
    // GRUP: role:admin,operator  →  payments, pelanggans, food-orders status
    // =========================================================

    public function test_admin_can_view_payments()
    {
        $response = $this->actingAs($this->admin, 'sanctum')->getJson('/api/payments');
        $response->assertStatus(200);
    }

    public function test_operator_can_view_payments()
    {
        $response = $this->actingAs($this->operatorUser, 'sanctum')->getJson('/api/payments');
        $response->assertStatus(200);
    }

    public function test_pelanggan_cannot_view_payments()
    {
        $response = $this->actingAs($this->pelangganUser, 'sanctum')->getJson('/api/payments');
        $response->assertStatus(403);
    }

    public function test_pelanggan_cannot_view_pelanggans_list()
    {
        $response = $this->actingAs($this->pelangganUser, 'sanctum')->getJson('/api/pelanggans');
        $response->assertStatus(403);
    }

    public function test_operator_can_view_pelanggans_list()
    {
        $response = $this->actingAs($this->operatorUser, 'sanctum')->getJson('/api/pelanggans');
        $response->assertStatus(200);
    }

    public function test_operator_can_update_food_order_status()
    {
        // Bikin food order dulu lewat pelanggan
        $orderResponse = $this->actingAs($this->pelangganUser, 'sanctum')->postJson('/api/food-orders', [
            'gaming_session_id' => $this->session->id,
            'pelanggan_id' => $this->pelanggan->id,
            'items' => [
                ['food_beverage_id' => $this->food->id, 'quantity' => 1],
            ],
        ]);
        $orderId = $orderResponse->json('data.id');

        $response = $this->actingAs($this->operatorUser, 'sanctum')
            ->putJson("/api/food-orders/{$orderId}/status", ['status' => 'paid']);

        $response->assertStatus(200);
        $this->assertDatabaseHas('food_orders', ['id' => $orderId, 'status' => 'paid']);
    }

    public function test_pelanggan_cannot_update_food_order_status()
    {
        $orderResponse = $this->actingAs($this->pelangganUser, 'sanctum')->postJson('/api/food-orders', [
            'gaming_session_id' => $this->session->id,
            'pelanggan_id' => $this->pelanggan->id,
            'items' => [
                ['food_beverage_id' => $this->food->id, 'quantity' => 1],
            ],
        ]);
        $orderId = $orderResponse->json('data.id');

        $response = $this->actingAs($this->pelangganUser, 'sanctum')
            ->putJson("/api/food-orders/{$orderId}/status", ['status' => 'paid']);

        $response->assertStatus(403);
    }

    // =========================================================
    // GRUP: unauthenticated (belum login sama sekali)
    // =========================================================

    public function test_unauthenticated_user_cannot_access_protected_endpoint()
    {
        $response = $this->postJson('/api/food-beverages', [
            'name' => 'Es Teh',
            'category' => 'drink',
            'price' => 5000,
            'stock' => 20,
        ]);

        // auth:sanctum yang jalan duluan di route group, jadi 401 bukan 403
        $response->assertStatus(401);
    }
}

