<?php

namespace App\Filament\Resources;

use App\Filament\AdminNavigation;
use App\Filament\Resources\TariffResource\Pages;
use App\Models\Tariff;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
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

class TariffResource extends Resource
{
    protected static ?string $model = Tariff::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static string|\UnitEnum|null $navigationGroup = AdminNavigation::GROUP_TARIFFS;

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'vehicle_type_fr';

    public static function getNavigationLabel(): string
    {
        return (string) __('admin_tariffs.resource.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return (string) __('admin_tariffs.resource.model.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return (string) __('admin_tariffs.resource.model.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin_tariffs.resource.form.sections.vehicle.heading'))
                    ->description(__('admin_tariffs.resource.form.sections.vehicle.description'))
                    ->icon('heroicon-o-truck')
                    ->compact()
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        TextInput::make('category')
                            ->label(__('admin_tariffs.resource.form.fields.category.label'))
                            ->placeholder(__('admin_tariffs.resource.form.fields.category.placeholder'))
                            ->prefixIcon('heroicon-o-squares-2x2')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('vehicle_type_fr')
                            ->label(__('admin_tariffs.resource.form.fields.vehicle_type_fr.label'))
                            ->placeholder(__('admin_tariffs.resource.form.fields.vehicle_type_fr.placeholder'))
                            ->prefixIcon('heroicon-o-language')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('vehicle_type_en')
                            ->label(__('admin_tariffs.resource.form.fields.vehicle_type_en.label'))
                            ->placeholder(__('admin_tariffs.resource.form.fields.vehicle_type_en.placeholder'))
                            ->prefixIcon('heroicon-o-language')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('validity')
                            ->label(__('admin_tariffs.resource.form.fields.validity.label'))
                            ->placeholder(__('admin_tariffs.resource.form.fields.validity.placeholder'))
                            ->prefixIcon('heroicon-o-calendar-days')
                            ->maxLength(255),
                        TextInput::make('sort_order')
                            ->label(__('admin_tariffs.resource.form.fields.sort_order.label'))
                            ->prefixIcon('heroicon-o-bars-3-bottom-left')
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                    ]),
                Section::make(__('admin_tariffs.resource.form.sections.pricing.heading'))
                    ->description(__('admin_tariffs.resource.form.sections.pricing.description'))
                    ->icon('heroicon-o-banknotes')
                    ->compact()
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        TextInput::make('price')
                            ->label(__('admin_tariffs.resource.form.fields.price.label'))
                            ->placeholder(__('admin_tariffs.resource.form.fields.price.placeholder'))
                            ->prefixIcon('heroicon-o-banknotes')
                            ->numeric()
                            ->minValue(0)
                            ->step('0.01'),
                        TextInput::make('currency')
                            ->label(__('admin_tariffs.resource.form.fields.currency.label'))
                            ->placeholder(__('admin_tariffs.resource.form.fields.currency.placeholder'))
                            ->prefixIcon('heroicon-o-globe-alt')
                            ->required()
                            ->maxLength(3)
                            ->default('XAF'),
                        DateTimePicker::make('last_updated_at')
                            ->label(__('admin_tariffs.resource.form.fields.last_updated_at.label'))
                            ->seconds(false)
                            ->native(false),
                        Toggle::make('is_active')
                            ->label(__('admin_tariffs.resource.form.fields.is_active.label'))
                            ->helperText(__('admin_tariffs.resource.form.fields.is_active.helper'))
                            ->inline(false)
                            ->default(true),
                        Toggle::make('is_placeholder')
                            ->label(__('admin_tariffs.resource.form.fields.is_placeholder.label'))
                            ->helperText(__('admin_tariffs.resource.form.fields.is_placeholder.helper'))
                            ->inline(false)
                            ->default(true),
                    ]),
                Section::make(__('admin_tariffs.resource.form.sections.notes.heading'))
                    ->description(__('admin_tariffs.resource.form.sections.notes.description'))
                    ->icon('heroicon-o-document-text')
                    ->compact()
                    ->collapsible()
                    ->columns([
                        'default' => 1,
                        'lg' => 2,
                    ])
                    ->schema([
                        Textarea::make('notes_fr')
                            ->label(__('admin_tariffs.resource.form.fields.notes_fr.label'))
                            ->placeholder(__('admin_tariffs.resource.form.fields.notes_fr.placeholder'))
                            ->rows(4),
                        Textarea::make('notes_en')
                            ->label(__('admin_tariffs.resource.form.fields.notes_en.label'))
                            ->placeholder(__('admin_tariffs.resource.form.fields.notes_en.placeholder'))
                            ->rows(4),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading(__('admin_tariffs.resource.table.heading'))
            ->description(__('admin_tariffs.resource.table.description'))
            ->columns([
                TextColumn::make('vehicle_type_fr')
                    ->label(__('admin_tariffs.resource.table.columns.vehicle'))
                    ->icon('heroicon-o-truck')
                    ->weight(FontWeight::Bold)
                    ->formatStateUsing(fn (Tariff $record): string => self::localizedVehicleType($record))
                    ->description(fn (Tariff $record): string => self::tariffSummary($record))
                    ->searchable(['vehicle_type_fr', 'vehicle_type_en', 'category', 'validity'])
                    ->sortable()
                    ->wrap(),
                TextColumn::make('category')
                    ->label(__('admin_tariffs.resource.table.columns.category'))
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => self::categoryLabel($state))
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->visibleFrom('md'),
                TextColumn::make('price')
                    ->label(__('admin_tariffs.resource.table.columns.price'))
                    ->icon('heroicon-o-banknotes')
                    ->placeholder(__('admin_tariffs.resource.table.descriptions.pending_price'))
                    ->formatStateUsing(fn (?string $state, Tariff $record): string => self::formatPrice($state, $record))
                    ->description(fn (Tariff $record): string => self::localizedNotes($record))
                    ->sortable(),
                TextColumn::make('is_placeholder')
                    ->label(__('admin_tariffs.resource.table.columns.pricing_state'))
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => self::placeholderLabel($state))
                    ->color(fn (bool $state): string => self::placeholderColor($state))
                    ->icon(fn (bool $state): string => self::placeholderIcon($state))
                    ->sortable(),
                TextColumn::make('is_active')
                    ->label(__('admin_tariffs.resource.table.columns.visibility'))
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => self::visibilityLabel($state))
                    ->color(fn (bool $state): string => self::visibilityColor($state))
                    ->icon(fn (bool $state): string => self::visibilityIcon($state))
                    ->sortable(),
                TextColumn::make('last_updated_at')
                    ->label(__('admin_tariffs.resource.table.columns.last_updated'))
                    ->dateTime('M j, Y H:i')
                    ->placeholder(__('admin_tariffs.resource.table.descriptions.not_updated'))
                    ->sortable()
                    ->toggleable()
                    ->visibleFrom('lg'),
                TextColumn::make('sort_order')
                    ->label(__('admin_tariffs.resource.table.columns.order'))
                    ->icon('heroicon-o-bars-3-bottom-left')
                    ->sortable()
                    ->toggleable()
                    ->visibleFrom('xl'),
            ])
            ->defaultSort('sort_order')
            ->stackedOnMobile()
            ->striped()
            ->defaultPaginationPageOption(25)
            ->paginated([10, 25, 50])
            ->recordUrl(fn (Tariff $record): string => static::getUrl('edit', ['record' => $record]))
            ->emptyStateIcon('heroicon-o-banknotes')
            ->emptyStateHeading(__('admin_tariffs.resource.table.empty_heading'))
            ->emptyStateDescription(__('admin_tariffs.resource.table.empty_description'))
            ->filters([
                SelectFilter::make('category')
                    ->label(__('admin_tariffs.resource.table.filters.category'))
                    ->options(fn (): array => self::categoryOptions())
                    ->searchable()
                    ->native(false),
                TernaryFilter::make('is_placeholder')
                    ->label(__('admin_tariffs.resource.table.filters.pricing_state')),
                TernaryFilter::make('is_active')
                    ->label(__('admin_tariffs.resource.table.filters.visibility')),
                Filter::make('missing_price')
                    ->label(__('admin_tariffs.resource.table.filters.missing_price'))
                    ->query(fn (Builder $query): Builder => $query->whereNull('price')),
                Filter::make('updated_window')
                    ->label(__('admin_tariffs.resource.table.filters.updated_window'))
                    ->schema([
                        DatePicker::make('from')
                            ->label(__('admin_tariffs.resource.table.filters.from'))
                            ->native(false),
                        DatePicker::make('until')
                            ->label(__('admin_tariffs.resource.table.filters.until'))
                            ->native(false),
                    ])
                    ->columns(2)
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when(
                            $data['from'] ?? null,
                            fn (Builder $query, string $date): Builder => $query->whereDate('last_updated_at', '>=', $date),
                        )
                        ->when(
                            $data['until'] ?? null,
                            fn (Builder $query, string $date): Builder => $query->whereDate('last_updated_at', '<=', $date),
                        )),
            ])
            ->filtersFormColumns([
                'default' => 1,
                'md' => 2,
                'xl' => 4,
            ])
            ->persistFiltersInSession()
            ->recordActions([
                EditAction::make()
                    ->label(__('admin_tariffs.resource.actions.edit'))
                    ->icon('heroicon-o-pencil-square'),
                DeleteAction::make()
                    ->label(__('admin_tariffs.resource.actions.delete'))
                    ->icon('heroicon-o-trash'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label(__('admin_tariffs.resource.actions.delete_selected'))
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
            'index' => Pages\ListTariffs::route('/'),
            'create' => Pages\CreateTariff::route('/create'),
            'edit' => Pages\EditTariff::route('/{record}/edit'),
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function categoryOptions(): array
    {
        return Tariff::query()
            ->whereNotNull('category')
            ->orderBy('category')
            ->pluck('category', 'category')
            ->map(fn (?string $category): string => self::categoryLabel($category))
            ->all();
    }

    public static function formatPrice(?string $price, Tariff $tariff): string
    {
        if ($tariff->is_placeholder || blank($price)) {
            return (string) __('admin_tariffs.resource.table.descriptions.pending_price');
        }

        return number_format((float) $price, 0, '.', ' ').' '.($tariff->currency ?: 'XAF');
    }

    public static function localizedVehicleType(?Tariff $tariff): string
    {
        if (! $tariff) {
            return (string) __('admin_tariffs.empty_value');
        }

        $locale = app()->getLocale() === 'en' ? 'en' : 'fr';
        $vehicleType = $tariff->getAttribute("vehicle_type_{$locale}")
            ?: $tariff->vehicle_type_fr
            ?: $tariff->vehicle_type_en;

        return filled($vehicleType) ? (string) $vehicleType : (string) __('admin_tariffs.empty_value');
    }

    public static function localizedNotes(Tariff $tariff): string
    {
        $locale = app()->getLocale() === 'en' ? 'en' : 'fr';
        $notes = $tariff->getAttribute("notes_{$locale}")
            ?: $tariff->notes_fr
            ?: $tariff->notes_en;

        return filled($notes) ? (string) $notes : (string) __('admin_tariffs.resource.table.descriptions.no_notes');
    }

    public static function tariffSummary(Tariff $tariff): string
    {
        return collect([
            self::categoryLabel($tariff->category),
            $tariff->validity,
        ])->filter()->join(' - ') ?: (string) __('admin_tariffs.empty_value');
    }

    public static function categoryLabel(?string $category): string
    {
        if (blank($category)) {
            return (string) __('admin_tariffs.empty_value');
        }

        $key = "admin_tariffs.resource.categories.{$category}";

        return trans()->has($key)
            ? (string) __($key)
            : (string) str($category)->replace(['_', '-'], ' ')->headline();
    }

    public static function placeholderLabel(bool $isPlaceholder): string
    {
        return $isPlaceholder
            ? (string) __('admin_tariffs.resource.statuses.placeholder')
            : (string) __('admin_tariffs.resource.statuses.official');
    }

    public static function placeholderColor(bool $isPlaceholder): string
    {
        return $isPlaceholder ? 'warning' : 'success';
    }

    public static function placeholderIcon(bool $isPlaceholder): string
    {
        return $isPlaceholder ? 'heroicon-o-clock' : 'heroicon-o-check-circle';
    }

    public static function visibilityLabel(bool $isActive): string
    {
        return $isActive
            ? (string) __('admin_tariffs.resource.statuses.active')
            : (string) __('admin_tariffs.resource.statuses.hidden');
    }

    public static function visibilityColor(bool $isActive): string
    {
        return $isActive ? 'success' : 'gray';
    }

    public static function visibilityIcon(bool $isActive): string
    {
        return $isActive ? 'heroicon-o-eye' : 'heroicon-o-eye-slash';
    }
}
