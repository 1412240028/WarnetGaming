<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FoodBeverage;
use App\Http\Requests\StoreFoodBeverageRequest;
use App\Http\Requests\UpdateFoodBeverageRequest;
use Illuminate\Http\Request;

class FoodBeverageController extends Controller
{
    public function index()
    {
        $items = FoodBeverage::available()->get();
        return response()->json($items);
    }

    public function store(StoreFoodBeverageRequest $request)
    {
        $item = FoodBeverage::create($request->validated());
        return response()->json($item, 201);
    }

    public function show(FoodBeverage $foodBeverage)
    {
        return response()->json($foodBeverage);
    }

    public function update(UpdateFoodBeverageRequest $request, FoodBeverage $foodBeverage)
    {
        $foodBeverage->update($request->validated());
        return response()->json($foodBeverage);
    }

    public function destroy(Request $request, FoodBeverage $foodBeverage)
    {
        $foodBeverage->delete();
        return response()->json(null, 204);
    }
}
