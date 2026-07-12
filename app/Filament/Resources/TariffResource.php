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
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class TariffResource extends Resource
{
    protected static ?string $model = Tariff::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static string|\UnitEnum|null $navigationGroup = AdminNavigation::GROUP_TARIFFS;

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'vehicle_type_fr';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Tariff details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('category')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('vehicle_type_fr')
                            ->label('Vehicle type FR')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('vehicle_type_en')
                            ->label('Vehicle type EN')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('price')
                            ->numeric()
                            ->minValue(0)
                            ->step('0.01'),
                        TextInput::make('currency')
                            ->required()
                            ->maxLength(3)
                            ->default('XAF'),
                        TextInput::make('validity')
                            ->maxLength(255),
                        TextInput::make('sort_order')
                            ->label('Sort order')
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                        DateTimePicker::make('last_updated_at')
                            ->label('Last updated')
                            ->seconds(false)
                            ->native(false),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                        Toggle::make('is_placeholder')
                            ->label('Placeholder')
                            ->helperText('Keep enabled until the official tariff has been confirmed.')
                            ->default(true),
                    ]),
                Section::make('Notes')
                    ->columns(2)
                    ->schema([
                        Textarea::make('notes_fr')
                            ->label('Notes FR')
                            ->rows(4),
                        Textarea::make('notes_en')
                            ->label('Notes EN')
                            ->rows(4),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vehicle_type_fr')
                    ->label('Vehicle type')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Price')
                    ->formatStateUsing(fn (?string $state, Tariff $record): string => self::formatPrice($state, $record))
                    ->sortable(),
                TextColumn::make('is_placeholder')
                    ->label('Placeholder')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Placeholder' : 'Official')
                    ->color(fn (bool $state): string => $state ? 'warning' : 'success')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('last_updated_at')
                    ->label('Last updated')
                    ->dateTime('M j, Y H:i')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                SelectFilter::make('category')
                    ->options(fn (): array => Tariff::query()
                        ->whereNotNull('category')
                        ->orderBy('category')
                        ->pluck('category', 'category')
                        ->all()),
                TernaryFilter::make('is_placeholder')
                    ->label('Placeholder'),
                TernaryFilter::make('is_active')
                    ->label('Active'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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

    private static function formatPrice(?string $price, Tariff $tariff): string
    {
        if ($tariff->is_placeholder || blank($price)) {
            return 'Pending official tariff';
        }

        return number_format((float) $price, 0, '.', ' ').' '.$tariff->currency;
    }
}
