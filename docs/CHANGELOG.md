# Documentation changelog

## 1.4 — 2026-07-12

### Changed

- **S051:** Filament resources added for Agencies and Services with list/create/edit/delete flows, Agency Admin agency scoping, and Livewire resource tests; S052 is now next.
- **S050:** Dashboard widgets added for booking KPIs, bookings by agency, document-readiness alerts, new contact messages, published article pulse, and latest contact/article activity with Agency Admin scoping tests.
- **S049:** Admin navigation groups added in the documented order with role-aware section overview pages and navigation coverage tests.
- **S048:** Filament Shield registered for the admin panel; three GS staff roles remain the only seeded panel roles, active staff-role access is enforced, Role management is Super Admin-only, and focused Shield role tests were added.
- **S047:** Booking/contact creation events and queued admin mail notification stubs added with listener registration, route, and mail-context tests.
- **S046:** Public Form Requests added for booking, tracking lookup, and contact forms with normalization and validation tests.

## 1.3 — 2026-07-11

### Changed

- Design system renamed **GS Royal Safety Bands** (from centre photos)
- Palette: royal blue `#145DB3`, navy `#062A5C`, signal red `#C8202F`, soft/wall/grey tokens; ratio 50/35/8/5/2
- Chrome rules: navy+red strip, white header, photo hero, banded cards, banded footer
- Removed ox-blood `#7A1621` from docs and CSS tokens
- Updated `01-brand-and-ui.md`, content checklist, admin theme note, STEPS S029/S031/S033, `resources/css/app.css`
- **Retrofit S001–S030:** brief + NFR-08a · S004 checklist · S029 tokens · S030 layouts/blank hero (`gs-wall`/`gs-soft`/`gs-concrete`, navy+red band)
- **S035:** Core database migration added for `agencies`, `settings`, `services`, and user agency/activity fields; S036 is now next.
- **S036:** Booking/contact database migration added for `tariffs`, `bookings`, `document_readiness`, and `contact_messages`; S037 is now next.
- **S037:** Content database migration added for `article_categories`, `articles`, `faqs`, `gallery_items`, and `testimonials`; S038 is now next.
- **S038:** Eloquent models, V1 status/category enums, casts, scopes, relationships, and model contract tests added; S039 is now next.
- **S039:** Base data seeder added and run for roles, agencies, settings, services, placeholder tariffs, FAQs, and article categories; S040 is now next.
- **S040:** Locale routing added for `/fr` and `/en`, root redirect now targets `/fr/accueil`, and shared chrome links switch with locale; S041 is now next.
- **S041:** Booking reference service added for transaction-backed `GS-YEAR-SEQUENCE` generation with uniqueness tests; S042 is now next.
- **S042:** Booking create path added through `BookingService` and `DocumentReadinessService`; creating a booking now generates a reference and default `not_reviewed` readiness in one transaction; S043 is now next.
- **S043:** Tracking lookup service added with normalized reference/phone/plate matching and a safe public result DTO that hides customer and internal booking details; S044 is now next.
- **S044:** Contact, content, and SEO service foundations added; contacts store with default `new` status, active bilingual content helpers filter/fallback correctly, and SEO metadata helpers produce canonical/hreflang output; S045 is now next.
- **S045:** Backend policies registered and tested for Super Admin, Agency Admin scoping, and Content Manager access across operations, content/services, tariffs, settings, and users; S046 is now next.

## 1.2 — 2026-07-10

### Changed

- Single source of truth for company data: `01-project-documentation/00-company-data.md`
- Slimmed `plan.md`, root `README.md`, and `docs/README.md` (removed repeated agency tables and meta docs)
- Deduplicated brief, scope, sitemap, workflows, content checklist, seed inventory
- Public page build order aligned with modern plan: Home → Agencies → Booking → Tracking → Services → Tariffs → Visite → Contact → News → About (`STEPS` S058–S065)

### Removed

- `DOCUMENTATION-GUIDE.md` (merged into `docs/README.md`)
- `22-final-deliverables.md` (covered by `plan.md` §4–6)

## 1.1 — 2026-07-10

### Added

- Technology stack, backend, admin, frontend design packs
- Expanded phase notes for public site, booking, tracking, bilingual, SEO, security, testing

### Changed

- Step-first execution via `STEPS.md`

## 1.0 — 2026-07-10

### Added

- Initial chronological docs (phases 1–21), `STEPS.md` (S001–S096), project docs, architecture, database schema
