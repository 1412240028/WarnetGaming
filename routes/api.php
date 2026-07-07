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
use App\Http\Controllers\Api\FoodOrderController;
use App\Http\Controllers\Api\FoodBeverageController;

use App\Http\Controllers\Api\AuthController;

Route::get('/health', fn () => response()->json(['status' => 'ok']));

Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:6,1');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Endpoint yang boleh diakses SEMUA role yang login
    Route::apiResource('rooms', RoomController::class)->only(['index', 'show']);
    Route::apiResource('pcs', PcController::class)->only(['index', 'show']);
    Route::apiResource('games', GameController::class)->only(['index', 'show']);
    Route::get('/gaming-sessions', [GamingSessionController::class, 'index']);
    Route::get('/gaming-sessions/{gamingSession}', [GamingSessionController::class, 'show']);
    Route::apiResource('food-beverages', FoodBeverageController::class)->only(['index', 'show']);
    Route::apiResource('food-orders', FoodOrderController::class)->only(['index', 'show']);

    // Endpoint khusus ADMIN
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('rooms', RoomController::class)->except(['index', 'show']);
        Route::apiResource('operators', OperatorController::class);
        Route::apiResource('memberships', MembershipController::class);
        Route::post('/food-beverages', [FoodBeverageController::class, 'store']);
        Route::put('/food-beverages/{foodBeverage}', [FoodBeverageController::class, 'update']);
        Route::delete('/food-beverages/{foodBeverage}', [FoodBeverageController::class, 'destroy']);
    });

    // Endpoint ADMIN + OPERATOR (operasional harian)
    Route::middleware('role:admin,operator')->group(function () {
        Route::put('/food-orders/{foodOrder}/status', [FoodOrderController::class, 'updateStatus']);
        Route::delete('/gaming-sessions/{gamingSession}', [GamingSessionController::class, 'destroy']);
        Route::apiResource('payments', PaymentController::class);
        Route::apiResource('pelanggans', PelangganController::class);
    });

    // Endpoint PELANGGAN (booking & transaksi milik sendiri)
    Route::post('/booking-sessions', [BookingSessionController::class, 'store']);
    Route::post('/food-orders', [FoodOrderController::class, 'store']);
    Route::get('/gaming-sessions/{gamingSessionId}/games', [SessionGameController::class, 'index']);
    Route::post('/gaming-sessions/{gamingSessionId}/games', [SessionGameController::class, 'store']);
});




