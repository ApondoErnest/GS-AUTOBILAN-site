# SEO and performance — V1

**Version:** 1.4 · **Steps:** S074–S076

## S074 status

- Completed 2026-07-29, out of sequence while S064 News remains the first unchecked public-site step.
- Localized public page routes now build page-specific SEO payloads with `SEOService`, including canonical URL and FR/EN `hreflang` alternates.
- The shared public layout renders `<title>`, meta description, canonical, OpenGraph basics, locale, image when provided, FR/EN alternates, and French `x-default`.
- FR/EN meta title and description keys exist for Home, About, Agencies, Services, Tariffs, Visite Technique, Booking, Tracking, News, and Contact.
- Article detail placeholders render bilingual placeholder metadata until S064 replaces them with content-specific article pages and article-specific SEO.
- Verification: `php artisan test tests/Feature/PublicSeoMetadataTest.php`; `php artisan test tests/Feature/PublicSeoMetadataTest.php tests/Feature/LocaleRoutingTest.php tests/Feature/BilingualPublicPageReviewTest.php tests/Feature/SupportServicesTest.php tests/Feature/PublicFormRequestTest.php tests/Feature/HomepageHeroTest.php tests/Feature/BaseDataSeederTest.php`; `php -d memory_limit=512M vendor/bin/pest`.

## S075 status

- Completed 2026-07-29, out of sequence while S064 News remains the first unchecked public-site step.
- `/sitemap.xml` is generated through `SEOService` with all FR/EN public page URLs, localized alternates, French `x-default`, and published article URLs when article content exists.
- `/robots.txt` is route-backed, disallows `/admin`, and advertises the generated sitemap URL.
- The Agencies page receives per-agency LocalBusiness JSON-LD for Nkolbisson and Obili Scalom, including names, URL fragments, phones, address locality/country, map URLs, opening-hour text, and geo coordinates.
- Verification: `php artisan test tests/Feature/PublicSeoInfrastructureTest.php`; `php artisan test tests/Feature/PublicSeoInfrastructureTest.php tests/Feature/PublicSeoMetadataTest.php tests/Feature/LocaleRoutingTest.php tests/Feature/BilingualPublicPageReviewTest.php tests/Feature/AgenciesPageTest.php tests/Feature/BaseDataSeederTest.php tests/Feature/SupportServicesTest.php`; `php -d memory_limit=512M vendor/bin/pest`.

## S076 status

- Completed 2026-07-29, out of sequence while S064 News remains the first unchecked public-site step.
- Public PNG/JPEG assets under `public/images/` now ship WebP siblings, excluding the PDF-only `site_logo_pdf.png`.
- Public Blade templates render raster assets through `x-media.picture`, which emits WebP `<source>` elements when available, keeps PNG fallbacks, defaults to lazy loading plus async decoding, and marks visible hero imagery as eager with high fetch priority.
- The tariffs hero keeps its CSS background while using `image-set()` to prefer WebP and retain the PNG fallback.
- `package.json` remains Vite/Tailwind-only and the public JS entry stays lightweight, with regression coverage blocking React/Vue/Inertia-style SPA dependencies.
- Verification: `php artisan test tests/Feature/PublicAssetOptimizationTest.php`; `php artisan test tests/Feature/PublicAssetOptimizationTest.php tests/Feature/HomepageHeroTest.php tests/Feature/AgenciesPageTest.php tests/Feature/ServicesPageTest.php tests/Feature/TariffsPageTest.php tests/Feature/TechnicalInspectionPageTest.php tests/Feature/AboutPageTest.php tests/Feature/ContactPageTest.php tests/Feature/PublicSeoMetadataTest.php tests/Feature/PublicSeoInfrastructureTest.php tests/Feature/LocaleRoutingTest.php`; `npm run build`; `php -d memory_limit=512M vendor/bin/pest`.

## Target keywords

**FR:** GS AUTOBILAN · visite technique Yaoundé / Nkolbisson / Obili · contrôle technique automobile Cameroun / Yaoundé  

**EN:** vehicle inspection Cameroon · technical inspection Yaoundé  

## Per page

SEO title · meta description · OG image · clean URL · headings · alt text · internal links · bilingual metadata  

## Technical

sitemap.xml · robots.txt (disallow `/admin`) · canonicals · hreflang · JSON-LD LocalBusiness per agency  

## Performance

Fast mobile load · optimized images · minimal scripts · cache where suitable · compress assets · minimize layout shift  

**Acceptance:** Search-ready, mobile-friendly, usable on typical Cameroon mobile networks.
