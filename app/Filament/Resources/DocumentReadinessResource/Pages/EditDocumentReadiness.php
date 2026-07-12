<?php

namespace App\Filament\Resources\DocumentReadinessResource\Pages;

use App\Filament\Resources\DocumentReadinessResource;
use Filament\Resources\Pages\EditRecord;

class EditDocumentReadiness extends EditRecord
{
    protected static string $resource = DocumentReadinessResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['updated_by'] = DocumentReadinessResource::currentUser()?->id;

        return $data;
    }
}
