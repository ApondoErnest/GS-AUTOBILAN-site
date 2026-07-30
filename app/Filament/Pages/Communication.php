<?php

namespace App\Filament\Pages;

use App\Filament\AdminNavigation;
use App\Filament\Resources\ContactMessageResource;
use App\Filament\Support\DashboardMetrics;
use App\Models\ContactMessage;
use App\Models\User;
use BackedEnum;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use UnitEnum;

class Communication extends AdminSectionPage
{
    protected string $view = 'filament.pages.communication';

    protected static ?string $title = 'Communication';

    protected static ?string $slug = 'communication';

    protected static string|UnitEnum|null $navigationGroup = AdminNavigation::GROUP_COMMUNICATION;

    protected static ?string $navigationLabel = 'Overview';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?int $navigationSort = 0;

    protected static array $allowedRoles = [
        'super_admin',
        'agency_admin',
    ];

    public static function getNavigationLabel(): string
    {
        return (string) __('admin_communication.navigation_label');
    }

    public function getTitle(): string|Htmlable
    {
        return (string) __('admin_communication.title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return (string) __('admin_communication.subtitle');
    }

    /**
     * @return array<string>
     */
    public function getPageClasses(): array
    {
        return ['gs-admin-communication-page'];
    }

    /**
     * @return list<array{label: string, value: string, description: string, icon: string, tone: string}>
     */
    public function summaryCards(): array
    {
        $query = $this->messageQuery();
        $totalMessages = (clone $query)->count();
        $newMessages = (clone $query)->where('status', 'new')->count();
        $inReviewMessages = (clone $query)->where('status', 'in_review')->count();
        $respondedMessages = (clone $query)->whereIn('status', ['responded', 'closed'])->count();

        return [
            [
                'label' => (string) __('admin_communication.summary.total.label'),
                'value' => number_format($totalMessages),
                'description' => (string) __('admin_communication.summary.total.description'),
                'icon' => 'inbox',
                'tone' => 'blue',
            ],
            [
                'label' => (string) __('admin_communication.summary.new.label'),
                'value' => number_format($newMessages),
                'description' => (string) __('admin_communication.summary.new.description'),
                'icon' => 'envelope',
                'tone' => $newMessages > 0 ? 'yellow' : 'green',
            ],
            [
                'label' => (string) __('admin_communication.summary.in_review.label'),
                'value' => number_format($inReviewMessages),
                'description' => (string) __('admin_communication.summary.in_review.description'),
                'icon' => 'clock',
                'tone' => 'red',
            ],
            [
                'label' => (string) __('admin_communication.summary.responded.label'),
                'value' => number_format($respondedMessages),
                'description' => (string) __('admin_communication.summary.responded.description'),
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
        if (! ContactMessageResource::canAccess()) {
            return [];
        }

        return [
            [
                'label' => (string) __('admin_communication.quick_links.messages.label'),
                'description' => (string) __('admin_communication.quick_links.messages.description'),
                'href' => ContactMessageResource::getUrl(),
                'icon' => 'inbox',
                'tone' => 'blue',
            ],
        ];
    }

    /**
     * @return list<array{label: string, count: int, percent: int, description: string}>
     */
    public function workloadItems(): array
    {
        $query = $this->messageQuery();
        $totalMessages = (clone $query)->count();

        return collect(ContactMessageResource::contactStatusOptions())
            ->map(function (string $label, string $status) use ($query, $totalMessages): array {
                $count = (clone $query)->where('status', $status)->count();

                return [
                    'label' => $label,
                    'count' => $count,
                    'percent' => $totalMessages > 0 ? (int) round(($count / $totalMessages) * 100) : 0,
                    'description' => (string) __('admin_communication.workload.metric', [
                        'count' => number_format($count),
                        'total' => number_format($totalMessages),
                    ]),
                ];
            })
            ->values()
            ->all();
    }

    /**
     * @return Collection<int, ContactMessage>
     */
    public function latestMessages(): Collection
    {
        return $this->messageQuery()
            ->with(['agency', 'assignedUser'])
            ->latest()
            ->limit(5)
            ->get();
    }

    /**
     * @return list<array{label: string, count: int, description: string, href: string, icon: string, tone: string}>
     */
    public function attentionItems(): array
    {
        $query = $this->messageQuery();

        return collect([
            [
                'label' => (string) __('admin_communication.attention.new.label'),
                'count' => (clone $query)->where('status', 'new')->count(),
                'description' => (string) __('admin_communication.attention.new.description'),
                'href' => ContactMessageResource::getUrl(),
                'icon' => 'envelope',
                'tone' => 'yellow',
            ],
            [
                'label' => (string) __('admin_communication.attention.in_review.label'),
                'count' => (clone $query)->where('status', 'in_review')->count(),
                'description' => (string) __('admin_communication.attention.in_review.description'),
                'href' => ContactMessageResource::getUrl(),
                'icon' => 'clock',
                'tone' => 'blue',
            ],
            [
                'label' => (string) __('admin_communication.attention.unassigned.label'),
                'count' => (clone $query)->whereNull('assigned_user_id')->whereNotIn('status', ['responded', 'closed', 'spam'])->count(),
                'description' => (string) __('admin_communication.attention.unassigned.description'),
                'href' => ContactMessageResource::getUrl(),
                'icon' => 'user',
                'tone' => 'red',
            ],
            [
                'label' => (string) __('admin_communication.attention.spam.label'),
                'count' => (clone $query)->where('status', 'spam')->count(),
                'description' => (string) __('admin_communication.attention.spam.description'),
                'href' => ContactMessageResource::getUrl(),
                'icon' => 'exclamation',
                'tone' => 'gray',
            ],
        ])
            ->filter(fn (array $item): bool => $item['count'] > 0)
            ->values()
            ->all();
    }

    public function messageUrl(ContactMessage $message): string
    {
        return ContactMessageResource::canEdit($message)
            ? ContactMessageResource::getUrl('edit', ['record' => $message])
            : ContactMessageResource::getUrl();
    }

    public function messageTitle(ContactMessage $message): string
    {
        return filled($message->subject)
            ? (string) $message->subject
            : (string) __('admin_communication.empty_subject');
    }

    public function messageMeta(ContactMessage $message): string
    {
        return collect([
            $message->name,
            DashboardMetrics::localizedAgencyName($message->agency),
        ])->filter()->join(' - ') ?: (string) __('admin_communication.empty_value');
    }

    public function messageStatusLabel(ContactMessage $message): string
    {
        return ContactMessageResource::contactStatusLabel($message->status);
    }

    public function messageTone(ContactMessage $message): string
    {
        return ContactMessageResource::contactStatusTone($message->status);
    }

    private function messageQuery(): Builder
    {
        $user = ContactMessageResource::currentUser();

        if (! $user instanceof User) {
            return ContactMessage::query()->whereRaw('1 = 0');
        }

        return DashboardMetrics::contactMessageQuery($user);
    }
}
