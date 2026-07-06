<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\GamingSession;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $sessions = GamingSession::query()->inRandomOrder()->limit(50)->get();

        $methods = ['cash', 'qris', 'transfer'];
        $nominals = [15000, 25000, 35000, 50000, 75000];

        foreach ($sessions as $session) {
            $nominal = $nominals[array_rand($nominals)];

            Payment::query()->updateOrCreate(
                ['gaming_session_id' => $session->id],
                [
                    'method' => $methods[array_rand($methods)],
                    'nominal' => $nominal,
                    'status' => 'paid',
                ]
            );
        }
    }
}

