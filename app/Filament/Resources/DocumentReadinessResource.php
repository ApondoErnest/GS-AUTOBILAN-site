<?php

namespace App\Filament\Resources;

use App\Enums\DocumentReadinessStatus;
use App\Filament\AdminNavigation;
use App\Filament\Resources\DocumentReadinessResource\Pages;
use App\Models\Booking;
use App\Models\DocumentReadiness;
use App\Models\User;
use BackedEnum;
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

class DocumentReadinessResource extends Resource
{
    protected static ?string $model = DocumentReadiness::class;

    protected static ?string $slug = 'document-readiness';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static string|\UnitEnum|null $navigationGroup = AdminNavigation::GROUP_OPERATIONS;

    protected static ?int $navigationSort = 20;

    protected static ?string $recordTitleAttribute = 'booking.reference';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Booking')
                    ->columns(2)
                    ->schema([
                        Select::make('booking_id')
                            ->label('Booking')
                            ->options(fn (?DocumentReadiness $record = null): array => self::bookingOptions($record?->booking_id))
                            ->searchable()
                            ->required()
                            ->disabledOn('edit')
                            ->dehydrated(fn (string $operation): bool => $operation === 'create'),
                        TextInput::make('updatedBy.name')
                            ->label('Updated by')
                            ->disabled()
                            ->dehydrated(false)
                            ->visibleOn('edit'),
                    ]),
                Section::make('Document status')
                    ->columns(2)
                    ->schema([
                        Select::make('status')
                            ->options(self::documentReadinessStatusOptions())
                            ->default(DocumentReadinessStatus::NotReviewed->value)
                            ->required(),
                        Textarea::make('missing_information_note')
                            ->label('Missing information')
                            ->rows(4),
                    ]),
                Section::make('Public next action')
                    ->columns(2)
                    ->schema([
                        Textarea::make('next_action_fr')
                            ->label('Next action FR')
                            ->rows(4),
                        Textarea::make('next_action_en')
                            ->label('Next action EN')
                            ->rows(4),
                        Textarea::make('public_message_fr')
                            ->label('Public message FR')
                            ->rows(4),
                        Textarea::make('public_message_en')
                            ->label('Public message EN')
                            ->rows(4),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking.reference')
                    ->label('Reference')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('booking.customer_name')
                    ->label('Customer')
                    ->searchable(),
                TextColumn::make('booking.agency.name_fr')
                    ->label('Agency')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (mixed $state): string => self::documentReadinessStatusLabel($state))
                    ->color(fn (mixed $state): string => self::documentReadinessStatusColor($state))
                    ->sortable(),
                TextColumn::make('missing_information_note')
                    ->label('Missing info')
                    ->limit(40)
                    ->toggleable(),
                TextColumn::make('updatedBy.name')
                    ->label('Updated by')
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('M j, Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options(self::documentReadinessStatusOptions()),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->with(['booking.agency', 'updatedBy']);

        $user = self::currentUser();

        if ($user instanceof User && $user->hasRole('agency_admin')) {
            return filled($user->assigned_agency_id)
                ? $query->whereHas('booking', fn (Builder $query): Builder => $query->where('agency_id', $user->assigned_agency_id))
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
            'index' => Pages\ListDocumentReadiness::route('/'),
            'create' => Pages\CreateDocumentReadiness::route('/create'),
            'edit' => Pages\EditDocumentReadiness::route('/{record}/edit'),
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function documentReadinessStatusOptions(): array
    {
        return collect(DocumentReadinessStatus::cases())
            ->mapWithKeys(fn (DocumentReadinessStatus $status): array => [$status->value => self::documentReadinessStatusLabel($status)])
            ->all();
    }

    public static function documentReadinessStatusLabel(mixed $status): string
    {
        return match (self::documentReadinessStatusValue($status)) {
            DocumentReadinessStatus::NotReviewed->value => 'Not reviewed',
            DocumentReadinessStatus::Complete->value => 'Complete',
            DocumentReadinessStatus::MissingInfo->value => 'Missing information',
            DocumentReadinessStatus::ContactAgency->value => 'Contact agency',
            DocumentReadinessStatus::ReadyForVisit->value => 'Ready for visit',
            default => 'Unknown',
        };
    }

    public static function documentReadinessStatusColor(mixed $status): string
    {
        return match (self::documentReadinessStatusValue($status)) {
            DocumentReadinessStatus::NotReviewed->value => 'gray',
            DocumentReadinessStatus::Complete->value => 'success',
            DocumentReadinessStatus::MissingInfo->value => 'warning',
            DocumentReadinessStatus::ContactAgency->value => 'info',
            DocumentReadinessStatus::ReadyForVisit->value => 'success',
            default => 'gray',
        };
    }

    /**
     * @return array<int, string>
     */
    public static function bookingOptions(?int $currentBookingId = null): array
    {
        $query = Booking::query()
            ->with('agency')
            ->orderByDesc('created_at');

        if (blank($currentBookingId)) {
            $query->doesntHave('documentReadiness');
        }

        $user = self::currentUser();

        if ($user instanceof User && $user->hasRole('agency_admin')) {
            $query->where('agency_id', $user->assigned_agency_id);
        }

        return $query
            ->get()
            ->mapWithKeys(fn (Booking $booking): array => [
                $booking->id => "{$booking->reference} — {$booking->customer_name} ({$booking->agency?->name_fr})",
            ])
            ->all();
    }

    public static function currentUser(): ?User
    {
        $user = Filament::auth()->user();

        return $user instanceof User ? $user : null;
    }

    private static function documentReadinessStatusValue(mixed $status): ?string
    {
        return $status instanceof DocumentReadinessStatus ? $status->value : $status;
    }
}
