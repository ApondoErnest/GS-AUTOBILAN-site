<?php

namespace App\Models;

use App\Enums\ArticleStatus;
use App\Models\Concerns\LogsAdminActivity;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'category_id',
    'title_fr',
    'title_en',
    'slug_fr',
    'slug_en',
    'summary_fr',
    'summary_en',
    'content_fr',
    'content_en',
    'featured_image',
    'status',
    'published_at',
    'meta_title_fr',
    'meta_title_en',
    'meta_description_fr',
    'meta_description_en',
])]
class Article extends Model
{
    use LogsAdminActivity;

    protected function casts(): array
    {
        return [
            'status' => ArticleStatus::class,
            'published_at' => 'datetime',
        ];
    }

    /**
     * @return array<int, string>
     */
    protected function adminActivityLogAttributes(): array
    {
        return [
            'category_id',
            'title_fr',
            'title_en',
            'slug_fr',
            'slug_en',
            'summary_fr',
            'summary_en',
            'content_fr',
            'content_en',
            'featured_image',
            'status',
            'published_at',
            'meta_title_fr',
            'meta_title_en',
            'meta_description_fr',
            'meta_description_en',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', ArticleStatus::Published->value)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
