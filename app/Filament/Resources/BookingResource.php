<?php

namespace App\Filament\Resources;

use App\Enums\BookingStatus;
use App\Filament\AdminNavigation;
use App\Filament\Resources\BookingResource\Pages;
use App\Models\Agency;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
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

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $slug = 'bookings';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static string|\UnitEnum|null $navigationGroup = AdminNavigation::GROUP_OPERATIONS;

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'reference';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Customer')
                    ->columns(2)
                    ->schema([
                        TextInput::make('reference')
                            ->disabled()
                            ->dehydrated(false)
                            ->helperText('Generated automatically when a booking is created.'),
                        TextInput::make('customer_name')
                            ->label('Customer name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                    ]),
                Section::make('Agency and service')
                    ->columns(2)
                    ->schema([
                        Select::make('agency_id')
                            ->label('Agency')
                            ->options(fn (): array => self::agencyOptions())
                            ->default(fn (): ?int => self::currentAgencyAdmin()?->assigned_agency_id)
                            ->disabled(fn (): bool => self::isAgencyAdmin())
                            ->dehydrated()
                            ->searchable()
                            ->required(),
                        Select::make('service_id')
                            ->label('Service')
                            ->options(fn (): array => Service::query()
                                ->ordered()
                                ->pluck('title_fr', 'id')
                                ->all())
                            ->searchable()
                            ->required(),
                    ]),
                Section::make('Vehicle')
                    ->columns(2)
                    ->schema([
                        TextInput::make('vehicle_registration')
                            ->label('Registration')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('vehicle_type')
                            ->label('Vehicle type')
                            ->maxLength(255),
                        TextInput::make('vehicle_category')
                            ->label('Vehicle category')
                            ->maxLength(255),
                        TextInput::make('vehicle_brand_model')
                            ->label('Brand / model')
                            ->maxLength(255),
                    ]),
                Section::make('Schedule and status')
                    ->columns(2)
                    ->schema([
                        DatePicker::make('preferred_date')
                            ->label('Preferred date')
                            ->required(),
                        TextInput::make('preferred_time_slot')
                            ->label('Preferred time slot')
                            ->required()
                            ->maxLength(255),
                        DatePicker::make('confirmed_date')
                            ->label('Confirmed date'),
                        TextInput::make('confirmed_time_slot')
                            ->label('Confirmed time slot')
                            ->maxLength(255),
                        Select::make('status')
                            ->options(self::bookingStatusOptions())
                            ->default(BookingStatus::NewRequest->value)
                            ->required(),
                    ]),
                Section::make('Messages')
                    ->columns(2)
                    ->schema([
                        Textarea::make('customer_message')
                            ->label('Customer message')
                            ->rows(4),
                        Textarea::make('public_message')
                            ->label('Public tracking message')
                            ->rows(4),
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
                TextColumn::make('reference')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer_name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('agency.name_fr')
                    ->label('Agency')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('service.title_fr')
                    ->label('Service')
                    ->toggleable(),
                TextColumn::make('preferred_date')
                    ->label('Preferred')
                    ->date('M j, Y')
                    ->sortable(),
                TextColumn::make('confirmed_date')
                    ->label('Confirmed')
                    ->date('M j, Y')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (mixed $state): string => self::bookingStatusLabel($state))
                    ->color(fn (mixed $state): string => self::bookingStatusColor($state))
                    ->sortable(),
                TextColumn::make('documentReadiness.status')
                    ->label('Documents')
                    ->badge()
                    ->formatStateUsing(fn (mixed $state): string => DocumentReadinessResource::documentReadinessStatusLabel($state))
                    ->color(fn (mixed $state): string => DocumentReadinessResource::documentReadinessStatusColor($state))
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options(self::bookingStatusOptions()),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->with(['agency', 'service', 'documentReadiness']);

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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function bookingStatusOptions(): array
    {
        return collect(BookingStatus::cases())
            ->mapWithKeys(fn (BookingStatus $status): array => [$status->value => self::bookingStatusLabel($status)])
            ->all();
    }

    public static function bookingStatusLabel(mixed $status): string
    {
        return match (self::bookingStatusValue($status)) {
            BookingStatus::NewRequest->value => 'New request',
            BookingStatus::PendingConfirmation->value => 'Pending confirmation',
            BookingStatus::Confirmed->value => 'Confirmed',
            BookingStatus::Rescheduled->value => 'Rescheduled',
            BookingStatus::Cancelled->value => 'Cancelled',
            BookingStatus::Completed->value => 'Completed',
            BookingStatus::NoShow->value => 'No-show',
            default => 'Unknown',
        };
    }

    public static function bookingStatusColor(mixed $status): string
    {
        return match (self::bookingStatusValue($status)) {
            BookingStatus::NewRequest->value => 'warning',
            BookingStatus::PendingConfirmation->value => 'info',
            BookingStatus::Confirmed->value => 'success',
            BookingStatus::Rescheduled->value => 'gray',
            BookingStatus::Cancelled->value => 'danger',
            BookingStatus::Completed->value => 'success',
            BookingStatus::NoShow->value => 'danger',
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

    private static function bookingStatusValue(mixed $status): ?string
    {
        return $status instanceof BookingStatus ? $status->value : $status;
    }
}
