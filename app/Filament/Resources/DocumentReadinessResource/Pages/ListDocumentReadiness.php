<?php

namespace App\Filament\Resources\DocumentReadinessResource\Pages;

use App\Filament\Resources\DocumentReadinessResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDocumentReadiness extends ListRecords
{
    protected static string $resource = DocumentReadinessResource::class;

    /**
     * @return array<CreateAction>
     */
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
