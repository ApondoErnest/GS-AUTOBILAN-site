<?php

namespace App\Models\Concerns;

use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

trait LogsAdminActivity
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        $subject = str(class_basename($this))->headline();

        return LogOptions::defaults()
            ->useLogName($this->adminActivityLogName())
            ->logOnly($this->adminActivityLogAttributes())
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->setDescriptionForEvent(fn (string $eventName): string => "{$subject} {$eventName}");
    }

    protected function adminActivityLogName(): string
    {
        return str(class_basename($this))->snake()->plural()->toString();
    }

    /**
     * @return array<int, string>
     */
    protected function adminActivityLogAttributes(): array
    {
        return [];
    }
}
