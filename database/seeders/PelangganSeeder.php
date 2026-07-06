<?php

namespace Database\Seeders;

use App\Models\Membership;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $users = User::query()->whereNot('email', 'test@example.com')->limit(14)->get();
        $memberships = Membership::all();

        foreach ($users as $idx => $user) {
            $membership = $memberships[$idx % $memberships->count()];

            Pelanggan::query()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'membership_id' => $membership->id,
                    'status' => 'active',
                ]
            );
        }
    }
}

