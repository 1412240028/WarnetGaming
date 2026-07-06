<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\PcController;
use App\Http\Controllers\Api\OperatorController;
use App\Http\Controllers\Api\MembershipController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\GamingSessionController;
use App\Http\Controllers\Api\SessionGameController;
use App\Http\Controllers\Api\BookingSessionController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\PelangganController;

use App\Http\Controllers\Api\AuthController;

Route::get('/health', fn () => response()->json(['status' => 'ok']));

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::apiResource('rooms', RoomController::class);
    Route::apiResource('pcs', PcController::class);
    Route::apiResource('operators', OperatorController::class);
    Route::apiResource('memberships', MembershipController::class);
    Route::apiResource('payments', PaymentController::class);
    Route::apiResource('games', GameController::class);
    Route::apiResource('pelanggans', PelangganController::class);

    Route::post('/booking-sessions', [BookingSessionController::class, 'store']);
    Route::get('/gaming-sessions', [GamingSessionController::class, 'index']);
    Route::get('/gaming-sessions/{gamingSession}', [GamingSessionController::class, 'show']);
    Route::delete('/gaming-sessions/{gamingSession}', [GamingSessionController::class, 'destroy']);

    Route::get('/gaming-sessions/{gamingSessionId}/games', [SessionGameController::class, 'index']);
    Route::post('/gaming-sessions/{gamingSessionId}/games', [SessionGameController::class, 'store']);

    // Food and Beverages endpoints (Extension Module)
    Route::get('/food-beverages', [\App\Http\Controllers\Api\FoodBeverageController::class, 'index']);
    Route::post('/food-beverages', [\App\Http\Controllers\Api\FoodBeverageController::class, 'store']);
    Route::get('/food-beverages/{foodBeverage}', [\App\Http\Controllers\Api\FoodBeverageController::class, 'show']);
    Route::put('/food-beverages/{foodBeverage}', [\App\Http\Controllers\Api\FoodBeverageController::class, 'update']);
    Route::delete('/food-beverages/{foodBeverage}', [\App\Http\Controllers\Api\FoodBeverageController::class, 'destroy']);

    Route::get('/food-orders', [\App\Http\Controllers\Api\FoodOrderController::class, 'index']);
    Route::post('/food-orders', [\App\Http\Controllers\Api\FoodOrderController::class, 'store']);
    Route::get('/food-orders/{foodOrder}', [\App\Http\Controllers\Api\FoodOrderController::class, 'show']);
    Route::put('/food-orders/{foodOrder}/status', [\App\Http\Controllers\Api\FoodOrderController::class, 'updateStatus']);
});



