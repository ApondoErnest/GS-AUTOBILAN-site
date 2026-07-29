<?php

namespace App\Filament\Resources;

use App\Filament\AdminNavigation;
use App\Filament\Resources\AgencyResource\Pages;
use App\Models\Agency;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
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

class AgencyResource extends Resource
{
    protected static ?string $model = Agency::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-office-2';

    protected static string|\UnitEnum|null $navigationGroup = AdminNavigation::GROUP_AGENCIES_SERVICES;

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'name_fr';

    public static function getNavigationLabel(): string
    {
        return (string) __('admin_agencies.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return (string) __('admin_agencies.model.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return (string) __('admin_agencies.model.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin_agencies.form.sections.identity.heading'))
                    ->description(__('admin_agencies.form.sections.identity.description'))
                    ->icon('heroicon-o-building-office-2')
                    ->compact()
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        TextInput::make('name_fr')
                            ->label(__('admin_agencies.form.fields.name_fr.label'))
                            ->placeholder(__('admin_agencies.form.fields.name_fr.placeholder'))
                            ->prefixIcon('heroicon-o-language')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('name_en')
                            ->label(__('admin_agencies.form.fields.name_en.label'))
                            ->placeholder(__('admin_agencies.form.fields.name_en.placeholder'))
                            ->prefixIcon('heroicon-o-language')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->label(__('admin_agencies.form.fields.slug.label'))
                            ->placeholder(__('admin_agencies.form.fields.slug.placeholder'))
                            ->prefixIcon('heroicon-o-link')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Select::make('status')
                            ->label(__('admin_agencies.form.fields.status.label'))
                            ->options(self::agencyStatusOptions())
                            ->native(false)
                            ->required()
                            ->default('operational'),
                        Toggle::make('is_active')
                            ->label(__('admin_agencies.form.fields.is_active.label'))
                            ->helperText(__('admin_agencies.form.fields.is_active.helper'))
                            ->inline(false)
                            ->default(true),
                        TextInput::make('sort_order')
                            ->label(__('admin_agencies.form.fields.sort_order.label'))
                            ->prefixIcon('heroicon-o-bars-3-bottom-left')
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                    ]),
                Section::make(__('admin_agencies.form.sections.contact.heading'))
                    ->description(__('admin_agencies.form.sections.contact.description'))
                    ->icon('heroicon-o-phone')
                    ->compact()
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        TagsInput::make('phones')
                            ->label(__('admin_agencies.form.fields.phones.label'))
                            ->placeholder(__('admin_agencies.form.fields.phones.placeholder'))
                            ->required()
                            ->reorderable()
                            ->helperText(__('admin_agencies.form.fields.phones.helper')),
                        TextInput::make('whatsapp')
                            ->label(__('admin_agencies.form.fields.whatsapp.label'))
                            ->placeholder(__('admin_agencies.form.fields.whatsapp.placeholder'))
                            ->prefixIcon('heroicon-o-chat-bubble-left-right')
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label(__('admin_agencies.form.fields.email.label'))
                            ->placeholder(__('admin_agencies.form.fields.email.placeholder'))
                            ->prefixIcon('heroicon-o-envelope')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('map_link')
                            ->label(__('admin_agencies.form.fields.map_link.label'))
                            ->placeholder(__('admin_agencies.form.fields.map_link.placeholder'))
                            ->prefixIcon('heroicon-o-map')
                            ->url()
                            ->maxLength(255),
                    ]),
                Section::make(__('admin_agencies.form.sections.location.heading'))
                    ->description(__('admin_agencies.form.sections.location.description'))
                    ->icon('heroicon-o-map-pin')
                    ->compact()
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        Textarea::make('address_fr')
                            ->label(__('admin_agencies.form.fields.address_fr.label'))
                            ->placeholder(__('admin_agencies.form.fields.address_fr.placeholder'))
                            ->required()
                            ->rows(3),
                        Textarea::make('address_en')
                            ->label(__('admin_agencies.form.fields.address_en.label'))
                            ->placeholder(__('admin_agencies.form.fields.address_en.placeholder'))
                            ->required()
                            ->rows(3),
                        TextInput::make('city')
                            ->label(__('admin_agencies.form.fields.city.label'))
                            ->placeholder(__('admin_agencies.form.fields.city.placeholder'))
                            ->prefixIcon('heroicon-o-building-library')
                            ->maxLength(255),
                        TextInput::make('quarter')
                            ->label(__('admin_agencies.form.fields.quarter.label'))
                            ->placeholder(__('admin_agencies.form.fields.quarter.placeholder'))
                            ->prefixIcon('heroicon-o-map-pin')
                            ->maxLength(255),
                        TextInput::make('latitude')
                            ->label(__('admin_agencies.form.fields.latitude.label'))
                            ->prefixIcon('heroicon-o-globe-alt')
                            ->numeric()
                            ->required(),
                        TextInput::make('longitude')
                            ->label(__('admin_agencies.form.fields.longitude.label'))
                            ->prefixIcon('heroicon-o-globe-alt')
                            ->numeric()
                            ->required(),
                    ]),
                Section::make(__('admin_agencies.form.sections.hours.heading'))
                    ->description(__('admin_agencies.form.sections.hours.description'))
                    ->icon('heroicon-o-clock')
                    ->compact()
                    ->collapsible()
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        KeyValue::make('opening_hours_fr')
                            ->label(__('admin_agencies.form.fields.opening_hours_fr.label'))
                            ->required()
                            ->keyLabel(__('admin_agencies.form.fields.opening_hours_fr.key'))
                            ->valueLabel(__('admin_agencies.form.fields.opening_hours_fr.value')),
                        KeyValue::make('opening_hours_en')
                            ->label(__('admin_agencies.form.fields.opening_hours_en.label'))
                            ->required()
                            ->keyLabel(__('admin_agencies.form.fields.opening_hours_en.key'))
                            ->valueLabel(__('admin_agencies.form.fields.opening_hours_en.value')),
                    ]),
                Section::make(__('admin_agencies.form.sections.descriptions.heading'))
                    ->description(__('admin_agencies.form.sections.descriptions.description'))
                    ->icon('heroicon-o-document-text')
                    ->compact()
                    ->collapsible()
                    ->columns([
                        'default' => 1,
                        'lg' => 2,
                    ])
                    ->schema([
                        Textarea::make('description_fr')
                            ->label(__('admin_agencies.form.fields.description_fr.label'))
                            ->placeholder(__('admin_agencies.form.fields.description_fr.placeholder'))
                            ->rows(4),
                        Textarea::make('description_en')
                            ->label(__('admin_agencies.form.fields.description_en.label'))
                            ->placeholder(__('admin_agencies.form.fields.description_en.placeholder'))
                            ->rows(4),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading(__('admin_agencies.table.heading'))
            ->description(__('admin_agencies.table.description'))
            ->columns([
                TextColumn::make('name_fr')
                    ->label(__('admin_agencies.table.columns.agency'))
                    ->icon('heroicon-o-building-office-2')
                    ->weight(FontWeight::Bold)
                    ->formatStateUsing(fn (Agency $record): string => self::localizedAgencyName($record))
                    ->description(fn (Agency $record): string => self::locationSummary($record))
                    ->searchable(['name_fr', 'name_en', 'slug', 'city', 'quarter'])
                    ->sortable()
                    ->wrap(),
                TextColumn::make('phones')
                    ->label(__('admin_agencies.table.columns.contact'))
                    ->icon('heroicon-o-phone')
                    ->formatStateUsing(fn (Agency $record): string => self::primaryPhone($record))
                    ->description(fn (Agency $record): string => self::contactSummary($record))
                    ->searchable(['phones', 'whatsapp', 'email'])
                    ->toggleable(),
                TextColumn::make('status')
                    ->label(__('admin_agencies.table.columns.status'))
                    ->badge()
                    ->formatStateUsing(fn (mixed $state): string => self::agencyStatusLabel($state))
                    ->color(fn (mixed $state): string => self::agencyStatusColor($state))
                    ->icon(fn (mixed $state): string => self::agencyStatusIcon($state))
                    ->description(fn (Agency $record): string => $record->is_active
                        ? (string) __('admin_agencies.table.descriptions.public')
                        : (string) __('admin_agencies.table.descriptions.hidden'))
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label(__('admin_agencies.table.columns.order'))
                    ->icon('heroicon-o-bars-3-bottom-left')
                    ->sortable()
                    ->toggleable()
                    ->visibleFrom('lg'),
                TextColumn::make('updated_at')
                    ->label(__('admin_agencies.table.columns.updated'))
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->visibleFrom('xl'),
            ])
            ->defaultSort('sort_order')
            ->stackedOnMobile()
            ->striped()
            ->defaultPaginationPageOption(25)
            ->paginated([10, 25, 50])
            ->recordUrl(fn (Agency $record): ?string => static::canEdit($record)
                ? static::getUrl('edit', ['record' => $record])
                : null)
            ->emptyStateIcon('heroicon-o-building-office-2')
            ->emptyStateHeading(__('admin_agencies.table.empty_heading'))
            ->emptyStateDescription(__('admin_agencies.table.empty_description'))
            ->filters([
                SelectFilter::make('status')
                    ->label(__('admin_agencies.table.filters.status'))
                    ->options(self::agencyStatusOptions())
                    ->native(false),
                TernaryFilter::make('is_active')
                    ->label(__('admin_agencies.table.filters.visibility')),
                Filter::make('updated_window')
                    ->label(__('admin_agencies.table.filters.updated_window'))
                    ->schema([
                        DatePicker::make('from')
                            ->label(__('admin_agencies.table.filters.from'))
                            ->native(false),
                        DatePicker::make('until')
                            ->label(__('admin_agencies.table.filters.until'))
                            ->native(false),
                    ])
                    ->columns(2)
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when(
                            $data['from'] ?? null,
                            fn (Builder $query, string $date): Builder => $query->whereDate('updated_at', '>=', $date),
                        )
                        ->when(
                            $data['until'] ?? null,
                            fn (Builder $query, string $date): Builder => $query->whereDate('updated_at', '<=', $date),
                        )),
            ])
            ->filtersFormColumns([
                'default' => 1,
                'md' => 2,
                'xl' => 3,
            ])
            ->persistFiltersInSession()
            ->recordActions([
                EditAction::make()
                    ->label(__('admin_agencies.actions.edit'))
                    ->icon('heroicon-o-pencil-square'),
                DeleteAction::make()
                    ->label(__('admin_agencies.actions.delete'))
                    ->icon('heroicon-o-trash'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label(__('admin_agencies.actions.delete_selected'))
                        ->icon('heroicon-o-trash'),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = Filament::auth()->user();

        if ($user instanceof User && $user->hasRole('agency_admin')) {
            return filled($user->assigned_agency_id)
                ? $query->whereKey($user->assigned_agency_id)
                : $query->whereRaw('1 = 0');
        }

        return $query;
    }

    /**
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAgencies::route('/'),
            'create' => Pages\CreateAgency::route('/create'),
            'edit' => Pages\EditAgency::route('/{record}/edit'),
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function agencyStatusOptions(): array
    {
        return [
            'operational' => (string) __('admin_agencies.statuses.agency.operational'),
            'temporarily_closed' => (string) __('admin_agencies.statuses.agency.temporarily_closed'),
        ];
    }

    public static function agencyStatusLabel(mixed $status): string
    {
        $value = self::agencyStatusValue($status);
        $key = "admin_agencies.statuses.agency.{$value}";

        return filled($value) && trans()->has($key)
            ? (string) __($key)
            : (string) __('admin_agencies.statuses.unknown');
    }

    public static function agencyStatusColor(mixed $status): string
    {
        return match (self::agencyStatusValue($status)) {
            'operational' => 'success',
            'temporarily_closed' => 'warning',
            default => 'gray',
        };
    }

    public static function agencyStatusIcon(mixed $status): string
    {
        return match (self::agencyStatusValue($status)) {
            'operational' => 'heroicon-o-check-circle',
            'temporarily_closed' => 'heroicon-o-pause-circle',
            default => 'heroicon-o-question-mark-circle',
        };
    }

    public static function localizedAgencyName(?Agency $agency): string
    {
        if (! $agency) {
            return (string) __('admin_agencies.table.descriptions.not_set');
        }

        $locale = app()->getLocale() === 'en' ? 'en' : 'fr';
        $name = $agency->getAttribute("name_{$locale}")
            ?: $agency->name_fr
            ?: $agency->name_en;

        return filled($name) ? (string) $name : (string) __('admin_agencies.table.descriptions.not_set');
    }

    public static function locationSummary(Agency $agency): string
    {
        return collect([
            $agency->city,
            $agency->quarter,
        ])->filter()->join(' - ') ?: (string) __('admin_agencies.table.descriptions.no_location');
    }

    public static function primaryPhone(Agency $agency): string
    {
        $phone = collect($agency->phones ?? [])->first();

        return filled($phone) ? (string) $phone : (string) __('admin_agencies.table.descriptions.no_phone');
    }

    public static function contactSummary(Agency $agency): string
    {
        return collect([
            filled($agency->whatsapp) ? __('admin_agencies.table.descriptions.whatsapp', ['phone' => $agency->whatsapp]) : null,
            $agency->email,
        ])->filter()->join(' - ') ?: (string) __('admin_agencies.table.descriptions.no_contact');
    }

    private static function agencyStatusValue(mixed $status): ?string
    {
        return is_string($status) ? $status : null;
    }
}
