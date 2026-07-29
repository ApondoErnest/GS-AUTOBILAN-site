<?php

namespace App\Models;

use App\Models\Concerns\LogsAdminActivity;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'question_fr',
    'question_en',
    'answer_fr',
    'answer_en',
    'sort_order',
    'is_active',
])]
class Faq extends Model
{
    use LogsAdminActivity;

    protected $table = 'faqs';

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    protected function adminActivityLogName(): string
    {
        return 'faqs';
    }

    /**
     * @return array<int, string>
     */
    protected function adminActivityLogAttributes(): array
    {
        return [
            'question_fr',
            'question_en',
            'answer_fr',
            'answer_en',
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
