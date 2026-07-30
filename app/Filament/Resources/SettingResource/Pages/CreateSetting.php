<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateSetting extends CreateRecord
{
    protected static string $resource = SettingResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('admin_settings.pages.create.title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('admin_settings.pages.create.subtitle');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['value'] = json_decode($data['value_json'], associative: true, flags: JSON_THROW_ON_ERROR);

        unset($data['value_json']);

        return $data;
    }
}
