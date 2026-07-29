<?php

namespace App\Filament\Resources;

use App\Enums\DocumentReadinessStatus;
use App\Filament\AdminNavigation;
use App\Filament\Resources\DocumentReadinessResource\Pages;
use App\Filament\Support\DashboardMetrics;
use App\Models\Agency;
use App\Models\Booking;
use App\Models\DocumentReadiness;
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

class DocumentReadinessResource extends Resource
{
    protected static ?string $model = DocumentReadiness::class;

    protected static ?string $slug = 'document-readiness';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static string|\UnitEnum|null $navigationGroup = AdminNavigation::GROUP_OPERATIONS;

    protected static ?int $navigationSort = 20;

    protected static ?string $recordTitleAttribute = 'booking.reference';

    public static function getNavigationLabel(): string
    {
        return (string) __('admin_document_readiness.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return (string) __('admin_document_readiness.model.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return (string) __('admin_document_readiness.model.plural');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin_document_readiness.form.sections.booking.heading'))
                    ->description(__('admin_document_readiness.form.sections.booking.description'))
                    ->icon('heroicon-o-calendar-days')
                    ->compact()
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        Select::make('booking_id')
                            ->label(__('admin_document_readiness.form.fields.booking_id.label'))
                            ->options(fn (?DocumentReadiness $record = null): array => self::bookingOptions($record?->booking_id))
                            ->prefixIcon('heroicon-o-hashtag')
                            ->searchable()
                            ->required()
                            ->disabled()
                            ->dehydrated(false)
                            ->native(false)
                            ->helperText(__('admin_document_readiness.form.fields.booking_id.helper')),
                        TextInput::make('updatedBy.name')
                            ->label(__('admin_document_readiness.form.fields.updated_by.label'))
                            ->prefixIcon('heroicon-o-user-circle')
                            ->disabled()
                            ->dehydrated(false)
                            ->visibleOn('edit'),
                    ]),
                Section::make(__('admin_document_readiness.form.sections.status.heading'))
                    ->description(__('admin_document_readiness.form.sections.status.description'))
                    ->icon('heroicon-o-clipboard-document-check')
                    ->compact()
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        Select::make('status')
                            ->label(__('admin_document_readiness.form.fields.status.label'))
                            ->options(self::documentReadinessStatusOptions())
                            ->default(DocumentReadinessStatus::NotReviewed->value)
                            ->native(false)
                            ->required(),
                        Textarea::make('missing_information_note')
                            ->label(__('admin_document_readiness.form.fields.missing_information_note.label'))
                            ->placeholder(__('admin_document_readiness.form.fields.missing_information_note.placeholder'))
                            ->rows(4),
                    ]),
                Section::make(__('admin_document_readiness.form.sections.public_actions.heading'))
                    ->description(__('admin_document_readiness.form.sections.public_actions.description'))
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->compact()
                    ->columns([
                        'default' => 1,
                        'lg' => 2,
                    ])
                    ->schema([
                        Textarea::make('next_action_fr')
                            ->label(__('admin_document_readiness.form.fields.next_action_fr.label'))
                            ->placeholder(__('admin_document_readiness.form.fields.next_action_fr.placeholder'))
                            ->rows(4),
                        Textarea::make('next_action_en')
                            ->label(__('admin_document_readiness.form.fields.next_action_en.label'))
                            ->placeholder(__('admin_document_readiness.form.fields.next_action_en.placeholder'))
                            ->rows(4),
                        Textarea::make('public_message_fr')
                            ->label(__('admin_document_readiness.form.fields.public_message_fr.label'))
                            ->placeholder(__('admin_document_readiness.form.fields.public_message_fr.placeholder'))
                            ->rows(4),
                        Textarea::make('public_message_en')
                            ->label(__('admin_document_readiness.form.fields.public_message_en.label'))
                            ->placeholder(__('admin_document_readiness.form.fields.public_message_en.placeholder'))
                            ->rows(4),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading(__('admin_document_readiness.table.heading'))
            ->description(__('admin_document_readiness.table.description'))
            ->columns([
                TextColumn::make('booking.reference')
                    ->label(__('admin_document_readiness.table.columns.reference'))
                    ->icon('heroicon-o-hashtag')
                    ->weight(FontWeight::Bold)
                    ->copyable()
                    ->copyMessage(__('admin_document_readiness.table.copy_reference'))
                    ->description(fn (DocumentReadiness $record): string => self::bookingSummary($record))
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('booking.phone')
                    ->label(__('admin_document_readiness.table.columns.contact'))
                    ->icon('heroicon-o-phone')
                    ->description(fn (DocumentReadiness $record): string => self::contactSummary($record))
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('booking.agency.name_fr')
                    ->label(__('admin_document_readiness.table.columns.agency'))
                    ->formatStateUsing(fn (DocumentReadiness $record): string => self::localizedAgencyName($record->booking?->agency))
                    ->description(fn (DocumentReadiness $record): string => BookingResource::localizedServiceTitle($record->booking?->service) ?? (string) __('admin_document_readiness.table.descriptions.not_set'))
                    ->searchable()
                    ->sortable()
                    ->visibleFrom('md'),
                TextColumn::make('booking.status')
                    ->label(__('admin_document_readiness.table.columns.booking_status'))
                    ->badge()
                    ->formatStateUsing(fn (mixed $state): string => BookingResource::bookingStatusLabel($state))
                    ->color(fn (mixed $state): string => BookingResource::bookingStatusColor($state))
                    ->icon(fn (mixed $state): string => BookingResource::bookingStatusIcon($state))
                    ->sortable()
                    ->toggleable()
                    ->visibleFrom('lg'),
                TextColumn::make('status')
                    ->label(__('admin_document_readiness.table.columns.readiness'))
                    ->badge()
                    ->formatStateUsing(fn (mixed $state): string => self::documentReadinessStatusLabel($state))
                    ->color(fn (mixed $state): string => self::documentReadinessStatusColor($state))
                    ->icon(fn (mixed $state): string => self::documentReadinessStatusIcon($state))
                    ->sortable(),
                TextColumn::make('missing_information_note')
                    ->label(__('admin_document_readiness.table.columns.note'))
                    ->description(fn (DocumentReadiness $record): string => self::localizedNextAction($record) ?? (string) __('admin_document_readiness.table.descriptions.no_next_action'))
                    ->placeholder(__('admin_document_readiness.table.descriptions.no_missing_info'))
                    ->limit(46)
                    ->toggleable()
                    ->visibleFrom('sm'),
                TextColumn::make('updated_at')
                    ->label(__('admin_document_readiness.table.columns.updated'))
                    ->description(fn (DocumentReadiness $record): string => $record->updatedBy?->name ?: (string) __('admin_document_readiness.table.descriptions.not_updated_by'))
                    ->dateTime('M j, Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->stackedOnMobile()
            ->striped()
            ->defaultPaginationPageOption(25)
            ->paginated([10, 25, 50])
            ->recordUrl(fn (DocumentReadiness $record): string => static::getUrl('edit', ['record' => $record]))
            ->emptyStateIcon('heroicon-o-clipboard-document-check')
            ->emptyStateHeading(__('admin_document_readiness.table.empty_heading'))
            ->emptyStateDescription(__('admin_document_readiness.table.empty_description'))
            ->filters([
                SelectFilter::make('status')
                    ->label(__('admin_document_readiness.table.filters.status'))
                    ->options(self::documentReadinessStatusOptions())
                    ->multiple()
                    ->native(false),
                SelectFilter::make('agency_id')
                    ->label(__('admin_document_readiness.table.filters.agency'))
                    ->options(fn (): array => self::agencyOptions())
                    ->searchable()
                    ->native(false)
                    ->hidden(fn (): bool => self::isAgencyAdmin())
                    ->query(fn (Builder $query, array $data): Builder => filled($data['value'] ?? null)
                        ? $query->whereHas(
                            'booking',
                            fn (Builder $bookingQuery): Builder => $bookingQuery->where('agency_id', $data['value']),
                        )
                        : $query),
                SelectFilter::make('booking_status')
                    ->label(__('admin_document_readiness.table.filters.booking_status'))
                    ->options(BookingResource::bookingStatusOptions())
                    ->native(false)
                    ->query(fn (Builder $query, array $data): Builder => filled($data['value'] ?? null)
                        ? $query->whereHas(
                            'booking',
                            fn (Builder $bookingQuery): Builder => $bookingQuery->where('status', $data['value']),
                        )
                        : $query),
                Filter::make('updated_window')
                    ->label(__('admin_document_readiness.table.filters.updated_window'))
                    ->schema([
                        DatePicker::make('from')
                            ->label(__('admin_document_readiness.table.filters.from'))
                            ->native(false),
                        DatePicker::make('until')
                            ->label(__('admin_document_readiness.table.filters.until'))
                            ->native(false),
                    ])
                    ->columns(2)
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when(
                            $data['from'] ?? null,
                            fn (Builder $query, string $date): Builder => $query->whereDate('updated_at', '>=', $date),
                        )
                        ->when(
                            $data['until'] ?? null,
                            fn (Builder $query, string $date): Builder => $query->whereDate('updated_at', '<=', $date),
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
                    ->label(__('admin_document_readiness.actions.edit'))
                    ->icon('heroicon-o-pencil-square'),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->with(['booking.agency', 'booking.service', 'updatedBy']);

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
        $value = self::documentReadinessStatusValue($status);
        $key = "admin_document_readiness.statuses.document.{$value}";

        return filled($value) && trans()->has($key)
            ? (string) __($key)
            : (string) __('admin_document_readiness.statuses.unknown');
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
    public static function bookingOptions(?int $currentBookingId = null): array
    {
        $query = Booking::query()
            ->with(['agency', 'service'])
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
                $booking->id => "{$booking->reference} - {$booking->customer_name} (".self::localizedAgencyName($booking->agency).')',
            ])
            ->all();
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

    public static function localizedAgencyName(?Agency $agency): string
    {
        return DashboardMetrics::localizedAgencyName($agency)
            ?? (string) __('admin_document_readiness.table.descriptions.not_set');
    }

    public static function bookingSummary(DocumentReadiness $documentReadiness): string
    {
        $booking = $documentReadiness->booking;

        return collect([
            $booking?->customer_name,
            $booking?->vehicle_registration,
        ])->filter()->join(' - ') ?: (string) __('admin_document_readiness.table.descriptions.not_set');
    }

    public static function contactSummary(DocumentReadiness $documentReadiness): string
    {
        $booking = $documentReadiness->booking;

        return collect([
            filled($booking?->whatsapp) ? __('admin_document_readiness.table.descriptions.whatsapp', ['phone' => $booking?->whatsapp]) : null,
            $booking?->email,
        ])->filter()->join(' - ') ?: (string) __('admin_document_readiness.table.descriptions.missing_contact');
    }

    public static function localizedNextAction(DocumentReadiness $documentReadiness): ?string
    {
        $locale = app()->getLocale() === 'en' ? 'en' : 'fr';
        $nextAction = $documentReadiness->getAttribute("next_action_{$locale}")
            ?: $documentReadiness->next_action_fr
            ?: $documentReadiness->next_action_en;

        return filled($nextAction) ? (string) $nextAction : null;
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

    private static function documentReadinessStatusValue(mixed $status): ?string
    {
        return $status instanceof DocumentReadinessStatus ? $status->value : $status;
    }
}
