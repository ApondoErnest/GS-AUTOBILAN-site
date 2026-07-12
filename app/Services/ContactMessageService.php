<?php

namespace App\Services;

use App\Enums\ContactStatus;
use App\Events\ContactMessageCreated;
use App\Models\ContactMessage;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ContactMessageService
{
    /**
     * Store a public contact message with the default review status.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function create(array $attributes): ContactMessage
    {
        $payload = Arr::only($attributes, [
            'name',
            'phone',
            'email',
            'agency_id',
            'subject',
            'message',
        ]);

        foreach (['phone', 'email', 'agency_id'] as $nullableKey) {
            if (($payload[$nullableKey] ?? null) === '') {
                $payload[$nullableKey] = null;
            }
        }

        $contactMessage = DB::transaction(fn (): ContactMessage => ContactMessage::query()->create([
            ...$payload,
            'status' => ContactStatus::New,
        ]));

        ContactMessageCreated::dispatch($contactMessage);

        return $contactMessage;
    }

    public function assignAgency(ContactMessage $contactMessage, ?int $agencyId): ContactMessage
    {
        $contactMessage->forceFill(['agency_id' => $agencyId])->save();

        return $contactMessage->refresh();
    }

    public function markSpam(ContactMessage $contactMessage): ContactMessage
    {
        $contactMessage->forceFill(['status' => ContactStatus::Spam])->save();

        return $contactMessage->refresh();
    }
}
