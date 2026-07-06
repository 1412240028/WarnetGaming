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

Route::get('/health', fn () => response()->json(['status' => 'ok']));

Route::apiResource('rooms', RoomController::class);
Route::apiResource('pcs', PcController::class);
Route::apiResource('operators', OperatorController::class);
Route::apiResource('memberships', MembershipController::class);
Route::apiResource('payments', PaymentController::class);
Route::apiResource('games', GameController::class);
Route::apiResource('pelanggans', PelangganController::class);

Route::post('/register', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:8',
    ]);

    $user = \App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Registered successfully',
        'user' => $user,
        'token' => $token,
    ], 201);
});

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    $user = \App\Models\User::where('email', $validated['email'])->first();

    if (!$user || !\Illuminate\Support\Facades\Hash::check($validated['password'], $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'user' => $user,
        'token' => $token,
    ]);
});

Route::middleware('auth:sanctum')->post('/logout', function (\Illuminate\Http\Request $request) {
    $request->user()->currentAccessToken()?->delete();

    return response()->json(['message' => 'Logged out successfully']);
});

Route::middleware('auth:sanctum')->get('/me', function (\Illuminate\Http\Request $request) {
    return response()->json($request->user());
});

Route::middleware('auth:sanctum')->group(function () {
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



