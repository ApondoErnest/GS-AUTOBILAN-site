<?php

namespace App\Filament\Pages;

use App\Filament\AdminNavigation;
use App\Filament\Resources\AgencyResource;
use App\Filament\Resources\ServiceResource;
use App\Models\Agency;
use App\Models\Service;
use BackedEnum;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use UnitEnum;

class AgenciesServices extends AdminSectionPage
{
    protected string $view = 'filament.pages.agencies-services';

    protected static ?string $title = 'Agencies & Services';

    protected static ?string $slug = 'agencies-services';

    protected static string|UnitEnum|null $navigationGroup = AdminNavigation::GROUP_AGENCIES_SERVICES;

    protected static ?string $navigationLabel = 'Overview';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?int $navigationSort = 0;

    protected static array $allowedRoles = [
        'super_admin',
        'agency_admin',
        'content_manager',
    ];

    public static function getNavigationLabel(): string
    {
        return (string) __('admin_agencies_services.navigation_label');
    }

    public function getTitle(): string|Htmlable
    {
        return (string) __('admin_agencies_services.title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return (string) __('admin_agencies_services.subtitle');
    }

    /**
     * @return array<string>
     */
    public function getPageClasses(): array
    {
        return ['gs-admin-agencies-services-page'];
    }

    /**
     * @return list<array{label: string, value: string, description: string, icon: string, tone: string}>
     */
    public function summaryCards(): array
    {
        $cards = [];
        $hiddenItems = 0;

        if (AgencyResource::canAccess()) {
            $agencyQuery = $this->agencyQuery();
            $totalAgencies = (clone $agencyQuery)->count();
            $activeAgencies = (clone $agencyQuery)->active()->count();
            $operationalAgencies = (clone $agencyQuery)
                ->active()
                ->where('status', 'operational')
                ->count();
            $hiddenAgencies = $totalAgencies - $activeAgencies;
            $hiddenItems += max(0, $hiddenAgencies);

            $cards[] = [
                'label' => (string) __('admin_agencies_services.summary.agencies.label'),
                'value' => number_format($activeAgencies),
                'description' => (string) __('admin_agencies_services.summary.agencies.description', [
                    'total' => number_format($totalAgencies),
                ]),
                'icon' => 'building',
                'tone' => 'blue',
            ];

            $cards[] = [
                'label' => (string) __('admin_agencies_services.summary.operational.label'),
                'value' => number_format($operationalAgencies),
                'description' => (string) __('admin_agencies_services.summary.operational.description'),
                'icon' => 'check',
                'tone' => $operationalAgencies === $activeAgencies ? 'green' : 'yellow',
            ];
        }

        if (ServiceResource::canAccess()) {
            $serviceQuery = $this->serviceQuery();
            $totalServices = (clone $serviceQuery)->count();
            $activeServices = (clone $serviceQuery)->active()->count();
            $hiddenServices = $totalServices - $activeServices;
            $hiddenItems += max(0, $hiddenServices);

            $cards[] = [
                'label' => (string) __('admin_agencies_services.summary.services.label'),
                'value' => number_format($activeServices),
                'description' => (string) __('admin_agencies_services.summary.services.description', [
                    'total' => number_format($totalServices),
                ]),
                'icon' => 'wrench',
                'tone' => 'red',
            ];
        }

        if ($cards !== []) {
            $cards[] = [
                'label' => (string) __('admin_agencies_services.summary.hidden.label'),
                'value' => number_format($hiddenItems),
                'description' => (string) __('admin_agencies_services.summary.hidden.description'),
                'icon' => 'eye-slash',
                'tone' => $hiddenItems > 0 ? 'yellow' : 'green',
            ];
        }

        return $cards;
    }

    /**
     * @return list<array{label: string, description: string, href: string, icon: string, tone: string}>
     */
    public function quickLinks(): array
    {
        $links = [];

        if (AgencyResource::canAccess()) {
            $links[] = [
                'label' => (string) __('admin_agencies_services.quick_links.agencies.label'),
                'description' => (string) __('admin_agencies_services.quick_links.agencies.description'),
                'href' => AgencyResource::getUrl(),
                'icon' => 'building',
                'tone' => 'blue',
            ];
        }

        if (ServiceResource::canAccess()) {
            $links[] = [
                'label' => (string) __('admin_agencies_services.quick_links.services.label'),
                'description' => (string) __('admin_agencies_services.quick_links.services.description'),
                'href' => ServiceResource::getUrl(),
                'icon' => 'wrench',
                'tone' => 'red',
            ];
        }

        return $links;
    }

    /**
     * @return list<array{label: string, count: int, percent: int, description: string}>
     */
    public function readinessItems(): array
    {
        $items = [];

        if (AgencyResource::canAccess()) {
            $agencyQuery = $this->agencyQuery();
            $totalAgencies = (clone $agencyQuery)->count();

            $items[] = $this->readinessItem(
                (string) __('admin_agencies_services.readiness.agency_visibility.label'),
                (clone $agencyQuery)->active()->count(),
                $totalAgencies
            );

            $items[] = $this->readinessItem(
                (string) __('admin_agencies_services.readiness.contact_ready.label'),
                (clone $agencyQuery)
                    ->whereNotNull('email')
                    ->whereNotNull('phones')
                    ->count(),
                $totalAgencies
            );
        }

        if (ServiceResource::canAccess()) {
            $serviceQuery = $this->serviceQuery();
            $totalServices = (clone $serviceQuery)->count();

            $items[] = $this->readinessItem(
                (string) __('admin_agencies_services.readiness.service_visibility.label'),
                (clone $serviceQuery)->active()->count(),
                $totalServices
            );

            $items[] = $this->readinessItem(
                (string) __('admin_agencies_services.readiness.bilingual_services.label'),
                (clone $serviceQuery)
                    ->whereNotNull('title_fr')
                    ->whereNotNull('title_en')
                    ->whereNotNull('short_description_fr')
                    ->whereNotNull('short_description_en')
                    ->count(),
                $totalServices
            );
        }

        return $items;
    }

    /**
     * @return list<array{heading: string, description: string, icon: string, empty: string, items: Collection<int, Agency|Service>, type: string}>
     */
    public function feedPanels(): array
    {
        $panels = [];

        if (AgencyResource::canAccess()) {
            $panels[] = [
                'heading' => (string) __('admin_agencies_services.latest_agencies.heading'),
                'description' => (string) __('admin_agencies_services.latest_agencies.description'),
                'icon' => 'building',
                'empty' => (string) __('admin_agencies_services.latest_agencies.empty'),
                'items' => $this->latestAgencies(),
                'type' => 'agency',
            ];
        }

        if (ServiceResource::canAccess()) {
            $panels[] = [
                'heading' => (string) __('admin_agencies_services.latest_services.heading'),
                'description' => (string) __('admin_agencies_services.latest_services.description'),
                'icon' => 'wrench',
                'empty' => (string) __('admin_agencies_services.latest_services.empty'),
                'items' => $this->latestServices(),
                'type' => 'service',
            ];
        }

        return $panels;
    }

    /**
     * @return list<array{label: string, count: int, description: string, href: string, icon: string, tone: string}>
     */
    public function attentionItems(): array
    {
        $items = [];

        if (AgencyResource::canAccess()) {
            $agencyQuery = $this->agencyQuery();

            $items[] = [
                'label' => (string) __('admin_agencies_services.attention.closed_agencies.label'),
                'count' => (clone $agencyQuery)->where('status', 'temporarily_closed')->count(),
                'description' => (string) __('admin_agencies_services.attention.closed_agencies.description'),
                'href' => AgencyResource::getUrl(),
                'icon' => 'pause',
                'tone' => 'yellow',
            ];

            $items[] = [
                'label' => (string) __('admin_agencies_services.attention.hidden_agencies.label'),
                'count' => (clone $agencyQuery)->where('is_active', false)->count(),
                'description' => (string) __('admin_agencies_services.attention.hidden_agencies.description'),
                'href' => AgencyResource::getUrl(),
                'icon' => 'eye-slash',
                'tone' => 'gray',
            ];
        }

        if (ServiceResource::canAccess()) {
            $serviceQuery = $this->serviceQuery();

            $items[] = [
                'label' => (string) __('admin_agencies_services.attention.hidden_services.label'),
                'count' => (clone $serviceQuery)->where('is_active', false)->count(),
                'description' => (string) __('admin_agencies_services.attention.hidden_services.description'),
                'href' => ServiceResource::getUrl(),
                'icon' => 'eye-slash',
                'tone' => 'gray',
            ];

            $items[] = [
                'label' => (string) __('admin_agencies_services.attention.service_media.label'),
                'count' => (clone $serviceQuery)->whereNull('image')->count(),
                'description' => (string) __('admin_agencies_services.attention.service_media.description'),
                'href' => ServiceResource::getUrl(),
                'icon' => 'photo',
                'tone' => 'yellow',
            ];
        }

        return collect($items)
            ->filter(fn (array $item): bool => $item['count'] > 0)
            ->values()
            ->all();
    }

    public function itemUrl(Agency|Service $item): string
    {
        if ($item instanceof Agency) {
            return AgencyResource::canEdit($item)
                ? AgencyResource::getUrl('edit', ['record' => $item])
                : AgencyResource::getUrl();
        }

        return ServiceResource::canEdit($item)
            ? ServiceResource::getUrl('edit', ['record' => $item])
            : ServiceResource::getUrl();
    }

    public function itemTitle(Agency|Service $item): string
    {
        $attribute = $item instanceof Agency ? 'name' : 'title';

        return $this->localizedAttribute($item, $attribute) ?? (string) __('admin_agencies_services.empty_value');
    }

    public function itemMeta(Agency|Service $item): string
    {
        if ($item instanceof Agency) {
            return collect([$item->city, $item->quarter])
                ->filter(fn (mixed $value): bool => filled($value))
                ->implode(' - ') ?: (string) __('admin_agencies_services.empty_value');
        }

        return $this->localizedAttribute($item, 'short_description') ?? (string) __('admin_agencies_services.empty_value');
    }

    public function itemUpdatedAt(Agency|Service $item): string
    {
        return $item->updated_at?->format('d/m/Y H:i') ?? (string) __('admin_agencies_services.empty_value');
    }

    public function itemStatusLabel(Agency|Service $item): string
    {
        if ($item instanceof Agency) {
            if (! $item->is_active) {
                return (string) __('admin_agencies_services.statuses.hidden');
            }

            return match ($item->status) {
                'operational' => (string) __('admin_agencies_services.statuses.agency.operational'),
                'temporarily_closed' => (string) __('admin_agencies_services.statuses.agency.temporarily_closed'),
                default => (string) __('admin_agencies_services.statuses.unknown'),
            };
        }

        return $item->is_active
            ? (string) __('admin_agencies_services.statuses.service.active')
            : (string) __('admin_agencies_services.statuses.hidden');
    }

    public function itemTone(Agency|Service $item): string
    {
        if (! $item->is_active) {
            return 'gray';
        }

        if ($item instanceof Agency) {
            return $item->status === 'temporarily_closed' ? 'yellow' : 'green';
        }

        return 'blue';
    }

    /**
     * @return Collection<int, Agency>
     */
    private function latestAgencies(): Collection
    {
        return $this->agencyQuery()
            ->latest('updated_at')
            ->limit(4)
            ->get();
    }

    /**
     * @return Collection<int, Service>
     */
    private function latestServices(): Collection
    {
        return $this->serviceQuery()
            ->latest('updated_at')
            ->limit(4)
            ->get();
    }

    private function agencyQuery(): Builder
    {
        return AgencyResource::canAccess()
            ? AgencyResource::getEloquentQuery()
            : Agency::query()->whereRaw('1 = 0');
    }

    private function serviceQuery(): Builder
    {
        return ServiceResource::canAccess()
            ? ServiceResource::getEloquentQuery()
            : Service::query()->whereRaw('1 = 0');
    }

    /**
     * @return array{label: string, count: int, percent: int, description: string}
     */
    private function readinessItem(string $label, int $ready, int $total): array
    {
        return [
            'label' => $label,
            'count' => $ready,
            'percent' => $total > 0 ? (int) round(($ready / $total) * 100) : 0,
            'description' => (string) __('admin_agencies_services.readiness.metric', [
                'ready' => number_format($ready),
                'total' => number_format($total),
            ]),
        ];
    }

    private function localizedAttribute(Model $model, string $attribute): ?string
    {
        $locale = app()->getLocale() === 'en' ? 'en' : 'fr';
        $preferred = $model->getAttribute("{$attribute}_{$locale}");
        $fallback = $model->getAttribute("{$attribute}_fr") ?: $model->getAttribute("{$attribute}_en");

        return filled($preferred) ? (string) $preferred : (filled($fallback) ? (string) $fallback : null);
    }
}
