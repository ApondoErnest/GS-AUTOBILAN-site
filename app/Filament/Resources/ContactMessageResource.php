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

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $slug = 'contact-messages';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-inbox';

    protected static string|\UnitEnum|null $navigationGroup = AdminNavigation::GROUP_COMMUNICATION;

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'subject';

    public static function getNavigationLabel(): string
    {
        return (string) __('admin_contact_messages.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return (string) __('admin_contact_messages.model.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return (string) __('admin_contact_messages.model.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin_contact_messages.form.sections.sender.heading'))
                    ->description(__('admin_contact_messages.form.sections.sender.description'))
                    ->icon('heroicon-o-user-circle')
                    ->compact()
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        TextInput::make('name')
                            ->label(__('admin_contact_messages.form.fields.name.label'))
                            ->placeholder(__('admin_contact_messages.form.fields.name.placeholder'))
                            ->prefixIcon('heroicon-o-user')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label(__('admin_contact_messages.form.fields.phone.label'))
                            ->placeholder(__('admin_contact_messages.form.fields.phone.placeholder'))
                            ->prefixIcon('heroicon-o-phone')
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label(__('admin_contact_messages.form.fields.email.label'))
                            ->placeholder(__('admin_contact_messages.form.fields.email.placeholder'))
                            ->prefixIcon('heroicon-o-envelope')
                            ->email()
                            ->maxLength(255),
                        Select::make('agency_id')
                            ->label(__('admin_contact_messages.form.fields.agency_id.label'))
                            ->options(fn (): array => self::agencyOptions())
                            ->default(fn (): ?int => self::currentAgencyAdmin()?->assigned_agency_id)
                            ->disabled(fn (): bool => self::isAgencyAdmin())
                            ->dehydrated()
                            ->searchable()
                            ->native(false),
                    ]),
                Section::make(__('admin_contact_messages.form.sections.message.heading'))
                    ->description(__('admin_contact_messages.form.sections.message.description'))
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->compact()
                    ->schema([
                        TextInput::make('subject')
                            ->label(__('admin_contact_messages.form.fields.subject.label'))
                            ->placeholder(__('admin_contact_messages.form.fields.subject.placeholder'))
                            ->prefixIcon('heroicon-o-chat-bubble-left-right')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('message')
                            ->label(__('admin_contact_messages.form.fields.message.label'))
                            ->placeholder(__('admin_contact_messages.form.fields.message.placeholder'))
                            ->required()
                            ->rows(5),
                    ]),
                Section::make(__('admin_contact_messages.form.sections.handling.heading'))
                    ->description(__('admin_contact_messages.form.sections.handling.description'))
                    ->icon('heroicon-o-clipboard-document-list')
                    ->compact()
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        Select::make('status')
                            ->label(__('admin_contact_messages.form.fields.status.label'))
                            ->options(self::contactStatusOptions())
                            ->default(ContactStatus::New->value)
                            ->required()
                            ->native(false),
                        Select::make('assigned_user_id')
                            ->label(__('admin_contact_messages.form.fields.assigned_user_id.label'))
                            ->options(fn (): array => self::assignedUserOptions())
                            ->searchable()
                            ->native(false),
                        Textarea::make('internal_notes')
                            ->label(__('admin_contact_messages.form.fields.internal_notes.label'))
                            ->placeholder(__('admin_contact_messages.form.fields.internal_notes.placeholder'))
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading(__('admin_contact_messages.table.heading'))
            ->description(__('admin_contact_messages.table.description'))
            ->columns([
                TextColumn::make('subject')
                    ->label(__('admin_contact_messages.table.columns.subject'))
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->weight(FontWeight::Bold)
                    ->formatStateUsing(fn (?string $state): string => filled($state) ? (string) $state : (string) __('admin_contact_messages.empty_subject'))
                    ->description(fn (ContactMessage $record): string => self::messagePreview($record))
                    ->searchable(['subject', 'message'])
                    ->sortable()
                    ->wrap(),
                TextColumn::make('name')
                    ->label(__('admin_contact_messages.table.columns.sender'))
                    ->icon('heroicon-o-user')
                    ->description(fn (ContactMessage $record): string => self::senderContactLine($record))
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('agency.name_fr')
                    ->label(__('admin_contact_messages.table.columns.agency'))
                    ->icon('heroicon-o-building-office-2')
                    ->formatStateUsing(fn (ContactMessage $record): string => self::agencyLabel($record->agency))
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->visibleFrom('md'),
                TextColumn::make('status')
                    ->label(__('admin_contact_messages.table.columns.status'))
                    ->badge()
                    ->formatStateUsing(fn (mixed $state): string => self::contactStatusLabel($state))
                    ->color(fn (mixed $state): string => self::contactStatusColor($state))
                    ->icon(fn (mixed $state): string => self::contactStatusIcon($state))
                    ->sortable(),
                TextColumn::make('assignedUser.name')
                    ->label(__('admin_contact_messages.table.columns.assigned'))
                    ->icon('heroicon-o-user-circle')
                    ->placeholder(__('admin_contact_messages.table.descriptions.unassigned'))
                    ->toggleable()
                    ->visibleFrom('lg'),
                TextColumn::make('created_at')
                    ->label(__('admin_contact_messages.table.columns.received'))
                    ->icon('heroicon-o-clock')
                    ->dateTime('M j, Y H:i')
                    ->sortable()
                    ->toggleable()
                    ->visibleFrom('lg'),
            ])
            ->defaultSort('created_at', 'desc')
            ->stackedOnMobile()
            ->striped()
            ->defaultPaginationPageOption(25)
            ->paginated([10, 25, 50])
            ->recordUrl(fn (ContactMessage $record): string => static::getUrl('edit', ['record' => $record]))
            ->emptyStateIcon('heroicon-o-inbox')
            ->emptyStateHeading(__('admin_contact_messages.table.empty_heading'))
            ->emptyStateDescription(__('admin_contact_messages.table.empty_description'))
            ->filters([
                SelectFilter::make('status')
                    ->label(__('admin_contact_messages.table.filters.status'))
                    ->options(self::contactStatusOptions())
                    ->native(false),
                SelectFilter::make('agency_id')
                    ->label(__('admin_contact_messages.table.filters.agency'))
                    ->options(fn (): array => self::agencyOptions())
                    ->searchable()
                    ->native(false),
                Filter::make('unassigned')
                    ->label(__('admin_contact_messages.table.filters.unassigned'))
                    ->query(fn (Builder $query): Builder => $query->whereNull('assigned_user_id')),
                Filter::make('received_window')
                    ->label(__('admin_contact_messages.table.filters.received_window'))
                    ->schema([
                        DatePicker::make('from')
                            ->label(__('admin_contact_messages.table.filters.from'))
                            ->native(false),
                        DatePicker::make('until')
                            ->label(__('admin_contact_messages.table.filters.until'))
                            ->native(false),
                    ])
                    ->columns(2)
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when(
                            $data['from'] ?? null,
                            fn (Builder $query, string $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['until'] ?? null,
                            fn (Builder $query, string $date): Builder => $query->whereDate('created_at', '<=', $date),
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
                    ->label(__('admin_contact_messages.actions.edit'))
                    ->icon('heroicon-o-pencil-square'),
                DeleteAction::make()
                    ->label(__('admin_contact_messages.actions.delete'))
                    ->icon('heroicon-o-trash'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label(__('admin_contact_messages.actions.delete_selected'))
                        ->icon('heroicon-o-trash'),
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
            ContactStatus::New->value => (string) __('admin_contact_messages.statuses.new'),
            ContactStatus::InReview->value => (string) __('admin_contact_messages.statuses.in_review'),
            ContactStatus::Responded->value => (string) __('admin_contact_messages.statuses.responded'),
            ContactStatus::Closed->value => (string) __('admin_contact_messages.statuses.closed'),
            ContactStatus::Spam->value => (string) __('admin_contact_messages.statuses.spam'),
            default => (string) __('admin_contact_messages.statuses.unknown'),
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

    public static function contactStatusIcon(mixed $status): string
    {
        return match (self::contactStatusValue($status)) {
            ContactStatus::New->value => 'heroicon-o-envelope',
            ContactStatus::InReview->value => 'heroicon-o-clock',
            ContactStatus::Responded->value => 'heroicon-o-check-circle',
            ContactStatus::Closed->value => 'heroicon-o-archive-box',
            ContactStatus::Spam->value => 'heroicon-o-exclamation-triangle',
            default => 'heroicon-o-question-mark-circle',
        };
    }

    public static function contactStatusTone(mixed $status): string
    {
        return match (self::contactStatusValue($status)) {
            ContactStatus::New->value => 'yellow',
            ContactStatus::InReview->value => 'blue',
            ContactStatus::Responded->value => 'green',
            ContactStatus::Closed->value => 'gray',
            ContactStatus::Spam->value => 'red',
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

        return $query
            ->get()
            ->mapWithKeys(fn (Agency $agency): array => [$agency->id => self::agencyLabel($agency)])
            ->all();
    }

    /**
     * @return array<int, string>
     */
    public static function assignedUserOptions(): array
    {
        return User::query()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->all();
    }

    public static function messageTitle(ContactMessage $message): string
    {
        return filled($message->subject)
            ? (string) $message->subject
            : (string) __('admin_contact_messages.empty_subject');
    }

    public static function messagePreview(ContactMessage $message): string
    {
        return filled($message->message)
            ? (string) str((string) $message->message)->squish()->limit(120, '...')
            : (string) __('admin_contact_messages.table.descriptions.no_message');
    }

    public static function senderContactLine(ContactMessage $message): string
    {
        return collect([$message->phone, $message->email])
            ->filter()
            ->join(' - ') ?: (string) __('admin_contact_messages.table.descriptions.no_contact');
    }

    public static function agencyLabel(?Agency $agency): string
    {
        if (! $agency) {
            return (string) __('admin_contact_messages.empty_agency');
        }

        $locale = app()->getLocale() === 'en' ? 'en' : 'fr';
        $agencyName = $agency->getAttribute("name_{$locale}")
            ?: $agency->name_fr
            ?: $agency->name_en;

        return filled($agencyName) ? (string) $agencyName : (string) __('admin_contact_messages.empty_agency');
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
