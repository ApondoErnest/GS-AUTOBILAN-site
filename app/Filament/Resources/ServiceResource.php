<?php

namespace App\Filament\Resources;

use App\Filament\AdminNavigation;
use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Support\SecureImageUpload;
use App\Models\Service;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static string|\UnitEnum|null $navigationGroup = AdminNavigation::GROUP_AGENCIES_SERVICES;

    protected static ?int $navigationSort = 20;

    protected static ?string $recordTitleAttribute = 'title_fr';

    public static function getNavigationLabel(): string
    {
        return (string) __('admin_services.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return (string) __('admin_services.model.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return (string) __('admin_services.model.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin_services.form.sections.content.heading'))
                    ->description(__('admin_services.form.sections.content.description'))
                    ->icon('heroicon-o-language')
                    ->compact()
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        TextInput::make('title_fr')
                            ->label(__('admin_services.form.fields.title_fr.label'))
                            ->placeholder(__('admin_services.form.fields.title_fr.placeholder'))
                            ->prefixIcon('heroicon-o-language')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('title_en')
                            ->label(__('admin_services.form.fields.title_en.label'))
                            ->placeholder(__('admin_services.form.fields.title_en.placeholder'))
                            ->prefixIcon('heroicon-o-language')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug_fr')
                            ->label(__('admin_services.form.fields.slug_fr.label'))
                            ->placeholder(__('admin_services.form.fields.slug_fr.placeholder'))
                            ->prefixIcon('heroicon-o-link')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('slug_en')
                            ->label(__('admin_services.form.fields.slug_en.label'))
                            ->placeholder(__('admin_services.form.fields.slug_en.placeholder'))
                            ->prefixIcon('heroicon-o-link')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Textarea::make('short_description_fr')
                            ->label(__('admin_services.form.fields.short_description_fr.label'))
                            ->placeholder(__('admin_services.form.fields.short_description_fr.placeholder'))
                            ->required()
                            ->rows(3),
                        Textarea::make('short_description_en')
                            ->label(__('admin_services.form.fields.short_description_en.label'))
                            ->placeholder(__('admin_services.form.fields.short_description_en.placeholder'))
                            ->required()
                            ->rows(3),
                    ]),
                Section::make(__('admin_services.form.sections.display.heading'))
                    ->description(__('admin_services.form.sections.display.description'))
                    ->icon('heroicon-o-photo')
                    ->compact()
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        TextInput::make('icon')
                            ->label(__('admin_services.form.fields.icon.label'))
                            ->placeholder(__('admin_services.form.fields.icon.placeholder'))
                            ->prefixIcon('heroicon-o-sparkles')
                            ->maxLength(255)
                            ->helperText(__('admin_services.form.fields.icon.helper')),
                        SecureImageUpload::make('image', 'services')
                            ->label(__('admin_services.form.fields.image.label')),
                        TextInput::make('sort_order')
                            ->label(__('admin_services.form.fields.sort_order.label'))
                            ->prefixIcon('heroicon-o-bars-3-bottom-left')
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                        Toggle::make('is_active')
                            ->label(__('admin_services.form.fields.is_active.label'))
                            ->helperText(__('admin_services.form.fields.is_active.helper'))
                            ->inline(false)
                            ->default(true),
                    ]),
                Section::make(__('admin_services.form.sections.descriptions.heading'))
                    ->description(__('admin_services.form.sections.descriptions.description'))
                    ->icon('heroicon-o-document-text')
                    ->compact()
                    ->collapsible()
                    ->columns([
                        'default' => 1,
                        'lg' => 2,
                    ])
                    ->schema([
                        Textarea::make('full_description_fr')
                            ->label(__('admin_services.form.fields.full_description_fr.label'))
                            ->placeholder(__('admin_services.form.fields.full_description_fr.placeholder'))
                            ->rows(5),
                        Textarea::make('full_description_en')
                            ->label(__('admin_services.form.fields.full_description_en.label'))
                            ->placeholder(__('admin_services.form.fields.full_description_en.placeholder'))
                            ->rows(5),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading(__('admin_services.table.heading'))
            ->description(__('admin_services.table.description'))
            ->columns([
                ImageColumn::make('image')
                    ->label(__('admin_services.table.columns.image'))
                    ->toggleable()
                    ->visibleFrom('md'),
                TextColumn::make('title_fr')
                    ->label(__('admin_services.table.columns.service'))
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->weight(FontWeight::Bold)
                    ->formatStateUsing(fn (Service $record): string => self::localizedServiceTitle($record))
                    ->description(fn (Service $record): string => self::localizedShortDescription($record))
                    ->searchable(['title_fr', 'title_en', 'slug_fr', 'slug_en'])
                    ->sortable()
                    ->wrap(),
                TextColumn::make('slug_fr')
                    ->label(__('admin_services.table.columns.slugs'))
                    ->icon('heroicon-o-link')
                    ->description(fn (Service $record): string => $record->slug_en ?: (string) __('admin_services.table.descriptions.no_english_slug'))
                    ->copyable()
                    ->copyMessage(__('admin_services.table.copy_slug'))
                    ->toggleable()
                    ->visibleFrom('lg'),
                TextColumn::make('icon')
                    ->label(__('admin_services.table.columns.icon'))
                    ->placeholder(__('admin_services.table.descriptions.not_set'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('is_active')
                    ->label(__('admin_services.table.columns.visibility'))
                    ->badge()
                    ->formatStateUsing(fn (mixed $state): string => self::visibilityLabel((bool) $state))
                    ->color(fn (mixed $state): string => self::visibilityColor((bool) $state))
                    ->icon(fn (mixed $state): string => self::visibilityIcon((bool) $state))
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label(__('admin_services.table.columns.order'))
                    ->icon('heroicon-o-bars-3-bottom-left')
                    ->sortable()
                    ->toggleable()
                    ->visibleFrom('lg'),
                TextColumn::make('updated_at')
                    ->label(__('admin_services.table.columns.updated'))
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
            ->recordUrl(fn (Service $record): ?string => static::canEdit($record)
                ? static::getUrl('edit', ['record' => $record])
                : null)
            ->emptyStateIcon('heroicon-o-wrench-screwdriver')
            ->emptyStateHeading(__('admin_services.table.empty_heading'))
            ->emptyStateDescription(__('admin_services.table.empty_description'))
            ->filters([
                TernaryFilter::make('is_active')
                    ->label(__('admin_services.table.filters.visibility')),
                Filter::make('missing_image')
                    ->label(__('admin_services.table.filters.missing_image'))
                    ->query(fn (Builder $query): Builder => $query->whereNull('image')),
                Filter::make('updated_window')
                    ->label(__('admin_services.table.filters.updated_window'))
                    ->schema([
                        DatePicker::make('from')
                            ->label(__('admin_services.table.filters.from'))
                            ->native(false),
                        DatePicker::make('until')
                            ->label(__('admin_services.table.filters.until'))
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
                    ->label(__('admin_services.actions.edit'))
                    ->icon('heroicon-o-pencil-square'),
                DeleteAction::make()
                    ->label(__('admin_services.actions.delete'))
                    ->icon('heroicon-o-trash'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label(__('admin_services.actions.delete_selected'))
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }

    public static function localizedServiceTitle(?Service $service): string
    {
        if (! $service) {
            return (string) __('admin_services.table.descriptions.not_set');
        }

        $locale = app()->getLocale() === 'en' ? 'en' : 'fr';
        $title = $service->getAttribute("title_{$locale}")
            ?: $service->title_fr
            ?: $service->title_en;

        return filled($title) ? (string) $title : (string) __('admin_services.table.descriptions.not_set');
    }

    public static function localizedShortDescription(?Service $service): string
    {
        if (! $service) {
            return (string) __('admin_services.table.descriptions.no_summary');
        }

        $locale = app()->getLocale() === 'en' ? 'en' : 'fr';
        $description = $service->getAttribute("short_description_{$locale}")
            ?: $service->short_description_fr
            ?: $service->short_description_en;

        return filled($description) ? (string) $description : (string) __('admin_services.table.descriptions.no_summary');
    }

    public static function visibilityLabel(bool $isActive): string
    {
        return $isActive
            ? (string) __('admin_services.statuses.visibility.active')
            : (string) __('admin_services.statuses.visibility.hidden');
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
