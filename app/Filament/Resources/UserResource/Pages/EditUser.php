<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    /**
     * @var list<string>
     */
    protected array $selectedRoles = [];

    public function getTitle(): string|Htmlable
    {
        return __('admin_users.pages.edit.title', [
            'user' => UserResource::userTitle($this->record),
        ]);
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('admin_users.pages.edit.subtitle');
    }

    /**
     * @return array<DeleteAction>
     */
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label(__('admin_users.actions.delete'))
                ->icon('heroicon-o-trash'),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['roles'] = $this->getRecord()
            ->roles()
            ->pluck('name')
            ->all();

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->selectedRoles = $data['roles'] ?? [];

        unset($data['roles']);

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        return $data;
    }

    protected function afterSave(): void
    {
        $this->getRecord()->syncRoles($this->selectedRoles);
    }
}
