<?php

namespace App\Filament\Resources;

use App\Filament\AdminNavigation;
use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\CodeEditor;
use Filament\Forms\Components\CodeEditor\Enums\Language;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $slug = 'settings';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string|\UnitEnum|null $navigationGroup = AdminNavigation::GROUP_USERS_SETTINGS;

    protected static ?int $navigationSort = 20;

    protected static ?string $recordTitleAttribute = 'key';

    public static function getNavigationLabel(): string
    {
        return (string) __('admin_settings.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return (string) __('admin_settings.model.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return (string) __('admin_settings.model.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin_settings.form.sections.key.heading'))
                    ->description(__('admin_settings.form.sections.key.description'))
                    ->icon('heroicon-o-key')
                    ->compact()
                    ->schema([
                        TextInput::make('key')
                            ->label(__('admin_settings.form.fields.key.label'))
                            ->placeholder(__('admin_settings.form.fields.key.placeholder'))
                            ->prefixIcon('heroicon-o-key')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                    ]),
                Section::make(__('admin_settings.form.sections.value.heading'))
                    ->description(__('admin_settings.form.sections.value.description'))
                    ->icon('heroicon-o-code-bracket-square')
                    ->compact()
                    ->schema([
                        CodeEditor::make('value_json')
                            ->label(__('admin_settings.form.fields.value_json.label'))
                            ->language(Language::Json)
                            ->required()
                            ->json()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading(__('admin_settings.table.heading'))
            ->description(__('admin_settings.table.description'))
            ->columns([
                TextColumn::make('key')
                    ->label(__('admin_settings.table.columns.key'))
                    ->icon('heroicon-o-key')
                    ->weight(FontWeight::Bold)
                    ->description(fn (Setting $record): string => self::settingArea($record->key))
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('value')
                    ->label(__('admin_settings.table.columns.value'))
                    ->icon('heroicon-o-code-bracket-square')
                    ->formatStateUsing(fn (mixed $state): string => json_encode($state, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '')
                    ->limit(120)
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label(__('admin_settings.table.columns.updated'))
                    ->icon('heroicon-o-clock')
                    ->dateTime('M j, Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('key')
            ->stackedOnMobile()
            ->striped()
            ->defaultPaginationPageOption(25)
            ->paginated([10, 25, 50])
            ->recordUrl(fn (Setting $record): string => static::getUrl('edit', ['record' => $record]))
            ->emptyStateIcon('heroicon-o-cog-6-tooth')
            ->emptyStateHeading(__('admin_settings.table.empty_heading'))
            ->emptyStateDescription(__('admin_settings.table.empty_description'))
            ->filters([
                Filter::make('identity')
                    ->label(__('admin_settings.table.filters.identity'))
                    ->query(fn (Builder $query): Builder => $query->where('key', 'like', '%identity%')),
                Filter::make('seo')
                    ->label(__('admin_settings.table.filters.seo'))
                    ->query(fn (Builder $query): Builder => $query->where('key', 'like', '%seo%')),
                Filter::make('contact')
                    ->label(__('admin_settings.table.filters.contact'))
                    ->query(fn (Builder $query): Builder => $query->where(
                        fn (Builder $query): Builder => $query
                            ->where('key', 'like', '%contact%')
                            ->orWhere('key', 'like', '%direction%'),
                    )),
            ])
            ->filtersFormColumns([
                'default' => 1,
                'md' => 3,
            ])
            ->persistFiltersInSession()
            ->recordActions([
                EditAction::make()
                    ->label(__('admin_settings.actions.edit'))
                    ->icon('heroicon-o-pencil-square'),
                DeleteAction::make()
                    ->label(__('admin_settings.actions.delete'))
                    ->icon('heroicon-o-trash'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label(__('admin_settings.actions.delete_selected'))
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }

    public static function settingArea(?string $key): string
    {
        if (blank($key)) {
            return (string) __('admin_settings.empty_key');
        }

        $area = str((string) $key)->before('_')->headline();

        return (string) __('admin_settings.table.descriptions.area', [
            'area' => $area,
        ]);
    }
}
