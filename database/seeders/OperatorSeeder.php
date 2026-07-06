<?php

namespace Database\Seeders;

use App\Models\Operator;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class OperatorSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $rooms = Room::all();
        $operatorsEmailSeed = 'test@example.com';

        $users = User::query()->where('email', $operatorsEmailSeed)->get();
        $users = $users->merge(
            User::query()->whereNot('email', $operatorsEmailSeed)->limit(4)->get()
        )->unique('id')->values();

        $shifts = ['Pagi', 'Siang', 'Malam'];

        foreach ($users as $idx => $user) {
            $room = $rooms->count() ? $rooms[$idx % $rooms->count()] : null;
            if (!$room) {
                continue;
            }

            Operator::query()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'room_id' => $room->id,
                    'shift' => $shifts[$idx % count($shifts)],
                ]
            );
        }
    }
}

