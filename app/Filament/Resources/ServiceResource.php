<?php

namespace App\Filament\Resources;

use App\Filament\AdminNavigation;
use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static string|\UnitEnum|null $navigationGroup = AdminNavigation::GROUP_AGENCIES_SERVICES;

    protected static ?int $navigationSort = 20;

    protected static ?string $recordTitleAttribute = 'title_fr';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Bilingual content')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title_fr')
                            ->label('Title FR')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('title_en')
                            ->label('Title EN')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug_fr')
                            ->label('Slug FR')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('slug_en')
                            ->label('Slug EN')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Textarea::make('short_description_fr')
                            ->label('Short description FR')
                            ->required()
                            ->rows(3),
                        Textarea::make('short_description_en')
                            ->label('Short description EN')
                            ->required()
                            ->rows(3),
                        Textarea::make('full_description_fr')
                            ->label('Full description FR')
                            ->rows(5),
                        Textarea::make('full_description_en')
                            ->label('Full description EN')
                            ->rows(5),
                    ]),
                Section::make('Display')
                    ->columns(2)
                    ->schema([
                        TextInput::make('icon')
                            ->maxLength(255)
                            ->helperText('Optional icon key for public components.'),
                        FileUpload::make('image')
                            ->image()
                            ->directory('services')
                            ->visibility('public'),
                        TextInput::make('sort_order')
                            ->label('Sort order')
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->toggleable(),
                TextColumn::make('title_fr')
                    ->label('Service')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title_en')
                    ->label('Service EN')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('icon')
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
