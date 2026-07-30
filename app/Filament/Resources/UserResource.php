<?php

namespace App\Filament\Resources;

use App\Filament\AdminNavigation;
use App\Filament\Resources\UserResource\Pages;
use App\Models\Agency;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'users';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static string|\UnitEnum|null $navigationGroup = AdminNavigation::GROUP_USERS_SETTINGS;

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationLabel(): string
    {
        return (string) __('admin_users.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return (string) __('admin_users.model.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return (string) __('admin_users.model.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin_users.form.sections.identity.heading'))
                    ->description(__('admin_users.form.sections.identity.description'))
                    ->icon('heroicon-o-user-circle')
                    ->compact()
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        TextInput::make('name')
                            ->label(__('admin_users.form.fields.name.label'))
                            ->placeholder(__('admin_users.form.fields.name.placeholder'))
                            ->prefixIcon('heroicon-o-user')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label(__('admin_users.form.fields.email.label'))
                            ->placeholder(__('admin_users.form.fields.email.placeholder'))
                            ->prefixIcon('heroicon-o-envelope')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('password')
                            ->label(__('admin_users.form.fields.password.label'))
                            ->placeholder(__('admin_users.form.fields.password.placeholder'))
                            ->prefixIcon('heroicon-o-key')
                            ->password()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->maxLength(255),
                    ]),
                Section::make(__('admin_users.form.sections.access.heading'))
                    ->description(__('admin_users.form.sections.access.description'))
                    ->icon('heroicon-o-shield-check')
                    ->compact()
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        Select::make('assigned_agency_id')
                            ->label(__('admin_users.form.fields.assigned_agency_id.label'))
                            ->options(fn (): array => self::agencyOptions())
                            ->searchable()
                            ->native(false),
                        Toggle::make('is_active')
                            ->label(__('admin_users.form.fields.is_active.label'))
                            ->helperText(__('admin_users.form.fields.is_active.helper'))
                            ->inline(false)
                            ->default(true),
                        DateTimePicker::make('last_login_at')
                            ->label(__('admin_users.form.fields.last_login_at.label'))
                            ->seconds(false)
                            ->disabled()
                            ->dehydrated(false),
                    ]),
                Section::make(__('admin_users.form.sections.roles.heading'))
                    ->description(__('admin_users.form.sections.roles.description'))
                    ->icon('heroicon-o-identification')
                    ->compact()
                    ->schema([
                        CheckboxList::make('roles')
                            ->label(__('admin_users.form.fields.roles.label'))
                            ->options(self::roleOptions())
                            ->columns(3)
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading(__('admin_users.table.heading'))
            ->description(__('admin_users.table.description'))
            ->columns([
                TextColumn::make('name')
                    ->label(__('admin_users.table.columns.user'))
                    ->icon('heroicon-o-user-circle')
                    ->weight(FontWeight::Bold)
                    ->description(fn (User $record): string => $record->email)
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('roles.name')
                    ->label(__('admin_users.table.columns.roles'))
                    ->badge()
                    ->formatStateUsing(fn (mixed $state): string => self::roleLabel($state)),
                TextColumn::make('assignedAgency.name_fr')
                    ->label(__('admin_users.table.columns.agency'))
                    ->icon('heroicon-o-building-office-2')
                    ->formatStateUsing(fn (User $record): string => self::agencyLabel($record->assignedAgency))
                    ->placeholder(__('admin_users.empty_agency'))
                    ->toggleable()
                    ->visibleFrom('md'),
                TextColumn::make('is_active')
                    ->label(__('admin_users.table.columns.status'))
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => self::visibilityLabel($state))
                    ->color(fn (bool $state): string => self::visibilityColor($state))
                    ->icon(fn (bool $state): string => self::visibilityIcon($state))
                    ->sortable(),
                TextColumn::make('last_login_at')
                    ->label(__('admin_users.table.columns.last_login'))
                    ->icon('heroicon-o-clock')
                    ->dateTime('M j, Y H:i')
                    ->placeholder(__('admin_users.table.descriptions.never_logged_in'))
                    ->sortable()
                    ->toggleable()
                    ->visibleFrom('lg'),
            ])
            ->defaultSort('name')
            ->stackedOnMobile()
            ->striped()
            ->defaultPaginationPageOption(25)
            ->paginated([10, 25, 50])
            ->recordUrl(fn (User $record): string => static::getUrl('edit', ['record' => $record]))
            ->emptyStateIcon('heroicon-o-users')
            ->emptyStateHeading(__('admin_users.table.empty_heading'))
            ->emptyStateDescription(__('admin_users.table.empty_description'))
            ->filters([
                TernaryFilter::make('is_active')
                    ->label(__('admin_users.table.filters.status')),
                SelectFilter::make('assigned_agency_id')
                    ->label(__('admin_users.table.filters.agency'))
                    ->options(fn (): array => self::agencyOptions())
                    ->searchable()
                    ->native(false),
                Filter::make('role')
                    ->label(__('admin_users.table.filters.role'))
                    ->schema([
                        Select::make('value')
                            ->label(__('admin_users.table.filters.role'))
                            ->options(self::roleOptions())
                            ->native(false),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query->when(
                        $data['value'] ?? null,
                        fn (Builder $query, string $role): Builder => $query->whereHas(
                            'roles',
                            fn (Builder $query): Builder => $query->where('name', $role),
                        ),
                    )),
                Filter::make('without_roles')
                    ->label(__('admin_users.table.filters.without_roles'))
                    ->query(fn (Builder $query): Builder => $query->whereDoesntHave('roles')),
            ])
            ->filtersFormColumns([
                'default' => 1,
                'md' => 2,
                'xl' => 4,
            ])
            ->persistFiltersInSession()
            ->recordActions([
                EditAction::make()
                    ->label(__('admin_users.actions.edit'))
                    ->icon('heroicon-o-pencil-square'),
                DeleteAction::make()
                    ->label(__('admin_users.actions.delete'))
                    ->icon('heroicon-o-trash'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label(__('admin_users.actions.delete_selected'))
                        ->icon('heroicon-o-trash'),
                ]),
            ]);
    }

    /**
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function roleOptions(): array
    {
        return [
            'super_admin' => (string) __('admin_users.roles.super_admin'),
            'agency_admin' => (string) __('admin_users.roles.agency_admin'),
            'content_manager' => (string) __('admin_users.roles.content_manager'),
        ];
    }

    /**
     * @return array<int, string>
     */
    public static function agencyOptions(): array
    {
        return Agency::query()
            ->ordered()
            ->get()
            ->mapWithKeys(fn (Agency $agency): array => [$agency->id => self::agencyLabel($agency)])
            ->all();
    }

    public static function userTitle(User $user): string
    {
        return filled($user->name) ? (string) $user->name : (string) __('admin_users.empty_user');
    }

    public static function rolesSummary(User $user): string
    {
        $user->loadMissing('roles');

        return $user->roles
            ->pluck('name')
            ->map(fn (mixed $role): string => self::roleLabel($role))
            ->filter()
            ->join(', ') ?: (string) __('admin_users.empty_roles');
    }

    public static function roleLabel(mixed $role): string
    {
        if (is_iterable($role) && ! is_string($role)) {
            return collect($role)
                ->map(fn (mixed $roleName): string => self::roleLabel($roleName))
                ->filter()
                ->join(', ');
        }

        $roleName = is_string($role) ? $role : (string) $role;
        $key = "admin_users.roles.{$roleName}";

        return trans()->has($key)
            ? (string) __($key)
            : (string) str($roleName)->replace(['_', '-'], ' ')->headline();
    }

    public static function agencyLabel(?Agency $agency): string
    {
        if (! $agency) {
            return (string) __('admin_users.empty_agency');
        }

        $locale = app()->getLocale() === 'en' ? 'en' : 'fr';
        $agencyName = $agency->getAttribute("name_{$locale}")
            ?: $agency->name_fr
            ?: $agency->name_en;

        return filled($agencyName) ? (string) $agencyName : (string) __('admin_users.empty_agency');
    }

    public static function visibilityLabel(bool $isActive): string
    {
        return $isActive
            ? (string) __('admin_users.statuses.active')
            : (string) __('admin_users.statuses.inactive');
    }

    public static function visibilityColor(bool $isActive): string
    {
        return $isActive ? 'success' : 'gray';
    }

    public static function visibilityIcon(bool $isActive): string
    {
        return $isActive ? 'heroicon-o-check-circle' : 'heroicon-o-lock-closed';
    }
}
