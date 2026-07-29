<?php

namespace App\Filament\Pages;

use App\Enums\BookingStatus;
use App\Enums\DocumentReadinessStatus;
use App\Filament\AdminNavigation;
use App\Filament\Resources\BookingResource;
use App\Filament\Resources\DocumentReadinessResource;
use App\Filament\Support\DashboardMetrics;
use App\Models\Agency;
use App\Models\Booking;
use App\Models\DocumentReadiness;
use App\Models\Service;
use App\Models\User;
use BackedEnum;
use Filament\Facades\Filament;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;
use UnitEnum;

class Operations extends AdminSectionPage
{
    protected string $view = 'filament.pages.operations';

    protected static ?string $title = 'Operations';

    protected static ?string $slug = 'operations';

    protected static string|UnitEnum|null $navigationGroup = AdminNavigation::GROUP_OPERATIONS;

    protected static ?string $navigationLabel = 'Overview';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?int $navigationSort = 0;

    protected static array $allowedRoles = [
        'super_admin',
        'agency_admin',
    ];

    public static function getNavigationLabel(): string
    {
        return (string) __('admin_operations.navigation_label');
    }

    public function getTitle(): string|Htmlable
    {
        return (string) __('admin_operations.title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return (string) __('admin_operations.subtitle');
    }

    /**
     * @return array<string>
     */
    public function getPageClasses(): array
    {
        return ['gs-admin-operations-page'];
    }

    /**
     * @return list<array{label: string, value: string, description: string, icon: string, tone: string}>
     */
    public function summaryCards(): array
    {
        $user = $this->currentUser();

        if (! $user) {
            return [];
        }

        $bookingCounts = DashboardMetrics::bookingCounts($user);
        $alertCounts = DashboardMetrics::alertCounts($user);
        $bookingQuery = DashboardMetrics::bookingQuery($user);
        $documentQuery = DashboardMetrics::documentReadinessQuery($user);
        $documentCounts = (clone $documentQuery)
            ->selectRaw('status, count(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $confirmationQueue = $bookingCounts['new'] + $bookingCounts['pending'];
        $documentQueue = $alertCounts['missing_info'] + $alertCounts['contact_agency'];

        return [
            [
                'label' => (string) __('admin_operations.summary.today.label'),
                'value' => number_format((clone $bookingQuery)->whereDate('preferred_date', today())->count()),
                'description' => (string) __('admin_operations.summary.today.description'),
                'icon' => 'calendar',
                'tone' => 'blue',
            ],
            [
                'label' => (string) __('admin_operations.summary.confirmations.label'),
                'value' => number_format($confirmationQueue),
                'description' => (string) __('admin_operations.summary.confirmations.description'),
                'icon' => 'clock',
                'tone' => $confirmationQueue > 0 ? 'yellow' : 'green',
            ],
            [
                'label' => (string) __('admin_operations.summary.documents.label'),
                'value' => number_format($documentQueue),
                'description' => (string) __('admin_operations.summary.documents.description'),
                'icon' => 'document',
                'tone' => $documentQueue > 0 ? 'red' : 'green',
            ],
            [
                'label' => (string) __('admin_operations.summary.ready.label'),
                'value' => number_format((int) ($documentCounts[DocumentReadinessStatus::ReadyForVisit->value] ?? 0)),
                'description' => (string) __('admin_operations.summary.ready.description', [
                    'total' => number_format((clone $documentQuery)->count()),
                ]),
                'icon' => 'check',
                'tone' => 'green',
            ],
        ];
    }

    /**
     * @return list<array{label: string, description: string, href: string, icon: string, tone: string}>
     */
    public function quickLinks(): array
    {
        $links = [];

        if (BookingResource::canAccess()) {
            $links[] = [
                'label' => (string) __('admin_operations.quick_links.bookings.label'),
                'description' => (string) __('admin_operations.quick_links.bookings.description'),
                'href' => BookingResource::getUrl(),
                'icon' => 'calendar',
                'tone' => 'blue',
            ];
        }

        if (DocumentReadinessResource::canAccess()) {
            $links[] = [
                'label' => (string) __('admin_operations.quick_links.documents.label'),
                'description' => (string) __('admin_operations.quick_links.documents.description'),
                'href' => DocumentReadinessResource::getUrl(),
                'icon' => 'document',
                'tone' => 'yellow',
            ];
        }

        return $links;
    }

    /**
     * @return Collection<int, array{label: string, count: int, percent: int}>
     */
    public function agencyWorkload(): Collection
    {
        $user = $this->currentUser();

        if (! $user) {
            return collect();
        }

        $items = DashboardMetrics::agencyBookingBreakdown($user);
        $max = max(1, (int) $items->max('count'));

        return $items
            ->sortByDesc('count')
            ->take(4)
            ->values()
            ->map(fn (array $item): array => [
                'label' => $item['label'],
                'count' => $item['count'],
                'percent' => (int) round(($item['count'] / $max) * 100),
            ]);
    }

    /**
     * @return Collection<int, Booking>
     */
    public function latestBookings(): Collection
    {
        $user = $this->currentUser();

        if (! $user) {
            return collect();
        }

        return DashboardMetrics::bookingQuery($user)
            ->with(['agency', 'service', 'documentReadiness'])
            ->latest()
            ->limit(4)
            ->get();
    }

    /**
     * @return Collection<int, DocumentReadiness>
     */
    public function latestDocuments(): Collection
    {
        $user = $this->currentUser();

        if (! $user) {
            return collect();
        }

        return DashboardMetrics::documentReadinessQuery($user)
            ->with(['booking.agency', 'updatedBy'])
            ->latest()
            ->limit(4)
            ->get();
    }

    public function bookingUrl(Booking $booking): string
    {
        return BookingResource::canEdit($booking)
            ? BookingResource::getUrl('edit', ['record' => $booking])
            : BookingResource::getUrl();
    }

    public function documentUrl(DocumentReadiness $document): string
    {
        return DocumentReadinessResource::canEdit($document)
            ? DocumentReadinessResource::getUrl('edit', ['record' => $document])
            : DocumentReadinessResource::getUrl();
    }

    public function bookingStatusLabel(mixed $status): string
    {
        return match ($this->bookingStatusValue($status)) {
            BookingStatus::NewRequest->value => (string) __('admin_operations.statuses.booking.new_request'),
            BookingStatus::PendingConfirmation->value => (string) __('admin_operations.statuses.booking.pending_confirmation'),
            BookingStatus::Confirmed->value => (string) __('admin_operations.statuses.booking.confirmed'),
            BookingStatus::Rescheduled->value => (string) __('admin_operations.statuses.booking.rescheduled'),
            BookingStatus::Cancelled->value => (string) __('admin_operations.statuses.booking.cancelled'),
            BookingStatus::Completed->value => (string) __('admin_operations.statuses.booking.completed'),
            BookingStatus::NoShow->value => (string) __('admin_operations.statuses.booking.no_show'),
            default => (string) __('admin_operations.statuses.unknown'),
        };
    }

    public function documentStatusLabel(mixed $status): string
    {
        return match ($this->documentStatusValue($status)) {
            DocumentReadinessStatus::NotReviewed->value => (string) __('admin_operations.statuses.document.not_reviewed'),
            DocumentReadinessStatus::Complete->value => (string) __('admin_operations.statuses.document.complete'),
            DocumentReadinessStatus::MissingInfo->value => (string) __('admin_operations.statuses.document.missing_info'),
            DocumentReadinessStatus::ContactAgency->value => (string) __('admin_operations.statuses.document.contact_agency'),
            DocumentReadinessStatus::ReadyForVisit->value => (string) __('admin_operations.statuses.document.ready_for_visit'),
            default => (string) __('admin_operations.statuses.unknown'),
        };
    }

    public function bookingTone(mixed $status): string
    {
        return match ($this->bookingStatusValue($status)) {
            BookingStatus::NewRequest->value,
            BookingStatus::PendingConfirmation->value => 'yellow',
            BookingStatus::Cancelled->value,
            BookingStatus::NoShow->value => 'red',
            BookingStatus::Confirmed->value,
            BookingStatus::Completed->value => 'green',
            default => 'gray',
        };
    }

    public function documentTone(mixed $status): string
    {
        return match ($this->documentStatusValue($status)) {
            DocumentReadinessStatus::MissingInfo->value => 'red',
            DocumentReadinessStatus::ContactAgency->value,
            DocumentReadinessStatus::NotReviewed->value => 'yellow',
            DocumentReadinessStatus::Complete->value,
            DocumentReadinessStatus::ReadyForVisit->value => 'green',
            default => 'gray',
        };
    }

    public function localizedServiceTitle(?Service $service): ?string
    {
        if (! $service) {
            return null;
        }

        $locale = app()->getLocale() === 'en' ? 'en' : 'fr';
        $title = $service->getAttribute("title_{$locale}")
            ?: $service->title_fr
            ?: $service->title_en;

        return filled($title) ? (string) $title : null;
    }

    public function localizedAgencyName(?Agency $agency): ?string
    {
        return DashboardMetrics::localizedAgencyName($agency);
    }

    protected function currentUser(): ?User
    {
        $user = Filament::auth()->user();

        return $user instanceof User ? $user : null;
    }

    private function bookingStatusValue(mixed $status): ?string
    {
        return $status instanceof BookingStatus ? $status->value : $status;
    }

    private function documentStatusValue(mixed $status): ?string
    {
        return $status instanceof DocumentReadinessStatus ? $status->value : $status;
    }
}
