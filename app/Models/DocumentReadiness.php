<?php

namespace App\Models;

use App\Enums\DocumentReadinessStatus;
use App\Models\Concerns\LogsAdminActivity;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'booking_id',
    'status',
    'missing_information_note',
    'next_action_fr',
    'next_action_en',
    'public_message_fr',
    'public_message_en',
    'updated_by',
])]
class DocumentReadiness extends Model
{
    use LogsAdminActivity;

    protected $table = 'document_readiness';

    protected function casts(): array
    {
        return [
            'status' => DocumentReadinessStatus::class,
        ];
    }

    protected function adminActivityLogName(): string
    {
        return 'document_readiness';
    }

    /**
     * @return array<int, string>
     */
    protected function adminActivityLogAttributes(): array
    {
        return [
            'booking_id',
            'status',
            'missing_information_note',
            'next_action_fr',
            'next_action_en',
            'public_message_fr',
            'public_message_en',
            'updated_by',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
