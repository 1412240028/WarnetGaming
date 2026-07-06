<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $data = [
            ['name' => 'Room Regular 1', 'type' => 'Regular'],
            ['name' => 'Room Regular 2', 'type' => 'Regular'],
            ['name' => 'Room VIP 1', 'type' => 'VIP'],
        ];

        foreach ($data as $row) {
            Room::query()->updateOrCreate(
                ['name' => $row['name']],
                $row
            );
        }
    }
}

