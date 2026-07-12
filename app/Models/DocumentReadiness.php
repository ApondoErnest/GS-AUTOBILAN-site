<?php

namespace App\Models;

use App\Enums\DocumentReadinessStatus;
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
    protected $table = 'document_readiness';

    protected function casts(): array
    {
        return [
            'status' => DocumentReadinessStatus::class,
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
