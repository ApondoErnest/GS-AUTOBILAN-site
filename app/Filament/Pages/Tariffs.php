<?php

namespace App\Filament\Pages;

use App\Filament\AdminNavigation;
use App\Filament\Resources\TariffResource;
use App\Models\Tariff;
use BackedEnum;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;
use UnitEnum;

class Tariffs extends AdminSectionPage
{
    protected string $view = 'filament.pages.tariffs';

    protected static ?string $title = 'Tariffs';

    protected static ?string $slug = 'tariffs-overview';

    protected static string|UnitEnum|null $navigationGroup = AdminNavigation::GROUP_TARIFFS;

    protected static ?string $navigationLabel = 'Overview';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static ?int $navigationSort = 0;

    protected static array $allowedRoles = [
        'super_admin',
    ];

    public static function getNavigationLabel(): string
    {
        return (string) __('admin_tariffs.navigation_label');
    }

    public function getTitle(): string|Htmlable
    {
        return (string) __('admin_tariffs.title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return (string) __('admin_tariffs.subtitle');
    }

    /**
     * @return array<string>
     */
    public function getPageClasses(): array
    {
        return ['gs-admin-tariffs-page'];
    }

    /**
     * @return list<array{label: string, value: string, description: string, icon: string, tone: string}>
     */
    public function summaryCards(): array
    {
        $totalTariffs = Tariff::query()->count();
        $activeTariffs = Tariff::query()->active()->count();
        $officialTariffs = Tariff::query()
            ->where('is_placeholder', false)
            ->whereNotNull('price')
            ->count();
        $placeholderTariffs = Tariff::query()->where('is_placeholder', true)->count();
        $categories = Tariff::query()
            ->whereNotNull('category')
            ->distinct()
            ->count('category');

        return [
            [
                'label' => (string) __('admin_tariffs.summary.active.label'),
                'value' => number_format($activeTariffs),
                'description' => (string) __('admin_tariffs.summary.active.description', [
                    'total' => number_format($totalTariffs),
                ]),
                'icon' => 'eye',
                'tone' => 'blue',
            ],
            [
                'label' => (string) __('admin_tariffs.summary.official.label'),
                'value' => number_format($officialTariffs),
                'description' => (string) __('admin_tariffs.summary.official.description'),
                'icon' => 'banknotes',
                'tone' => 'green',
            ],
            [
                'label' => (string) __('admin_tariffs.summary.placeholders.label'),
                'value' => number_format($placeholderTariffs),
                'description' => (string) __('admin_tariffs.summary.placeholders.description'),
                'icon' => 'clock',
                'tone' => $placeholderTariffs > 0 ? 'yellow' : 'green',
            ],
            [
                'label' => (string) __('admin_tariffs.summary.categories.label'),
                'value' => number_format($categories),
                'description' => (string) __('admin_tariffs.summary.categories.description'),
                'icon' => 'squares',
                'tone' => 'red',
            ],
        ];
    }

    /**
     * @return list<array{label: string, description: string, href: string, icon: string, tone: string}>
     */
    public function quickLinks(): array
    {
        if (! TariffResource::canAccess()) {
            return [];
        }

        return [
            [
                'label' => (string) __('admin_tariffs.quick_links.tariffs.label'),
                'description' => (string) __('admin_tariffs.quick_links.tariffs.description'),
                'href' => TariffResource::getUrl(),
                'icon' => 'banknotes',
                'tone' => 'blue',
            ],
        ];
    }

    /**
     * @return list<array{label: string, count: int, percent: int, description: string}>
     */
    public function readinessItems(): array
    {
        $totalTariffs = Tariff::query()->count();

        return [
            $this->readinessItem(
                (string) __('admin_tariffs.readiness.visibility.label'),
                Tariff::query()->active()->count(),
                $totalTariffs
            ),
            $this->readinessItem(
                (string) __('admin_tariffs.readiness.official_prices.label'),
                Tariff::query()
                    ->where('is_placeholder', false)
                    ->whereNotNull('price')
                    ->count(),
                $totalTariffs
            ),
            $this->readinessItem(
                (string) __('admin_tariffs.readiness.update_dates.label'),
                Tariff::query()->whereNotNull('last_updated_at')->count(),
                $totalTariffs
            ),
            $this->readinessItem(
                (string) __('admin_tariffs.readiness.bilingual_notes.label'),
                Tariff::query()
                    ->whereNotNull('notes_fr')
                    ->whereNotNull('notes_en')
                    ->count(),
                $totalTariffs
            ),
        ];
    }

    /**
     * @return Collection<int, Tariff>
     */
    public function latestTariffs(): Collection
    {
        return Tariff::query()
            ->latest('updated_at')
            ->limit(4)
            ->get();
    }

    /**
     * @return list<array{label: string, count: int, description: string, href: string, icon: string, tone: string}>
     */
    public function attentionItems(): array
    {
        return collect([
            [
                'label' => (string) __('admin_tariffs.attention.placeholders.label'),
                'count' => Tariff::query()->where('is_placeholder', true)->count(),
                'description' => (string) __('admin_tariffs.attention.placeholders.description'),
                'href' => TariffResource::getUrl(),
                'icon' => 'clock',
                'tone' => 'yellow',
            ],
            [
                'label' => (string) __('admin_tariffs.attention.missing_prices.label'),
                'count' => Tariff::query()->whereNull('price')->count(),
                'description' => (string) __('admin_tariffs.attention.missing_prices.description'),
                'href' => TariffResource::getUrl(),
                'icon' => 'banknotes',
                'tone' => 'yellow',
            ],
            [
                'label' => (string) __('admin_tariffs.attention.hidden_rows.label'),
                'count' => Tariff::query()->where('is_active', false)->count(),
                'description' => (string) __('admin_tariffs.attention.hidden_rows.description'),
                'href' => TariffResource::getUrl(),
                'icon' => 'eye-slash',
                'tone' => 'gray',
            ],
            [
                'label' => (string) __('admin_tariffs.attention.missing_dates.label'),
                'count' => Tariff::query()->whereNull('last_updated_at')->count(),
                'description' => (string) __('admin_tariffs.attention.missing_dates.description'),
                'href' => TariffResource::getUrl(),
                'icon' => 'calendar',
                'tone' => 'red',
            ],
        ])
            ->filter(fn (array $item): bool => $item['count'] > 0)
            ->values()
            ->all();
    }

    public function tariffUrl(Tariff $tariff): string
    {
        return TariffResource::canEdit($tariff)
            ? TariffResource::getUrl('edit', ['record' => $tariff])
            : TariffResource::getUrl();
    }

    public function tariffTitle(Tariff $tariff): string
    {
        return TariffResource::localizedVehicleType($tariff);
    }

    public function tariffMeta(Tariff $tariff): string
    {
        return collect([
            TariffResource::categoryLabel($tariff->category),
            $tariff->validity,
        ])->filter()->join(' - ') ?: (string) __('admin_tariffs.empty_value');
    }

    public function tariffStatusLabel(Tariff $tariff): string
    {
        return $tariff->is_placeholder
            ? (string) __('admin_tariffs.statuses.tariff.placeholder')
            : (string) __('admin_tariffs.statuses.tariff.official');
    }

    public function tariffTone(Tariff $tariff): string
    {
        if (! $tariff->is_active) {
            return 'gray';
        }

        return $tariff->is_placeholder ? 'yellow' : 'green';
    }

    public function tariffPrice(Tariff $tariff): string
    {
        return TariffResource::formatPrice($tariff->price, $tariff);
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
            'description' => (string) __('admin_tariffs.readiness.metric', [
                'ready' => number_format($ready),
                'total' => number_format($total),
            ]),
        ];
    }
}
