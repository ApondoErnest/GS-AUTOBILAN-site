<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name_fr',
    'name_en',
    'slug',
    'address_fr',
    'address_en',
    'city',
    'quarter',
    'phones',
    'whatsapp',
    'email',
    'opening_hours_fr',
    'opening_hours_en',
    'latitude',
    'longitude',
    'map_link',
    'status',
    'sort_order',
    'description_fr',
    'description_en',
    'is_active',
])]
class Agency extends Model
{
    protected function casts(): array
    {
        return [
            'phones' => 'array',
            'opening_hours_fr' => 'array',
            'opening_hours_en' => 'array',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function assignedUsers(): HasMany
    {
        return $this->hasMany(User::class, 'assigned_agency_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function contactMessages(): HasMany
    {
        return $this->hasMany(ContactMessage::class);
    }

    public function galleryItems(): HasMany
    {
        return $this->hasMany(GalleryItem::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
