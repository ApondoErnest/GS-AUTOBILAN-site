<?php

namespace App\Filament\Resources;

use App\Enums\BookingStatus;
use App\Enums\DocumentReadinessStatus;
use App\Filament\AdminNavigation;
use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Support\DashboardMetrics;
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
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
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

    public static function getNavigationLabel(): string
    {
        return (string) __('admin_bookings.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return (string) __('admin_bookings.model.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return (string) __('admin_bookings.model.plural');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin_bookings.form.sections.customer.heading'))
                    ->description(__('admin_bookings.form.sections.customer.description'))
                    ->icon('heroicon-o-user-circle')
                    ->compact()
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        TextInput::make('reference')
                            ->label(__('admin_bookings.form.fields.reference.label'))
                            ->prefixIcon('heroicon-o-hashtag')
                            ->disabled()
                            ->dehydrated(false)
                            ->helperText(__('admin_bookings.form.fields.reference.helper')),
                        TextInput::make('customer_name')
                            ->label(__('admin_bookings.form.fields.customer_name.label'))
                            ->placeholder(__('admin_bookings.form.fields.customer_name.placeholder'))
                            ->prefixIcon('heroicon-o-user')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label(__('admin_bookings.form.fields.phone.label'))
                            ->placeholder(__('admin_bookings.form.fields.phone.placeholder'))
                            ->prefixIcon('heroicon-o-phone')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('whatsapp')
                            ->label(__('admin_bookings.form.fields.whatsapp.label'))
                            ->placeholder(__('admin_bookings.form.fields.whatsapp.placeholder'))
                            ->prefixIcon('heroicon-o-chat-bubble-left-right')
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label(__('admin_bookings.form.fields.email.label'))
                            ->placeholder(__('admin_bookings.form.fields.email.placeholder'))
                            ->prefixIcon('heroicon-o-envelope')
                            ->email()
                            ->maxLength(255),
                    ]),
                Section::make(__('admin_bookings.form.sections.agency_service.heading'))
                    ->description(__('admin_bookings.form.sections.agency_service.description'))
                    ->icon('heroicon-o-building-office-2')
                    ->compact()
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        Select::make('agency_id')
                            ->label(__('admin_bookings.form.fields.agency_id.label'))
                            ->placeholder(__('admin_bookings.form.fields.agency_id.placeholder'))
                            ->options(fn (): array => self::agencyOptions())
                            ->default(fn (): ?int => self::currentAgencyAdmin()?->assigned_agency_id)
                            ->disabled(fn (): bool => self::isAgencyAdmin())
                            ->dehydrated()
                            ->searchable()
                            ->native(false)
                            ->required(),
                        Select::make('service_id')
                            ->label(__('admin_bookings.form.fields.service_id.label'))
                            ->placeholder(__('admin_bookings.form.fields.service_id.placeholder'))
                            ->options(fn (): array => self::serviceOptions())
                            ->searchable()
                            ->native(false)
                            ->required(),
                    ]),
                Section::make(__('admin_bookings.form.sections.vehicle.heading'))
                    ->description(__('admin_bookings.form.sections.vehicle.description'))
                    ->icon('heroicon-o-truck')
                    ->compact()
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        TextInput::make('vehicle_registration')
                            ->label(__('admin_bookings.form.fields.vehicle_registration.label'))
                            ->placeholder(__('admin_bookings.form.fields.vehicle_registration.placeholder'))
                            ->prefixIcon('heroicon-o-identification')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('vehicle_type')
                            ->label(__('admin_bookings.form.fields.vehicle_type.label'))
                            ->placeholder(__('admin_bookings.form.fields.vehicle_type.placeholder'))
                            ->prefixIcon('heroicon-o-truck')
                            ->maxLength(255),
                        TextInput::make('vehicle_category')
                            ->label(__('admin_bookings.form.fields.vehicle_category.label'))
                            ->placeholder(__('admin_bookings.form.fields.vehicle_category.placeholder'))
                            ->prefixIcon('heroicon-o-squares-2x2')
                            ->maxLength(255),
                        TextInput::make('vehicle_brand_model')
                            ->label(__('admin_bookings.form.fields.vehicle_brand_model.label'))
                            ->placeholder(__('admin_bookings.form.fields.vehicle_brand_model.placeholder'))
                            ->prefixIcon('heroicon-o-wrench-screwdriver')
                            ->maxLength(255),
                    ]),
                Section::make(__('admin_bookings.form.sections.schedule.heading'))
                    ->description(__('admin_bookings.form.sections.schedule.description'))
                    ->icon('heroicon-o-clock')
                    ->compact()
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        DatePicker::make('preferred_date')
                            ->label(__('admin_bookings.form.fields.preferred_date.label'))
                            ->native(false)
                            ->required(),
                        TextInput::make('preferred_time_slot')
                            ->label(__('admin_bookings.form.fields.preferred_time_slot.label'))
                            ->placeholder(__('admin_bookings.form.fields.preferred_time_slot.placeholder'))
                            ->prefixIcon('heroicon-o-clock')
                            ->required()
                            ->maxLength(255),
                        DatePicker::make('confirmed_date')
                            ->label(__('admin_bookings.form.fields.confirmed_date.label'))
                            ->native(false),
                        TextInput::make('confirmed_time_slot')
                            ->label(__('admin_bookings.form.fields.confirmed_time_slot.label'))
                            ->placeholder(__('admin_bookings.form.fields.confirmed_time_slot.placeholder'))
                            ->prefixIcon('heroicon-o-check-circle')
                            ->maxLength(255),
                        Select::make('status')
                            ->label(__('admin_bookings.form.fields.status.label'))
                            ->options(self::bookingStatusOptions())
                            ->default(BookingStatus::NewRequest->value)
                            ->native(false)
                            ->required(),
                    ]),
                Section::make(__('admin_bookings.form.sections.messages.heading'))
                    ->description(__('admin_bookings.form.sections.messages.description'))
                    ->icon('heroicon-o-document-text')
                    ->compact()
                    ->collapsible()
                    ->columns([
                        'default' => 1,
                        'lg' => 2,
                    ])
                    ->schema([
                        Textarea::make('customer_message')
                            ->label(__('admin_bookings.form.fields.customer_message.label'))
                            ->placeholder(__('admin_bookings.form.fields.customer_message.placeholder'))
                            ->rows(4),
                        Textarea::make('public_message')
                            ->label(__('admin_bookings.form.fields.public_message.label'))
                            ->placeholder(__('admin_bookings.form.fields.public_message.placeholder'))
                            ->rows(4),
                        Textarea::make('internal_notes')
                            ->label(__('admin_bookings.form.fields.internal_notes.label'))
                            ->placeholder(__('admin_bookings.form.fields.internal_notes.placeholder'))
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading(__('admin_bookings.table.heading'))
            ->description(__('admin_bookings.table.description'))
            ->columns([
                TextColumn::make('reference')
                    ->label(__('admin_bookings.table.columns.reference'))
                    ->icon('heroicon-o-hashtag')
                    ->weight(FontWeight::Bold)
                    ->copyable()
                    ->copyMessage(__('admin_bookings.table.copy_reference'))
                    ->description(fn (Booking $record): string => self::bookingSummary($record))
                    ->searchable(['reference', 'customer_name', 'vehicle_registration'])
                    ->sortable()
                    ->wrap(),
                TextColumn::make('phone')
                    ->label(__('admin_bookings.table.columns.contact'))
                    ->icon('heroicon-o-phone')
                    ->description(fn (Booking $record): string => self::contactSummary($record))
                    ->searchable(['phone', 'whatsapp', 'email'])
                    ->toggleable(),
                TextColumn::make('agency.name_fr')
                    ->label(__('admin_bookings.table.columns.agency'))
                    ->formatStateUsing(fn (Booking $record): string => self::localizedAgencyName($record->agency))
                    ->description(fn (Booking $record): string => self::localizedServiceTitle($record->service) ?? (string) __('admin_bookings.table.descriptions.not_set'))
                    ->searchable()
                    ->sortable()
                    ->visibleFrom('md'),
                TextColumn::make('preferred_date')
                    ->label(__('admin_bookings.table.columns.visit'))
                    ->icon('heroicon-o-calendar-days')
                    ->date('M j, Y')
                    ->description(fn (Booking $record): string => $record->preferred_time_slot ?: (string) __('admin_bookings.table.descriptions.no_time_slot'))
                    ->sortable(),
                TextColumn::make('confirmed_date')
                    ->label(__('admin_bookings.table.columns.confirmed'))
                    ->icon('heroicon-o-check-circle')
                    ->date('M j, Y')
                    ->description(fn (Booking $record): string => $record->confirmed_time_slot ?: (string) __('admin_bookings.table.descriptions.not_confirmed'))
                    ->sortable()
                    ->toggleable()
                    ->visibleFrom('lg'),
                TextColumn::make('status')
                    ->label(__('admin_bookings.table.columns.status'))
                    ->badge()
                    ->formatStateUsing(fn (mixed $state): string => self::bookingStatusLabel($state))
                    ->color(fn (mixed $state): string => self::bookingStatusColor($state))
                    ->icon(fn (mixed $state): string => self::bookingStatusIcon($state))
                    ->sortable(),
                TextColumn::make('documentReadiness.status')
                    ->label(__('admin_bookings.table.columns.documents'))
                    ->badge()
                    ->formatStateUsing(fn (mixed $state): string => self::documentReadinessStatusLabel($state))
                    ->color(fn (mixed $state): string => self::documentReadinessStatusColor($state))
                    ->icon(fn (mixed $state): string => self::documentReadinessStatusIcon($state))
                    ->placeholder(__('admin_bookings.table.descriptions.not_started'))
                    ->toggleable()
                    ->visibleFrom('sm'),
                TextColumn::make('created_at')
                    ->label(__('admin_bookings.table.columns.created'))
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->visibleFrom('xl'),
            ])
            ->defaultSort('created_at', 'desc')
            ->stackedOnMobile()
            ->striped()
            ->defaultPaginationPageOption(25)
            ->paginated([10, 25, 50])
            ->recordUrl(fn (Booking $record): string => static::getUrl('edit', ['record' => $record]))
            ->emptyStateIcon('heroicon-o-calendar-days')
            ->emptyStateHeading(__('admin_bookings.table.empty_heading'))
            ->emptyStateDescription(__('admin_bookings.table.empty_description'))
            ->filters([
                SelectFilter::make('status')
                    ->label(__('admin_bookings.table.filters.status'))
                    ->options(self::bookingStatusOptions())
                    ->multiple()
                    ->native(false),
                SelectFilter::make('agency_id')
                    ->label(__('admin_bookings.table.filters.agency'))
                    ->options(fn (): array => self::agencyOptions())
                    ->searchable()
                    ->native(false)
                    ->hidden(fn (): bool => self::isAgencyAdmin()),
                SelectFilter::make('document_status')
                    ->label(__('admin_bookings.table.filters.document_status'))
                    ->options(self::documentReadinessStatusOptions())
                    ->native(false)
                    ->query(fn (Builder $query, array $data): Builder => filled($data['value'] ?? null)
                        ? $query->whereHas(
                            'documentReadiness',
                            fn (Builder $documentQuery): Builder => $documentQuery->where('status', $data['value']),
                        )
                        : $query),
                Filter::make('visit_window')
                    ->label(__('admin_bookings.table.filters.visit_window'))
                    ->schema([
                        DatePicker::make('from')
                            ->label(__('admin_bookings.table.filters.from'))
                            ->native(false),
                        DatePicker::make('until')
                            ->label(__('admin_bookings.table.filters.until'))
                            ->native(false),
                    ])
                    ->columns(2)
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when(
                            $data['from'] ?? null,
                            fn (Builder $query, string $date): Builder => $query->whereDate('preferred_date', '>=', $date),
                        )
                        ->when(
                            $data['until'] ?? null,
                            fn (Builder $query, string $date): Builder => $query->whereDate('preferred_date', '<=', $date),
                        )),
            ])
            ->filtersFormColumns([
                'default' => 1,
                'md' => 2,
                'xl' => 4,
            ])
            ->persistFiltersInSession()
            ->recordActions([
                EditAction::make()
                    ->label(__('admin_bookings.actions.edit'))
                    ->icon('heroicon-o-pencil-square'),
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
        $value = self::bookingStatusValue($status);
        $key = "admin_bookings.statuses.booking.{$value}";

        return filled($value) && trans()->has($key)
            ? (string) __($key)
            : (string) __('admin_bookings.statuses.unknown');
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

    public static function bookingStatusIcon(mixed $status): string
    {
        return match (self::bookingStatusValue($status)) {
            BookingStatus::NewRequest->value => 'heroicon-o-sparkles',
            BookingStatus::PendingConfirmation->value => 'heroicon-o-clock',
            BookingStatus::Confirmed->value => 'heroicon-o-check-circle',
            BookingStatus::Rescheduled->value => 'heroicon-o-arrow-path',
            BookingStatus::Cancelled->value => 'heroicon-o-x-circle',
            BookingStatus::Completed->value => 'heroicon-o-flag',
            BookingStatus::NoShow->value => 'heroicon-o-exclamation-triangle',
            default => 'heroicon-o-question-mark-circle',
        };
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
        $value = self::documentReadinessStatusValue($status);
        $key = "admin_bookings.statuses.document.{$value}";

        return filled($value) && trans()->has($key)
            ? (string) __($key)
            : (string) __('admin_bookings.statuses.unknown');
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

    public static function documentReadinessStatusIcon(mixed $status): string
    {
        return match (self::documentReadinessStatusValue($status)) {
            DocumentReadinessStatus::Complete->value,
            DocumentReadinessStatus::ReadyForVisit->value => 'heroicon-o-clipboard-document-check',
            DocumentReadinessStatus::MissingInfo->value => 'heroicon-o-exclamation-triangle',
            DocumentReadinessStatus::ContactAgency->value => 'heroicon-o-phone-arrow-up-right',
            DocumentReadinessStatus::NotReviewed->value => 'heroicon-o-clipboard-document-list',
            default => 'heroicon-o-question-mark-circle',
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

        return $query
            ->get()
            ->mapWithKeys(fn (Agency $agency): array => [
                $agency->id => self::localizedAgencyName($agency),
            ])
            ->all();
    }

    /**
     * @return array<int, string>
     */
    public static function serviceOptions(): array
    {
        return Service::query()
            ->ordered()
            ->get()
            ->mapWithKeys(fn (Service $service): array => [
                $service->id => self::localizedServiceTitle($service) ?? (string) __('admin_bookings.table.descriptions.not_set'),
            ])
            ->all();
    }

    public static function localizedAgencyName(?Agency $agency): string
    {
        return DashboardMetrics::localizedAgencyName($agency)
            ?? (string) __('admin_bookings.table.descriptions.not_set');
    }

    public static function localizedServiceTitle(?Service $service): ?string
    {
        if (! $service) {
            return null;
        }

        $locale = app()->getLocale() === 'en' ? 'en' : 'fr';
        $localizedTitle = $service->getAttribute("title_{$locale}")
            ?: $service->title_fr
            ?: $service->title_en;

        return filled($localizedTitle) ? (string) $localizedTitle : null;
    }

    public static function bookingSummary(Booking $booking): string
    {
        return collect([
            $booking->customer_name,
            $booking->vehicle_registration,
        ])->filter()->join(' - ') ?: (string) __('admin_bookings.table.descriptions.not_set');
    }

    public static function contactSummary(Booking $booking): string
    {
        return collect([
            filled($booking->whatsapp) ? __('admin_bookings.table.descriptions.whatsapp', ['phone' => $booking->whatsapp]) : null,
            $booking->email,
        ])->filter()->join(' - ') ?: (string) __('admin_bookings.table.descriptions.missing_contact');
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

    private static function documentReadinessStatusValue(mixed $status): ?string
    {
        return $status instanceof DocumentReadinessStatus ? $status->value : $status;
    }
}
