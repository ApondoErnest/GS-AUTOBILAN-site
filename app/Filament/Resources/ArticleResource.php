<?php

namespace App\Filament\Resources;

use App\Enums\ArticleStatus;
use App\Filament\AdminNavigation;
use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use App\Models\ArticleCategory;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $slug = 'articles';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-newspaper';

    protected static string|\UnitEnum|null $navigationGroup = AdminNavigation::GROUP_CONTENT;

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'title_fr';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Bilingual content')
                    ->columns(2)
                    ->schema([
                        Select::make('category_id')
                            ->label('Category')
                            ->options(fn (): array => ArticleCategory::query()
                                ->ordered()
                                ->pluck('name_fr', 'id')
                                ->all())
                            ->searchable(),
                        Select::make('status')
                            ->options(self::articleStatusOptions())
                            ->default(ArticleStatus::Draft->value)
                            ->required(),
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
                        Textarea::make('summary_fr')
                            ->label('Summary FR')
                            ->rows(3),
                        Textarea::make('summary_en')
                            ->label('Summary EN')
                            ->rows(3),
                        Textarea::make('content_fr')
                            ->label('Content FR')
                            ->required()
                            ->rows(8),
                        Textarea::make('content_en')
                            ->label('Content EN')
                            ->required()
                            ->rows(8),
                    ]),
                Section::make('Publishing')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('featured_image')
                            ->label('Featured image')
                            ->image()
                            ->directory('articles')
                            ->visibility('public'),
                        DateTimePicker::make('published_at')
                            ->label('Published at')
                            ->seconds(false)
                            ->native(false),
                    ]),
                Section::make('SEO')
                    ->columns(2)
                    ->schema([
                        TextInput::make('meta_title_fr')
                            ->label('Meta title FR')
                            ->maxLength(255),
                        TextInput::make('meta_title_en')
                            ->label('Meta title EN')
                            ->maxLength(255),
                        Textarea::make('meta_description_fr')
                            ->label('Meta description FR')
                            ->rows(3),
                        Textarea::make('meta_description_en')
                            ->label('Meta description EN')
                            ->rows(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->label('Image')
                    ->toggleable(),
                TextColumn::make('title_fr')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name_fr')
                    ->label('Category')
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (mixed $state): string => self::articleStatusLabel($state))
                    ->color(fn (mixed $state): string => self::articleStatusColor($state))
                    ->sortable(),
                TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime('M j, Y H:i')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('M j, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options(self::articleStatusOptions()),
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function articleStatusOptions(): array
    {
        return collect(ArticleStatus::cases())
            ->mapWithKeys(fn (ArticleStatus $status): array => [$status->value => self::articleStatusLabel($status)])
            ->all();
    }

    public static function articleStatusLabel(mixed $status): string
    {
        return match (self::articleStatusValue($status)) {
            ArticleStatus::Draft->value => 'Draft',
            ArticleStatus::Published->value => 'Published',
            ArticleStatus::Archived->value => 'Archived',
            default => 'Unknown',
        };
    }

    public static function articleStatusColor(mixed $status): string
    {
        return match (self::articleStatusValue($status)) {
            ArticleStatus::Draft->value => 'gray',
            ArticleStatus::Published->value => 'success',
            ArticleStatus::Archived->value => 'warning',
            default => 'gray',
        };
    }

    private static function articleStatusValue(mixed $status): ?string
    {
        return $status instanceof ArticleStatus ? $status->value : $status;
    }
}
