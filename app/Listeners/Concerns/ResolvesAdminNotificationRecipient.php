<?php

namespace App\Listeners\Concerns;

use App\Models\Setting;

trait ResolvesAdminNotificationRecipient
{
    protected function adminEmail(): ?string
    {
        $email = data_get(Setting::query()->where('key', 'direction_generale')->first()?->value, 'email')
            ?? config('mail.from.address');

        return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : null;
    }
}
