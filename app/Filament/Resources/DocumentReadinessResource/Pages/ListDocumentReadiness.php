<?php

namespace App\Filament\Resources\DocumentReadinessResource\Pages;

use App\Filament\Resources\DocumentReadinessResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListDocumentReadiness extends ListRecords
{
    protected static string $resource = DocumentReadinessResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('admin_document_readiness.pages.list.title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('admin_document_readiness.pages.list.subtitle');
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
