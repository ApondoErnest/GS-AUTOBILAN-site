<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Setting;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class BookingReferenceService
{
    private const KEY_PREFIX = 'booking_reference_sequence_';

    /**
     * Reserve and return the next unique booking reference for a year.
     */
    public function generate(?int $year = null): string
    {
        $year ??= (int) now()->format('Y');

        return DB::transaction(function () use ($year): string {
            $sequence = $this->lockedSequence($year);
            $last = max(
                (int) data_get($sequence->value, 'last', 0),
                $this->latestExistingSequence($year),
            );

            do {
                $last++;
                $reference = $this->format($year, $last);
            } while (Booking::query()->where('reference', $reference)->exists());

            $sequence->value = [
                'year' => $year,
                'last' => $last,
            ];
            $sequence->save();

            return $reference;
        });
    }

    public function format(int $year, int $sequence): string
    {
        return sprintf('GS-%d-%06d', $year, $sequence);
    }

    private function lockedSequence(int $year): Setting
    {
        $key = $this->sequenceKey($year);
        $sequence = Setting::query()
            ->where('key', $key)
            ->lockForUpdate()
            ->first();

        if ($sequence) {
            return $sequence;
        }

        try {
            return Setting::query()->create([
                'key' => $key,
                'value' => [
                    'year' => $year,
                    'last' => 0,
                ],
            ]);
        } catch (QueryException) {
            return Setting::query()
                ->where('key', $key)
                ->lockForUpdate()
                ->firstOrFail();
        }
    }

    private function latestExistingSequence(int $year): int
    {
        $prefix = "GS-{$year}-";

        return (int) Booking::query()
            ->where('reference', 'like', $prefix.'%')
            ->pluck('reference')
            ->map(function (string $reference) use ($year): int {
                if (preg_match('/^GS-'.$year.'-(\d{6,})$/', $reference, $matches) !== 1) {
                    return 0;
                }

                return (int) $matches[1];
            })
            ->max();
    }

    private function sequenceKey(int $year): string
    {
        return self::KEY_PREFIX.$year;
    }
}
