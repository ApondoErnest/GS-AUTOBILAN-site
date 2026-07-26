<?php

namespace App\Http\Requests;

use App\Models\Agency;
use App\Models\Service;
use Illuminate\Validation\Rule;

class BookingRequest extends PublicFormRequest
{
    protected function prepareForValidation(): void
    {
        $vehicleBrandModel = $this->cleanedString($this->input('vehicle_brand_model'))
            ?? $this->compiledVehicleBrandModel();

        $this->merge([
            'customer_name' => $this->cleanedString($this->input('customer_name')),
            'phone' => $this->normalizedPhone($this->input('phone')),
            'whatsapp' => $this->normalizedPhone($this->input('whatsapp')),
            'email' => $this->cleanedString($this->input('email')),
            'agency_id' => $this->input('agency_id') ?: $this->resolvedAgencyId(),
            'service_id' => $this->input('service_id') ?: $this->resolvedServiceId(),
            'vehicle_registration' => $this->normalizedVehicleRegistration($this->input('vehicle_registration')),
            'vehicle_type' => $this->cleanedString($this->input('vehicle_type')),
            'vehicle_category' => $this->cleanedString($this->input('vehicle_category')),
            'vehicle_brand_model' => $vehicleBrandModel,
            'preferred_time_slot' => $this->cleanedString($this->input('preferred_time_slot')),
            'customer_message' => $this->cleanedString($this->input('customer_message')),
            'service_type' => $this->cleanedString($this->input('service_type')),
            'contact_mode' => $this->cleanedString($this->input('contact_mode')),
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
            'service_type' => ['nullable', 'string', 'max:80'],
            'contact_mode' => ['nullable', 'string', 'max:80'],
            'confirmation_understood' => ['sometimes', 'accepted'],
        ];
    }

    private function resolvedAgencyId(): ?int
    {
        $slug = $this->cleanedString($this->input('agency'));

        if ($slug === null) {
            return null;
        }

        return Agency::query()
            ->active()
            ->where('slug', $slug)
            ->value('id');
    }

    private function resolvedServiceId(): ?int
    {
        $serviceType = $this->cleanedString($this->input('service_type'));
        $vehicleCategory = $this->cleanedString($this->input('vehicle_category'));

        if ($serviceType === null) {
            return null;
        }

        $slugs = match ($serviceType) {
            'reinspection' => ['contre-visite', 're-inspection'],
            default => $this->serviceSlugsForVehicleCategory($vehicleCategory),
        };

        return Service::query()
            ->active()
            ->where(function ($query) use ($slugs): void {
                $query
                    ->whereIn('slug_fr', $slugs)
                    ->orWhereIn('slug_en', $slugs);
            })
            ->ordered()
            ->value('id')
            ?? Service::query()->active()->ordered()->value('id');
    }

    /**
     * @return list<string>
     */
    private function serviceSlugsForVehicleCategory(?string $vehicleCategory): array
    {
        return match ($vehicleCategory) {
            'light' => ['vehicules-legers', 'light-vehicles'],
            'utility' => ['vehicules-utilitaires', 'utility-vehicles'],
            'taxi' => ['taxis'],
            'driving-school' => ['auto-ecoles', 'driving-schools'],
            'bus' => ['bus-transport-public', 'buses-public-transport'],
            'heavy' => ['poids-lourds', 'heavy-goods-vehicles'],
            default => ['entreprises-parcs-automobiles', 'companies-vehicle-fleets'],
        };
    }

    private function compiledVehicleBrandModel(): ?string
    {
        $parts = array_values(array_filter([
            $this->cleanedString($this->input('vehicle_brand')),
            $this->cleanedString($this->input('vehicle_model')),
            $this->cleanedString($this->input('vehicle_year')),
        ]));

        return $parts === [] ? null : implode(' ', $parts);
    }
}
