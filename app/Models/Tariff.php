<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'category',
    'vehicle_type_fr',
    'vehicle_type_en',
    'price',
    'currency',
    'validity',
    'notes_fr',
    'notes_en',
    'sort_order',
    'is_active',
    'is_placeholder',
    'last_updated_at',
])]
class Tariff extends Model
{
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
            'is_placeholder' => 'boolean',
            'last_updated_at' => 'datetime',
        ];
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
