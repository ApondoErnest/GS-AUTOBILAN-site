<?php

namespace App\Filament\Pages;

use App\Enums\ArticleStatus;
use App\Filament\AdminNavigation;
use App\Filament\Resources\ArticleResource;
use App\Filament\Resources\FaqResource;
use App\Filament\Resources\GalleryItemResource;
use App\Filament\Resources\TestimonialResource;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Faq;
use App\Models\GalleryItem;
use App\Models\Testimonial;
use BackedEnum;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use UnitEnum;

class WebsiteContent extends AdminSectionPage
{
    protected string $view = 'filament.pages.website-content';

    protected static ?string $title = 'Website Content';

    protected static ?string $slug = 'website-content';

    protected static string|UnitEnum|null $navigationGroup = AdminNavigation::GROUP_CONTENT;

    protected static ?string $navigationLabel = 'Overview';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 0;

    protected static array $allowedRoles = [
        'super_admin',
        'content_manager',
    ];

    public static function getNavigationLabel(): string
    {
        return (string) __('admin_content.navigation_label');
    }

    public function getTitle(): string|Htmlable
    {
        return (string) __('admin_content.title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return (string) __('admin_content.subtitle');
    }

    /**
     * @return array<string>
     */
    public function getPageClasses(): array
    {
        return ['gs-admin-content-page'];
    }

    /**
     * @return list<array{label: string, value: string, description: string, icon: string, tone: string}>
     */
    public function summaryCards(): array
    {
        $publishedArticles = Article::query()->published()->count();
        $draftArticles = Article::query()->where('status', ArticleStatus::Draft->value)->count();
        $activeFaqs = Faq::query()->active()->count();
        $visibleProof = GalleryItem::query()->active()->count() + Testimonial::query()->active()->count();

        return [
            [
                'label' => (string) __('admin_content.summary.published.label'),
                'value' => number_format($publishedArticles),
                'description' => (string) __('admin_content.summary.published.description'),
                'icon' => 'eye',
                'tone' => 'green',
            ],
            [
                'label' => (string) __('admin_content.summary.drafts.label'),
                'value' => number_format($draftArticles),
                'description' => (string) __('admin_content.summary.drafts.description'),
                'icon' => 'draft',
                'tone' => $draftArticles > 0 ? 'yellow' : 'green',
            ],
            [
                'label' => (string) __('admin_content.summary.faqs.label'),
                'value' => number_format($activeFaqs),
                'description' => (string) __('admin_content.summary.faqs.description', [
                    'total' => number_format(Faq::query()->count()),
                ]),
                'icon' => 'question',
                'tone' => 'blue',
            ],
            [
                'label' => (string) __('admin_content.summary.proof.label'),
                'value' => number_format($visibleProof),
                'description' => (string) __('admin_content.summary.proof.description'),
                'icon' => 'photo',
                'tone' => 'red',
            ],
        ];
    }

    /**
     * @return list<array{label: string, description: string, href: string, icon: string, tone: string}>
     */
    public function quickLinks(): array
    {
        $links = [];

        if (ArticleResource::canAccess()) {
            $links[] = [
                'label' => (string) __('admin_content.quick_links.articles.label'),
                'description' => (string) __('admin_content.quick_links.articles.description'),
                'href' => ArticleResource::getUrl(),
                'icon' => 'newspaper',
                'tone' => 'blue',
            ];
        }

        if (FaqResource::canAccess()) {
            $links[] = [
                'label' => (string) __('admin_content.quick_links.faqs.label'),
                'description' => (string) __('admin_content.quick_links.faqs.description'),
                'href' => FaqResource::getUrl(),
                'icon' => 'question',
                'tone' => 'yellow',
            ];
        }

        if (GalleryItemResource::canAccess()) {
            $links[] = [
                'label' => (string) __('admin_content.quick_links.gallery.label'),
                'description' => (string) __('admin_content.quick_links.gallery.description'),
                'href' => GalleryItemResource::getUrl(),
                'icon' => 'photo',
                'tone' => 'red',
            ];
        }

        if (TestimonialResource::canAccess()) {
            $links[] = [
                'label' => (string) __('admin_content.quick_links.testimonials.label'),
                'description' => (string) __('admin_content.quick_links.testimonials.description'),
                'href' => TestimonialResource::getUrl(),
                'icon' => 'chat',
                'tone' => 'green',
            ];
        }

        return $links;
    }

    /**
     * @return list<array{label: string, count: int, percent: int, description: string}>
     */
    public function contentModules(): array
    {
        $articleTotal = Article::query()->count();
        $faqTotal = Faq::query()->count();
        $galleryTotal = GalleryItem::query()->count();
        $testimonialTotal = Testimonial::query()->count();

        return [
            $this->moduleItem(
                (string) __('admin_content.modules.articles.label'),
                Article::query()->published()->count(),
                $articleTotal
            ),
            $this->moduleItem(
                (string) __('admin_content.modules.faqs.label'),
                Faq::query()->active()->count(),
                $faqTotal
            ),
            $this->moduleItem(
                (string) __('admin_content.modules.gallery.label'),
                GalleryItem::query()->active()->count(),
                $galleryTotal
            ),
            $this->moduleItem(
                (string) __('admin_content.modules.testimonials.label'),
                Testimonial::query()->active()->count(),
                $testimonialTotal
            ),
        ];
    }

    /**
     * @return Collection<int, Article>
     */
    public function latestArticles(): Collection
    {
        return Article::query()
            ->with('category')
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
                'label' => (string) __('admin_content.attention.draft_articles.label'),
                'count' => Article::query()->where('status', ArticleStatus::Draft->value)->count(),
                'description' => (string) __('admin_content.attention.draft_articles.description'),
                'href' => ArticleResource::getUrl(),
                'icon' => 'draft',
                'tone' => 'yellow',
            ],
            [
                'label' => (string) __('admin_content.attention.inactive_faqs.label'),
                'count' => Faq::query()->where('is_active', false)->count(),
                'description' => (string) __('admin_content.attention.inactive_faqs.description'),
                'href' => FaqResource::getUrl(),
                'icon' => 'question',
                'tone' => 'gray',
            ],
            [
                'label' => (string) __('admin_content.attention.hidden_gallery.label'),
                'count' => GalleryItem::query()->where('is_active', false)->count(),
                'description' => (string) __('admin_content.attention.hidden_gallery.description'),
                'href' => GalleryItemResource::getUrl(),
                'icon' => 'photo',
                'tone' => 'gray',
            ],
            [
                'label' => (string) __('admin_content.attention.hidden_testimonials.label'),
                'count' => Testimonial::query()->where('is_active', false)->count(),
                'description' => (string) __('admin_content.attention.hidden_testimonials.description'),
                'href' => TestimonialResource::getUrl(),
                'icon' => 'chat',
                'tone' => 'gray',
            ],
        ])
            ->filter(fn (array $item): bool => $item['count'] > 0)
            ->values()
            ->all();
    }

    public function articleUrl(Article $article): string
    {
        return ArticleResource::canEdit($article)
            ? ArticleResource::getUrl('edit', ['record' => $article])
            : ArticleResource::getUrl();
    }

    public function localizedArticleTitle(Article $article): string
    {
        return $this->localizedAttribute($article, 'title') ?? (string) __('admin_content.empty_value');
    }

    public function localizedArticleSummary(Article $article): string
    {
        return $this->localizedAttribute($article, 'summary') ?? (string) __('admin_content.empty_value');
    }

    public function localizedCategoryName(?ArticleCategory $category): ?string
    {
        if (! $category) {
            return null;
        }

        return $this->localizedAttribute($category, 'name');
    }

    public function articleStatusLabel(mixed $status): string
    {
        return match ($this->articleStatusValue($status)) {
            ArticleStatus::Draft->value => (string) __('admin_content.statuses.article.draft'),
            ArticleStatus::Published->value => (string) __('admin_content.statuses.article.published'),
            ArticleStatus::Archived->value => (string) __('admin_content.statuses.article.archived'),
            default => (string) __('admin_content.statuses.unknown'),
        };
    }

    public function articleTone(mixed $status): string
    {
        return match ($this->articleStatusValue($status)) {
            ArticleStatus::Published->value => 'green',
            ArticleStatus::Archived->value => 'gray',
            ArticleStatus::Draft->value => 'yellow',
            default => 'gray',
        };
    }

    /**
     * @return array{label: string, count: int, percent: int, description: string}
     */
    private function moduleItem(string $label, int $visible, int $total): array
    {
        return [
            'label' => $label,
            'count' => $visible,
            'percent' => $total > 0 ? (int) round(($visible / $total) * 100) : 0,
            'description' => (string) __('admin_content.modules.metric', [
                'visible' => number_format($visible),
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

    private function articleStatusValue(mixed $status): ?string
    {
        return $status instanceof ArticleStatus ? $status->value : $status;
    }
}
