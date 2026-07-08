<?php

namespace Database\Seeders;

use App\Models\FoodBeverage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodBeverageSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $data = [
            ['name' => 'Indomie Telur', 'category' => 'food', 'price' => 10000, 'stock' => 50],
            ['name' => 'Nasi Goreng', 'category' => 'food', 'price' => 15000, 'stock' => 30],
            ['name' => 'Es Teh Manis', 'category' => 'drink', 'price' => 5000, 'stock' => 100],
            ['name' => 'Kopi Hitam', 'category' => 'drink', 'price' => 6000, 'stock' => 100],
            ['name' => 'Chitato', 'category' => 'snack', 'price' => 8000, 'stock' => 40],
        ];

        foreach ($data as $item) {
            FoodBeverage::query()->updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
