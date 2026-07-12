<?php

namespace App\Http\Requests;

class TrackingLookupRequest extends PublicFormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'reference' => $this->normalizedReference($this->input('reference')),
            'phone' => $this->normalizedPhone($this->input('phone')),
            'vehicle_registration' => $this->normalizedVehicleRegistration($this->input('vehicle_registration')),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'reference' => ['required', 'string', 'regex:/^GS-[0-9]{4}-[0-9]{6,}$/'],
            'phone' => ['required', 'string', 'regex:/^\+[0-9]{8,20}$/'],
            'vehicle_registration' => ['required', 'string', 'max:32'],
        ];
    }
}
