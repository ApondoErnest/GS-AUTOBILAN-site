<?php

namespace App\Filament\Resources;

use App\Enums\ContactStatus;
use App\Filament\AdminNavigation;
use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\Agency;
use App\Models\ContactMessage;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $slug = 'contact-messages';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-inbox';

    protected static string|\UnitEnum|null $navigationGroup = AdminNavigation::GROUP_COMMUNICATION;

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'subject';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Sender')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        Select::make('agency_id')
                            ->label('Agency')
                            ->options(fn (): array => self::agencyOptions())
                            ->default(fn (): ?int => self::currentAgencyAdmin()?->assigned_agency_id)
                            ->disabled(fn (): bool => self::isAgencyAdmin())
                            ->dehydrated()
                            ->searchable(),
                    ]),
                Section::make('Message')
                    ->schema([
                        TextInput::make('subject')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('message')
                            ->required()
                            ->rows(5),
                    ]),
                Section::make('Handling')
                    ->columns(2)
                    ->schema([
                        Select::make('status')
                            ->options(self::contactStatusOptions())
                            ->default(ContactStatus::New->value)
                            ->required(),
                        Select::make('assigned_user_id')
                            ->label('Assigned user')
                            ->options(fn (): array => User::query()
                                ->orderBy('name')
                                ->pluck('name', 'id')
                                ->all())
                            ->searchable(),
                        Textarea::make('internal_notes')
                            ->label('Internal notes')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('subject')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Sender')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('agency.name_fr')
                    ->label('Agency')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (mixed $state): string => self::contactStatusLabel($state))
                    ->color(fn (mixed $state): string => self::contactStatusColor($state))
                    ->sortable(),
                TextColumn::make('assignedUser.name')
                    ->label('Assigned')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime('M j, Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options(self::contactStatusOptions()),
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
        $query = parent::getEloquentQuery()
            ->with(['agency', 'assignedUser']);

        $user = self::currentUser();

        if ($user instanceof User && $user->hasRole('agency_admin')) {
            return filled($user->assigned_agency_id)
                ? $query->where('agency_id', $user->assigned_agency_id)
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
            'index' => Pages\ListContactMessages::route('/'),
            'create' => Pages\CreateContactMessage::route('/create'),
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function contactStatusOptions(): array
    {
        return collect(ContactStatus::cases())
            ->mapWithKeys(fn (ContactStatus $status): array => [$status->value => self::contactStatusLabel($status)])
            ->all();
    }

    public static function contactStatusLabel(mixed $status): string
    {
        return match (self::contactStatusValue($status)) {
            ContactStatus::New->value => 'New',
            ContactStatus::InReview->value => 'In review',
            ContactStatus::Responded->value => 'Responded',
            ContactStatus::Closed->value => 'Closed',
            ContactStatus::Spam->value => 'Spam',
            default => 'Unknown',
        };
    }

    public static function contactStatusColor(mixed $status): string
    {
        return match (self::contactStatusValue($status)) {
            ContactStatus::New->value => 'warning',
            ContactStatus::InReview->value => 'info',
            ContactStatus::Responded->value => 'success',
            ContactStatus::Closed->value => 'gray',
            ContactStatus::Spam->value => 'danger',
            default => 'gray',
        };
    }

    /**
     * @return array<int, string>
     */
    public static function agencyOptions(): array
    {
        $query = Agency::query()->ordered();
        $user = self::currentUser();

        if ($user instanceof User && $user->hasRole('agency_admin')) {
            $query->whereKey($user->assigned_agency_id);
        }

        return $query->pluck('name_fr', 'id')->all();
    }

    public static function currentUser(): ?User
    {
        $user = Filament::auth()->user();

        return $user instanceof User ? $user : null;
    }

    public static function currentAgencyAdmin(): ?User
    {
        $user = self::currentUser();

        return $user instanceof User && $user->hasRole('agency_admin') ? $user : null;
    }

    public static function isAgencyAdmin(): bool
    {
        return self::currentAgencyAdmin() instanceof User;
    }

    private static function contactStatusValue(mixed $status): ?string
    {
        return $status instanceof ContactStatus ? $status->value : $status;
    }
}
