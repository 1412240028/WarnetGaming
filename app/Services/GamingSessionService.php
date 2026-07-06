<?php

namespace App\Services;

use App\Models\GamingSession;
use App\Models\Pc;
use Illuminate\Support\Facades\DB;

class GamingSessionService
{
    /**
     * Create a new active GamingSession in a concurrency-safe manner.
     *
     * Concurrency strategy:
     * - lock PC row (lockForUpdate)
     * - verify pc.status === 'available'
     * - create gaming_session
     * - set pc.status = 'in_use'
     */
    public function createActiveSession(array $data): GamingSession
    {
        return DB::transaction(function () use ($data) {
            $pcId = (int) $data['pc_id'];

            /** @var Pc $pc */
            $pc = Pc::query()->where('id', $pcId)->lockForUpdate()->firstOrFail();

            // This project uses Indonesian status values in tests: tersedia / in_use
            $availableStatuses = ['available', 'tersedia'];
            if (!in_array($pc->status, $availableStatuses, true)) {
                throw new \InvalidArgumentException(
                    sprintf('PC tidak tersedia. status=%s', $pc->status)
                );
            }

            // Defensive: prevent multiple active sessions on same PC
            $existingActive = GamingSession::query()
                ->where('pc_id', $pcId)
                ->where('status', 'active')
                ->exists();

            if ($existingActive) {
                throw new \InvalidArgumentException('PC sedang digunakan');
            }

            $created = GamingSession::create([
                'pelanggan_id' => $data['pelanggan_id'],
                'room_id' => $data['room_id'],
                'pc_id' => $pcId,
                'operator_id' => $data['operator_id'],
                'status' => 'active',
                'started_at' => $data['started_at'] ?? now(),
            ]);

            $pc->status = 'in_use';
            $pc->save();

            return $created;
        });
    }
}

