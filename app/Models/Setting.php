<?php

namespace App\Models;

use App\Models\Concerns\LogsAdminActivity;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'key',
    'value',
])]
class Setting extends Model
{
    use LogsAdminActivity;

    protected function casts(): array
    {
        return [
            'value' => 'array',
        ];
    }

    /**
     * @return array<int, string>
     */
    protected function adminActivityLogAttributes(): array
    {
        return [
            'key',
            'value',
        ];
    }
}
