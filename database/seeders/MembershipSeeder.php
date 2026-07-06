<?php

namespace Database\Seeders;

use App\Models\Membership;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MembershipSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $data = [
            ['level' => 'Bronze', 'discount_percent' => 0, 'tag' => null],
            ['level' => 'Silver', 'discount_percent' => 5, 'tag' => null],
            ['level' => 'Gold', 'discount_percent' => 10, 'tag' => null],
            ['level' => 'Platinum', 'discount_percent' => 15, 'tag' => null],
        ];

        foreach ($data as $row) {
            Membership::query()->updateOrCreate(
                ['level' => $row['level']],
                $row
            );
        }
    }
}

