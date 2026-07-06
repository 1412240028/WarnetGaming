<?php

namespace Database\Seeders;

use App\Models\Pc;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PcSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $rooms = Room::query()->get();
        $statuses = ['available', 'in_use', 'maintenance'];

        $count = 20;
        for ($i = 1; $i <= $count; $i++) {
            $code = 'PC' . str_pad((string)$i, 2, '0', STR_PAD_LEFT);

            $room = $rooms->count() ? $rooms[($i - 1) % $rooms->count()] : null;
            if (!$room) {
                continue;
            }

            Pc::query()->updateOrCreate(
                ['code' => $code],
                [
                    'room_id' => $room->id,
                    'status' => $statuses[$i % count($statuses)],
                ]
            );
        }
    }
}

