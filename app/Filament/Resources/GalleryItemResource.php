<?php

namespace App\Filament\Resources;

use App\Enums\GalleryCategory;
use App\Filament\AdminNavigation;
use App\Filament\Resources\GalleryItemResource\Pages;
use App\Models\Agency;
use App\Models\GalleryItem;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class GalleryItemResource extends Resource
{
    protected static ?string $model = GalleryItem::class;

    protected static ?string $slug = 'gallery-items';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected static string|\UnitEnum|null $navigationGroup = AdminNavigation::GROUP_CONTENT;

    protected static ?int $navigationSort = 30;

    protected static ?string $recordTitleAttribute = 'caption_fr';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Image')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('image_path')
                            ->label('Image')
                            ->image()
                            ->directory('gallery')
                            ->visibility('public')
                            ->required(),
                        Select::make('category')
                            ->options(self::galleryCategoryOptions())
                            ->required(),
                        Select::make('agency_id')
                            ->label('Agency')
                            ->options(fn (): array => Agency::query()
                                ->ordered()
                                ->pluck('name_fr', 'id')
                                ->all())
                            ->searchable(),
                    ]),
                Section::make('Captions')
                    ->columns(2)
                    ->schema([
                        Textarea::make('caption_fr')
                            ->label('Caption FR')
                            ->rows(3),
                        Textarea::make('caption_en')
                            ->label('Caption EN')
                            ->rows(3),
                    ]),
                Section::make('Display')
                    ->columns(2)
                    ->schema([
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
                ImageColumn::make('image_path')
                    ->label('Image'),
                TextColumn::make('caption_fr')
                    ->label('Caption')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->badge()
                    ->formatStateUsing(fn (mixed $state): string => self::galleryCategoryLabel($state))
                    ->sortable(),
                TextColumn::make('agency.name_fr')
                    ->label('Agency')
                    ->searchable()
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                SelectFilter::make('category')
                    ->options(self::galleryCategoryOptions()),
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
            'index' => Pages\ListGalleryItems::route('/'),
            'create' => Pages\CreateGalleryItem::route('/create'),
            'edit' => Pages\EditGalleryItem::route('/{record}/edit'),
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function galleryCategoryOptions(): array
    {
        return collect(GalleryCategory::cases())
            ->mapWithKeys(fn (GalleryCategory $category): array => [$category->value => self::galleryCategoryLabel($category)])
            ->all();
    }

    public static function galleryCategoryLabel(mixed $category): string
    {
        return match (self::galleryCategoryValue($category)) {
            GalleryCategory::AgencyExterior->value => 'Agency exterior',
            GalleryCategory::Reception->value => 'Reception',
            GalleryCategory::InspectionLane->value => 'Inspection lane',
            GalleryCategory::Staff->value => 'Staff',
            GalleryCategory::Equipment->value => 'Equipment',
            GalleryCategory::CustomerArea->value => 'Customer area',
            default => 'Unknown',
        };
    }

    private static function galleryCategoryValue(mixed $category): ?string
    {
        return $category instanceof GalleryCategory ? $category->value : $category;
    }
}
