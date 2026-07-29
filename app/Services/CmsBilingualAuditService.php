<?php

namespace App\Services;

use App\Models\Agency;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Faq;
use App\Models\GalleryItem;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Tariff;
use App\Models\Testimonial;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CmsBilingualAuditService
{
    /**
     * @return list<array{model: class-string<Model>, table: string, id: int|string|null, field: string, label: string}>
     */
    public function missingRequiredFields(): array
    {
        $issues = [];

        foreach ($this->contentDefinitions() as $definition) {
            foreach (($definition['query'])()->get() as $record) {
                foreach ($definition['fields'] as $field) {
                    if ($this->fieldIsFilled($record->getAttribute($field))) {
                        continue;
                    }

                    $issues[] = $this->modelIssue($record, $field);
                }
            }
        }

        return [
            ...$issues,
            ...$this->settingsIssues(),
        ];
    }

    public function passes(): bool
    {
        return $this->missingRequiredFields() === [];
    }

    /**
     * @return array<class-string<Model>, list<string>>
     */
    public function requiredColumnMap(): array
    {
        $map = [];

        foreach ($this->contentDefinitions() as $definition) {
            $map[$definition['model']] = $definition['fields'];
        }

        return $map;
    }

    /**
     * @return list<array{model: class-string<Model>, query: Closure(): Builder, fields: list<string>}>
     */
    private function contentDefinitions(): array
    {
        return [
            [
                'model' => Agency::class,
                'query' => fn (): Builder => Agency::query()->active(),
                'fields' => [
                    'name_fr',
                    'name_en',
                    'address_fr',
                    'address_en',
                    'opening_hours_fr',
                    'opening_hours_en',
                ],
            ],
            [
                'model' => Service::class,
                'query' => fn (): Builder => Service::query()->active(),
                'fields' => [
                    'title_fr',
                    'title_en',
                    'slug_fr',
                    'slug_en',
                    'short_description_fr',
                    'short_description_en',
                ],
            ],
            [
                'model' => Tariff::class,
                'query' => fn (): Builder => Tariff::query()->active(),
                'fields' => [
                    'vehicle_type_fr',
                    'vehicle_type_en',
                ],
            ],
            [
                'model' => ArticleCategory::class,
                'query' => fn (): Builder => ArticleCategory::query()->active(),
                'fields' => [
                    'name_fr',
                    'name_en',
                    'slug_fr',
                    'slug_en',
                ],
            ],
            [
                'model' => Article::class,
                'query' => fn (): Builder => Article::query()->published(),
                'fields' => [
                    'title_fr',
                    'title_en',
                    'slug_fr',
                    'slug_en',
                    'summary_fr',
                    'summary_en',
                    'content_fr',
                    'content_en',
                ],
            ],
            [
                'model' => Faq::class,
                'query' => fn (): Builder => Faq::query()->active(),
                'fields' => [
                    'question_fr',
                    'question_en',
                    'answer_fr',
                    'answer_en',
                ],
            ],
            [
                'model' => GalleryItem::class,
                'query' => fn (): Builder => GalleryItem::query()->active(),
                'fields' => [
                    'caption_fr',
                    'caption_en',
                ],
            ],
            [
                'model' => Testimonial::class,
                'query' => fn (): Builder => Testimonial::query()->active(),
                'fields' => [
                    'customer_type_fr',
                    'customer_type_en',
                    'message_fr',
                    'message_en',
                ],
            ],
        ];
    }

    /**
     * @return list<array{model: class-string<Model>, table: string, id: int|string|null, field: string, label: string}>
     */
    private function settingsIssues(): array
    {
        $issues = [];

        foreach (Setting::query()->get() as $setting) {
            foreach ($this->localizedJsonIssues($setting, $setting->value ?? []) as $issue) {
                $issues[] = $issue;
            }
        }

        return $issues;
    }

    /**
     * @param  array<string|int, mixed>  $source
     * @return list<array{model: class-string<Model>, table: string, id: int|string|null, field: string, label: string}>
     */
    private function localizedJsonIssues(Setting $setting, array $source, string $prefix = ''): array
    {
        $issues = [];
        $localizedBases = [];

        foreach ($source as $key => $value) {
            $key = (string) $key;

            if (is_array($value)) {
                $issues = [
                    ...$issues,
                    ...$this->localizedJsonIssues($setting, $value, "{$prefix}{$key}."),
                ];
            }

            if (! preg_match('/_(fr|en)$/', $key)) {
                continue;
            }

            $baseKey = substr($key, 0, -3);

            if (in_array($baseKey, $localizedBases, true)) {
                continue;
            }

            $localizedBases[] = $baseKey;

            foreach (['fr', 'en'] as $locale) {
                $localizedKey = "{$baseKey}_{$locale}";

                if (array_key_exists($localizedKey, $source) && $this->fieldIsFilled($source[$localizedKey])) {
                    continue;
                }

                $issues[] = $this->modelIssue($setting, "value.{$prefix}{$localizedKey}");
            }
        }

        return $issues;
    }

    /**
     * @return array{model: class-string<Model>, table: string, id: int|string|null, field: string, label: string}
     */
    private function modelIssue(Model $record, string $field): array
    {
        return [
            'model' => $record::class,
            'table' => $record->getTable(),
            'id' => $record->getKey(),
            'field' => $field,
            'label' => sprintf('%s#%s.%s', $record->getTable(), $record->getKey() ?? 'unknown', $field),
        ];
    }

    private function fieldIsFilled(mixed $value): bool
    {
        if (is_string($value)) {
            return trim($value) !== '';
        }

        if (is_array($value)) {
            if ($value === []) {
                return false;
            }

            foreach ($value as $item) {
                if (! $this->fieldIsFilled($item)) {
                    return false;
                }
            }

            return true;
        }

        return filled($value);
    }
}
