<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'reference',
    'customer_name',
    'phone',
    'whatsapp',
    'email',
    'agency_id',
    'service_id',
    'vehicle_registration',
    'vehicle_type',
    'vehicle_category',
    'vehicle_brand_model',
    'preferred_date',
    'preferred_time_slot',
    'confirmed_date',
    'confirmed_time_slot',
    'status',
    'customer_message',
    'internal_notes',
    'public_message',
])]
class Booking extends Model
{
    protected function casts(): array
    {
        return [
            'preferred_date' => 'date',
            'confirmed_date' => 'date',
            'status' => BookingStatus::class,
        ];
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function documentReadiness(): HasOne
    {
        return $this->hasOne(DocumentReadiness::class);
    }
}
