<?php

namespace App\Models;

use App\Models\Concerns\LogsAdminActivity;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'customer_name',
    'customer_type_fr',
    'customer_type_en',
    'message_fr',
    'message_en',
    'rating',
    'image_path',
    'sort_order',
    'is_active',
])]
class Testimonial extends Model
{
    use LogsAdminActivity;

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * @return array<int, string>
     */
    protected function adminActivityLogAttributes(): array
    {
        return [
            'customer_name',
            'customer_type_fr',
            'customer_type_en',
            'message_fr',
            'message_en',
            'rating',
            'image_path',
            'sort_order',
            'is_active',
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
