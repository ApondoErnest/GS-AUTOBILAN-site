# Bilingual implementation — V1

**Version:** 1.3 · **Steps:** S071–S073

- Default: **French** · Secondary: **English**  
- URLs: `/fr` · `/en` with localized slugs  
- CMS: `_fr` / `_en` fields  
- UI: structured PHP translation files under `lang/fr/` · `lang/en/`  
- Language switcher: preserve the matching localized route when available, e.g. `/fr/a-propos` ↔ `/en/about`; localized article slugs and News category query slugs switch to their FR/EN counterparts; fall back to the locale home only when a page has no counterpart.
- Translate: menus, buttons, forms, validation, statuses, FAQ, footer, SEO, tracking errors  
- Manual review before launch — avoid machine-only translation  

## S071 status

- FR/EN translation files must stay structurally aligned; `LocaleRoutingTest` now verifies matching file names and leaf keys.
- Public validation messages and attribute labels live in `lang/fr/validation.php` and `lang/en/validation.php` so booking, tracking, and contact form errors stay localized.
- Public status/error strings remain in their page-specific files (`booking.php`, `tracking.php`, `contact.php`) beside the related UI copy.

## S072 status

- `CmsBilingualAuditService` audits active/published CMS records for required `_fr` and `_en` fields before public pages rely on locale fallback.
- Published articles require bilingual titles, slugs, summaries, and content; active article categories, FAQs, gallery items, testimonials, agencies, services, and tariffs require their public bilingual fields.
- CMS-managed settings JSON is scanned recursively for `_fr` / `_en` pairs so public SEO, footer, and identity copy stays complete in both locales.
- Feature tests cover a clean live-content audit, missing live fields, ignored draft/inactive records, and the seeded base CMS data.

## S073 status

- Manual review recorded in [01-manual-review-log.md](01-manual-review-log.md) for Home, About, Agencies, Services, Tariffs, Technical inspection, Booking, Tracking, and Contact in FR/EN.
- `BilingualPublicPageReviewTest` renders each completed public page, including News after S064, in both locales and checks locale-specific copy, document `lang`, placeholder absence, and unresolved translation-key leaks.
- S064 added News listing/detail bilingual coverage for localized category filters, article slugs, language-switch alternates, and article detail SEO.

**Acceptance:** Every public page and public message available in FR and EN.
