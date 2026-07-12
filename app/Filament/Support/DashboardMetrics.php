<?php

namespace App\Filament\Support;

use App\Enums\ArticleStatus;
use App\Enums\BookingStatus;
use App\Enums\ContactStatus;
use App\Enums\DocumentReadinessStatus;
use App\Models\Agency;
use App\Models\Article;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\DocumentReadiness;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class DashboardMetrics
{
    /**
     * @return array{total: int, new: int, pending: int, confirmed: int, completed: int, no_show: int}
     */
    public static function bookingCounts(User $user): array
    {
        $query = self::bookingQuery($user);

        $statusCounts = (clone $query)
            ->selectRaw('status, count(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        return [
            'total' => (clone $query)->count(),
            'new' => (int) ($statusCounts[BookingStatus::NewRequest->value] ?? 0),
            'pending' => (int) ($statusCounts[BookingStatus::PendingConfirmation->value] ?? 0),
            'confirmed' => (int) ($statusCounts[BookingStatus::Confirmed->value] ?? 0),
            'completed' => (int) ($statusCounts[BookingStatus::Completed->value] ?? 0),
            'no_show' => (int) ($statusCounts[BookingStatus::NoShow->value] ?? 0),
        ];
    }

    /**
     * @return Collection<int, array{label: string, count: int}>
     */
    public static function agencyBookingBreakdown(User $user): Collection
    {
        if ($user->hasRole('super_admin')) {
            return Agency::query()
                ->withCount('bookings')
                ->ordered()
                ->get()
                ->map(fn (Agency $agency): array => [
                    'label' => $agency->name_fr,
                    'count' => (int) $agency->bookings_count,
                ]);
        }

        if ($user->hasRole('agency_admin') && $user->assigned_agency_id) {
            return Agency::query()
                ->whereKey($user->assigned_agency_id)
                ->withCount('bookings')
                ->get()
                ->map(fn (Agency $agency): array => [
                    'label' => $agency->name_fr,
                    'count' => (int) $agency->bookings_count,
                ]);
        }

        return collect();
    }

    /**
     * @return array{missing_info: int, contact_agency: int, new_contacts: int, latest_articles: int}
     */
    public static function alertCounts(User $user): array
    {
        $documentQuery = self::documentReadinessQuery($user);

        $documentCounts = (clone $documentQuery)
            ->selectRaw('status, count(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        return [
            'missing_info' => (int) ($documentCounts[DocumentReadinessStatus::MissingInfo->value] ?? 0),
            'contact_agency' => (int) ($documentCounts[DocumentReadinessStatus::ContactAgency->value] ?? 0),
            'new_contacts' => self::contactMessageQuery($user)
                ->where('status', ContactStatus::New->value)
                ->count(),
            'latest_articles' => Article::query()
                ->where('status', ArticleStatus::Published->value)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->count(),
        ];
    }

    /**
     * @return Collection<int, ContactMessage>
     */
    public static function latestContactMessages(User $user, int $limit = 5): Collection
    {
        return self::contactMessageQuery($user)
            ->with('agency')
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * @return Collection<int, Article>
     */
    public static function latestArticles(int $limit = 5): Collection
    {
        return Article::query()
            ->latest()
            ->limit($limit)
            ->get();
    }

    public static function canViewOperations(User $user): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }

        return $user->hasRole('agency_admin') && filled($user->assigned_agency_id);
    }

    public static function canViewContent(User $user): bool
    {
        return $user->hasAnyRole(['super_admin', 'content_manager']);
    }

    public static function bookingQuery(User $user): Builder
    {
        $query = Booking::query();

        if ($user->hasRole('super_admin')) {
            return $query;
        }

        if ($user->hasRole('agency_admin') && $user->assigned_agency_id) {
            return $query->where('agency_id', $user->assigned_agency_id);
        }

        return self::emptyQuery($query);
    }

    public static function documentReadinessQuery(User $user): Builder
    {
        $query = DocumentReadiness::query();

        if ($user->hasRole('super_admin')) {
            return $query;
        }

        if ($user->hasRole('agency_admin') && $user->assigned_agency_id) {
            return $query->whereHas(
                'booking',
                fn (Builder $bookingQuery): Builder => $bookingQuery->where('agency_id', $user->assigned_agency_id),
            );
        }

        return self::emptyQuery($query);
    }

    public static function contactMessageQuery(User $user): Builder
    {
        $query = ContactMessage::query();

        if ($user->hasRole('super_admin')) {
            return $query;
        }

        if ($user->hasRole('agency_admin') && $user->assigned_agency_id) {
            return $query->where('agency_id', $user->assigned_agency_id);
        }

        return self::emptyQuery($query);
    }

    protected static function emptyQuery(Builder $query): Builder
    {
        return $query->whereRaw('1 = 0');
    }
}
