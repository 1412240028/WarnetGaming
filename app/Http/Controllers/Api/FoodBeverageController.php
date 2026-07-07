<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FoodBeverage;
use App\Http\Resources\FoodBeverageResource;
use App\Http\Requests\StoreFoodBeverageRequest;
use App\Http\Requests\UpdateFoodBeverageRequest;
use Illuminate\Http\Request;

class FoodBeverageController extends Controller
{
    public function index()
    {
        $items = FoodBeverage::available()->get();
        return FoodBeverageResource::collection($items);
    }

    public function store(StoreFoodBeverageRequest $request)
    {
        $item = FoodBeverage::create($request->validated());
        return (new FoodBeverageResource($item))->response()->setStatusCode(201);
    }

    public function show(FoodBeverage $foodBeverage)
    {
        return new FoodBeverageResource($foodBeverage);
    }

    public function update(UpdateFoodBeverageRequest $request, FoodBeverage $foodBeverage)
    {
        $foodBeverage->update($request->validated());
        return new FoodBeverageResource($foodBeverage);
    }

    public function destroy(Request $request, FoodBeverage $foodBeverage)
    {
        $foodBeverage->delete();
        return response()->json(null, 204);
    }
}
