<?php

namespace App\Services;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Faq;
use App\Models\GalleryItem;
use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContentService
{
    /**
     * @return EloquentCollection<int, Article>
     */
    public function publishedArticles(int $limit = 6, ?ArticleCategory $category = null): EloquentCollection
    {
        return Article::query()
            ->with('category')
            ->published()
            ->when($category, fn (Builder $query): Builder => $query->where('category_id', $category->id))
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }

    public function articleBySlug(string $slug, ?string $locale = null): ?Article
    {
        $locale = $this->normalizeLocale($locale);
        $fallbackLocale = $this->fallbackLocale();

        return Article::query()
            ->with('category')
            ->published()
            ->where("slug_{$locale}", $slug)
            ->first()
            ?? Article::query()
                ->with('category')
                ->published()
                ->where("slug_{$fallbackLocale}", $slug)
                ->first();
    }

    public function articleCategoryBySlug(string $slug, ?string $locale = null): ?ArticleCategory
    {
        $locale = $this->normalizeLocale($locale);
        $fallbackLocale = $this->fallbackLocale();

        return ArticleCategory::query()
            ->active()
            ->where("slug_{$locale}", $slug)
            ->first()
            ?? ArticleCategory::query()
                ->active()
                ->where("slug_{$fallbackLocale}", $slug)
                ->first();
    }

    /**
     * @return EloquentCollection<int, Article>
     */
    public function relatedArticles(Article $article, int $limit = 3): EloquentCollection
    {
        return Article::query()
            ->with('category')
            ->published()
            ->whereKeyNot($article->id)
            ->when($article->category_id, fn (Builder $query): Builder => $query->where('category_id', $article->category_id))
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }

    public function publicImageUrl(?string $path, string $fallback): string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return $fallback;
        }

        if (Str::startsWith($path, ['http://', 'https://', '//', 'images/', '/images/', 'storage/', '/storage/'])) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }

    /**
     * @return EloquentCollection<int, ArticleCategory>
     */
    public function activeArticleCategories(): EloquentCollection
    {
        return ArticleCategory::query()->active()->ordered()->get();
    }

    /**
     * @return EloquentCollection<int, Faq>
     */
    public function activeFaqs(): EloquentCollection
    {
        return Faq::query()->active()->ordered()->get();
    }

    /**
     * @return EloquentCollection<int, GalleryItem>
     */
    public function activeGalleryItems(int $limit = 6): EloquentCollection
    {
        return GalleryItem::query()->with('agency')->active()->ordered()->limit($limit)->get();
    }

    /**
     * @return EloquentCollection<int, Testimonial>
     */
    public function activeTestimonials(int $limit = 3): EloquentCollection
    {
        return Testimonial::query()->active()->ordered()->limit($limit)->get();
    }

    /**
     * @return array<string, EloquentCollection<int, Model>>
     */
    public function homepageSections(): array
    {
        return [
            'articles' => $this->publishedArticles(3),
            'faqs' => $this->activeFaqs(),
            'gallery' => $this->activeGalleryItems(6),
            'testimonials' => $this->activeTestimonials(3),
        ];
    }

    public function localized(Model|array $source, string $field, ?string $locale = null): ?string
    {
        $locale = $this->normalizeLocale($locale);
        $fallbackLocale = $this->fallbackLocale();

        foreach (array_unique([$locale, $fallbackLocale, 'fr', 'en']) as $candidateLocale) {
            $value = data_get($source, "{$field}_{$candidateLocale}");

            if (is_string($value) && trim($value) !== '') {
                return $value;
            }
        }

        return null;
    }

    private function normalizeLocale(?string $locale): string
    {
        $locale ??= app()->getLocale() ?: config('app.locale', 'fr');

        return in_array($locale, ['fr', 'en'], true) ? $locale : 'fr';
    }

    private function fallbackLocale(): string
    {
        $fallbackLocale = config('app.fallback_locale', 'en');

        return in_array($fallbackLocale, ['fr', 'en'], true) ? $fallbackLocale : 'en';
    }
}
