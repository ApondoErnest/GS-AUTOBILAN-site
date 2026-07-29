<?php

namespace App\Models;

use App\Enums\GalleryCategory;
use App\Models\Concerns\LogsAdminActivity;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'caption_fr',
    'caption_en',
    'agency_id',
    'category',
    'image_path',
    'sort_order',
    'is_active',
])]
class GalleryItem extends Model
{
    use LogsAdminActivity;

    protected function casts(): array
    {
        return [
            'category' => GalleryCategory::class,
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
            'caption_fr',
            'caption_en',
            'agency_id',
            'category',
            'image_path',
            'sort_order',
            'is_active',
        ];
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
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
