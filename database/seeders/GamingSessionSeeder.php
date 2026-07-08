<?php

namespace Database\Seeders;

use App\Models\GamingSession;
use App\Models\Operator;
use App\Models\Pelanggan;
use App\Models\Pc;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GamingSessionSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $pelanggans = Pelanggan::all();
        $operators = Operator::all();
        $pcs = Pc::all();
        $rooms = Room::all();

        $statuses = ['active', 'finished'];

        $count = 50;

        for ($i = 0; $i < $count; $i++) {
            if ($pelanggans->isEmpty() || $operators->isEmpty() || $pcs->isEmpty()) {
                return;
            }

            $pelanggan = $pelanggans[$i % $pelanggans->count()];
            $operator = $operators[$i % $operators->count()];
            $pc = $pcs[$i % $pcs->count()];

            // Konsistensi room: ambil dari PC (karena PC belongs to room)
            $room = $rooms->count() ? $rooms->firstWhere('id', $pc->room_id) ?? $rooms->first() : null;
            if (!$room) {
                continue;
            }

            $startedAt = now()->subMinutes(rand(10, 10000));
            $durationMinutes = rand(30, 180);
            $endedAt = rand(0, 1) ? (clone $startedAt)->addMinutes($durationMinutes) : null;

            GamingSession::query()->create([
                'pelanggan_id' => $pelanggan->id,
                'operator_id' => $operator->id,
                'pc_id' => $pc->id,
                'room_id' => $room->id,
                'started_at' => $startedAt,
                'ended_at' => $endedAt,
                'status' => $endedAt ? 'finished' : 'active',
            ]);
        }
    }
}

