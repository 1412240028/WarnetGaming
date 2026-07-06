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

    // Endpoint yang boleh diakses SEMUA role yang login
    Route::apiResource('pcs', PcController::class)->only(['index', 'show']);
    Route::apiResource('games', GameController::class)->only(['index', 'show']);
    Route::get('/gaming-sessions', [GamingSessionController::class, 'index']);
    Route::get('/gaming-sessions/{gamingSession}', [GamingSessionController::class, 'show']);
    Route::get('/food-beverages', [\App\Http\Controllers\Api\FoodBeverageController::class, 'index']);
    Route::get('/food-beverages/{foodBeverage}', [\App\Http\Controllers\Api\FoodBeverageController::class, 'show']);
    Route::get('/food-orders', [\App\Http\Controllers\Api\FoodOrderController::class, 'index']);
    Route::get('/food-orders/{foodOrder}', [\App\Http\Controllers\Api\FoodOrderController::class, 'show']);

    // Endpoint khusus ADMIN
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('rooms', RoomController::class)->except(['index', 'show']);
        Route::apiResource('operators', OperatorController::class);
        Route::apiResource('memberships', MembershipController::class);
        Route::post('/food-beverages', [\App\Http\Controllers\Api\FoodBeverageController::class, 'store']);
        Route::put('/food-beverages/{foodBeverage}', [\App\Http\Controllers\Api\FoodBeverageController::class, 'update']);
        Route::delete('/food-beverages/{foodBeverage}', [\App\Http\Controllers\Api\FoodBeverageController::class, 'destroy']);
    });

    // Endpoint ADMIN + OPERATOR (operasional harian)
    Route::middleware('role:admin,operator')->group(function () {
        Route::put('/food-orders/{foodOrder}/status', [\App\Http\Controllers\Api\FoodOrderController::class, 'updateStatus']);
        Route::delete('/gaming-sessions/{gamingSession}', [GamingSessionController::class, 'destroy']);
    });

    // Endpoint PELANGGAN (booking & transaksi milik sendiri)
    Route::post('/booking-sessions', [BookingSessionController::class, 'store']);
    Route::post('/food-orders', [\App\Http\Controllers\Api\FoodOrderController::class, 'store']);
    Route::get('/gaming-sessions/{gamingSessionId}/games', [SessionGameController::class, 'index']);
    Route::post('/gaming-sessions/{gamingSessionId}/games', [SessionGameController::class, 'store']);
});




