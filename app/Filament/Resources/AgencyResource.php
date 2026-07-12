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
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TagsInput;
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
use Illuminate\Database\Eloquent\Builder;

class AgencyResource extends Resource
{
    protected static ?string $model = Agency::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-office-2';

    protected static string|\UnitEnum|null $navigationGroup = AdminNavigation::GROUP_AGENCIES_SERVICES;

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'name_fr';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identity')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name_fr')
                            ->label('Name FR')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('name_en')
                            ->label('Name EN')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('status')
                            ->required()
                            ->maxLength(255)
                            ->default('operational'),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                        TextInput::make('sort_order')
                            ->label('Sort order')
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                    ]),
                Section::make('Contact')
                    ->columns(2)
                    ->schema([
                        TagsInput::make('phones')
                            ->required()
                            ->reorderable()
                            ->helperText('Add one or more public phone numbers.'),
                        TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('map_link')
                            ->label('Map link')
                            ->url()
                            ->maxLength(255),
                    ]),
                Section::make('Location')
                    ->columns(2)
                    ->schema([
                        Textarea::make('address_fr')
                            ->label('Address FR')
                            ->required()
                            ->rows(3),
                        Textarea::make('address_en')
                            ->label('Address EN')
                            ->required()
                            ->rows(3),
                        TextInput::make('city')
                            ->maxLength(255),
                        TextInput::make('quarter')
                            ->maxLength(255),
                        TextInput::make('latitude')
                            ->numeric()
                            ->required(),
                        TextInput::make('longitude')
                            ->numeric()
                            ->required(),
                    ]),
                Section::make('Opening hours')
                    ->columns(2)
                    ->schema([
                        KeyValue::make('opening_hours_fr')
                            ->label('Opening hours FR')
                            ->required()
                            ->keyLabel('Period')
                            ->valueLabel('Hours'),
                        KeyValue::make('opening_hours_en')
                            ->label('Opening hours EN')
                            ->required()
                            ->keyLabel('Period')
                            ->valueLabel('Hours'),
                    ]),
                Section::make('Descriptions')
                    ->columns(2)
                    ->schema([
                        Textarea::make('description_fr')
                            ->label('Description FR')
                            ->rows(4),
                        Textarea::make('description_en')
                            ->label('Description EN')
                            ->rows(4),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name_fr')
                    ->label('Agency')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('city')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('quarter')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('phones')
                    ->badge()
                    ->limitList(2),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'operational' ? 'success' : 'warning')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'operational' => 'Operational',
                        'temporarily_closed' => 'Temporarily closed',
                    ]),
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
}
