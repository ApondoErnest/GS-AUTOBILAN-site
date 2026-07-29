<?php

namespace App\Filament\Resources\DocumentReadinessResource\Pages;

use App\Filament\Resources\DocumentReadinessResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditDocumentReadiness extends EditRecord
{
    protected static string $resource = DocumentReadinessResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('admin_document_readiness.pages.edit.title', [
            'reference' => $this->record?->booking?->reference ?? '',
        ]);
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('admin_document_readiness.pages.edit.subtitle');
    }

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
