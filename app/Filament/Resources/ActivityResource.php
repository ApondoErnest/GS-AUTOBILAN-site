<?php

namespace App\Filament\Resources;

use App\Filament\AdminNavigation;
use App\Filament\Resources\ActivityResource\Pages;
use App\Models\User;
use BackedEnum;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $slug = 'audit';

    protected static ?string $navigationLabel = 'Audit';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static string|\UnitEnum|null $navigationGroup = AdminNavigation::GROUP_USERS_SETTINGS;

    protected static ?int $navigationSort = 40;

    public static function getNavigationLabel(): string
    {
        return (string) __('admin_activity.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return (string) __('admin_activity.model.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return (string) __('admin_activity.model.plural');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading(__('admin_activity.table.heading'))
            ->description(__('admin_activity.table.description'))
            ->columns([
                TextColumn::make('description')
                    ->label(__('admin_activity.table.columns.activity'))
                    ->icon('heroicon-o-clipboard-document-list')
                    ->weight(FontWeight::Bold)
                    ->formatStateUsing(fn (?string $state, Activity $record): string => self::activityDescription($record))
                    ->description(fn (Activity $record): string => self::activityMeta($record))
                    ->searchable()
                    ->wrap(),
                TextColumn::make('log_name')
                    ->label(__('admin_activity.table.columns.log'))
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => self::logLabel($state))
                    ->sortable(),
                TextColumn::make('event')
                    ->label(__('admin_activity.table.columns.event'))
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => self::eventLabel($state))
                    ->color(fn (?string $state): string => self::eventColor($state))
                    ->sortable(),
                TextColumn::make('subject_type')
                    ->label(__('admin_activity.table.columns.subject'))
                    ->icon('heroicon-o-cube')
                    ->formatStateUsing(fn (?string $state, Activity $record): string => self::subjectLabel($state, $record->subject_id))
                    ->toggleable()
                    ->visibleFrom('md'),
                TextColumn::make('causer_type')
                    ->label(__('admin_activity.table.columns.causer'))
                    ->icon('heroicon-o-user-circle')
                    ->formatStateUsing(fn (?string $state, Activity $record): string => self::causerLabel($state, $record->causer_id))
                    ->toggleable()
                    ->visibleFrom('lg'),
                TextColumn::make('created_at')
                    ->label(__('admin_activity.table.columns.created'))
                    ->icon('heroicon-o-clock')
                    ->dateTime('M j, Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->stackedOnMobile()
            ->striped()
            ->defaultPaginationPageOption(25)
            ->paginated([10, 25, 50])
            ->emptyStateIcon('heroicon-o-clipboard-document-list')
            ->emptyStateHeading(__('admin_activity.table.empty_heading'))
            ->emptyStateDescription(__('admin_activity.table.empty_description'))
            ->filters([
                SelectFilter::make('log_name')
                    ->label(__('admin_activity.table.filters.log'))
                    ->options(fn (): array => self::logOptions())
                    ->native(false),
                SelectFilter::make('event')
                    ->label(__('admin_activity.table.filters.event'))
                    ->options(fn (): array => self::eventOptions())
                    ->native(false),
                Filter::make('created_window')
                    ->label(__('admin_activity.table.filters.created_window'))
                    ->schema([
                        DatePicker::make('from')
                            ->label(__('admin_activity.table.filters.from'))
                            ->native(false),
                        DatePicker::make('until')
                            ->label(__('admin_activity.table.filters.until'))
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
                'md' => 3,
            ])
            ->persistFiltersInSession();
    }

    public static function canAccess(): bool
    {
        return self::currentUser()?->hasRole('super_admin') ?? false;
    }

    public static function canViewAny(): bool
    {
        return self::canAccess();
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    /**
     * @return array<string, string>
     */
    public static function logOptions(): array
    {
        return Activity::query()
            ->whereNotNull('log_name')
            ->distinct()
            ->orderBy('log_name')
            ->pluck('log_name', 'log_name')
            ->map(fn (?string $log): string => self::logLabel($log))
            ->all();
    }

    /**
     * @return array<string, string>
     */
    public static function eventOptions(): array
    {
        return Activity::query()
            ->whereNotNull('event')
            ->distinct()
            ->orderBy('event')
            ->pluck('event', 'event')
            ->map(fn (?string $event): string => self::eventLabel($event))
            ->all();
    }

    public static function activityDescription(Activity $activity): string
    {
        return filled($activity->description)
            ? (string) $activity->description
            : (string) __('admin_activity.table.descriptions.no_description');
    }

    public static function activityMeta(Activity $activity): string
    {
        return collect([
            self::logLabel($activity->log_name),
            self::subjectLabel($activity->subject_type, $activity->subject_id),
        ])->filter()->join(' - ') ?: (string) __('admin_activity.empty_value');
    }

    public static function logLabel(?string $logName): string
    {
        if (blank($logName)) {
            return (string) __('admin_activity.empty_value');
        }

        $key = "admin_activity.logs.{$logName}";

        return trans()->has($key)
            ? (string) __($key)
            : (string) str($logName)->replace(['_', '-'], ' ')->headline();
    }

    public static function eventLabel(?string $event): string
    {
        if (blank($event)) {
            return (string) __('admin_activity.empty_value');
        }

        $key = "admin_activity.events.{$event}";

        return trans()->has($key)
            ? (string) __($key)
            : (string) str($event)->replace(['_', '-'], ' ')->headline();
    }

    public static function eventColor(?string $event): string
    {
        return match ($event) {
            'created' => 'success',
            'updated' => 'info',
            'deleted' => 'danger',
            default => 'gray',
        };
    }

    public static function eventTone(?string $event): string
    {
        return match ($event) {
            'created' => 'green',
            'updated' => 'blue',
            'deleted' => 'red',
            default => 'gray',
        };
    }

    public static function subjectLabel(?string $subjectType, mixed $subjectId): string
    {
        if (blank($subjectType)) {
            return (string) __('admin_activity.empty_value');
        }

        return class_basename($subjectType).' #'.($subjectId ?: __('admin_activity.empty_id'));
    }

    public static function causerLabel(?string $causerType, mixed $causerId): string
    {
        if (blank($causerType)) {
            return (string) __('admin_activity.empty_causer');
        }

        return class_basename($causerType).' #'.($causerId ?: __('admin_activity.empty_id'));
    }

    /**
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivities::route('/'),
        ];
    }

    private static function currentUser(): ?User
    {
        $user = Filament::auth()->user();

        return $user instanceof User ? $user : null;
    }
}
