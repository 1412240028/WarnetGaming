<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FoodBeverage;
use Illuminate\Http\Request;

class FoodBeverageController extends Controller
{
    public function index()
    {
        $items = FoodBeverage::available()->get();
        return response()->json($items);
    }

    public function store(Request $request)
    {
        if ($request->user() && $request->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:food,drink,snack',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_available' => 'boolean',
        ]);

        $item = FoodBeverage::create($validated);
        return response()->json($item, 201);
    }

    public function show(FoodBeverage $foodBeverage)
    {
        return response()->json($foodBeverage);
    }

    public function update(Request $request, FoodBeverage $foodBeverage)
    {
        if ($request->user() && $request->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'category' => 'sometimes|in:food,drink,snack',
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
            'is_available' => 'boolean',
        ]);

        $foodBeverage->update($validated);
        return response()->json($foodBeverage);
    }

    public function destroy(Request $request, FoodBeverage $foodBeverage)
    {
        if ($request->user() && $request->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $foodBeverage->delete();
        return response()->json(null, 204);
    }
}
