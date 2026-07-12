<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class BookingRequest extends PublicFormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'customer_name' => $this->cleanedString($this->input('customer_name')),
            'phone' => $this->normalizedPhone($this->input('phone')),
            'whatsapp' => $this->normalizedPhone($this->input('whatsapp')),
            'email' => $this->cleanedString($this->input('email')),
            'vehicle_registration' => $this->normalizedVehicleRegistration($this->input('vehicle_registration')),
            'vehicle_type' => $this->cleanedString($this->input('vehicle_type')),
            'vehicle_category' => $this->cleanedString($this->input('vehicle_category')),
            'vehicle_brand_model' => $this->cleanedString($this->input('vehicle_brand_model')),
            'preferred_time_slot' => $this->cleanedString($this->input('preferred_time_slot')),
            'customer_message' => $this->cleanedString($this->input('customer_message')),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:160'],
            'phone' => ['required', 'string', 'regex:/^\+[0-9]{8,20}$/'],
            'whatsapp' => ['nullable', 'string', 'regex:/^\+[0-9]{8,20}$/'],
            'email' => ['nullable', 'email:rfc', 'max:255'],
            'agency_id' => [
                'required',
                'integer',
                Rule::exists('agencies', 'id')->where('is_active', true),
            ],
            'service_id' => [
                'required',
                'integer',
                Rule::exists('services', 'id')->where('is_active', true),
            ],
            'vehicle_registration' => ['required', 'string', 'max:32'],
            'vehicle_type' => ['nullable', 'string', 'max:80'],
            'vehicle_category' => ['nullable', 'string', 'max:80'],
            'vehicle_brand_model' => ['nullable', 'string', 'max:160'],
            'preferred_date' => ['required', 'date', 'after_or_equal:today'],
            'preferred_time_slot' => ['required', 'string', 'max:80'],
            'customer_message' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
