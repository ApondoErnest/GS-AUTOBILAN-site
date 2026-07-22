# GS AUTOBILAN — Step-by-step tracker (start → finish)

**This is the single execution checklist for the whole project.**

## Rules (mandatory)

1. Do **one step at a time**.
2. A step may start **only if** the previous step is marked `[x]` completed.
3. Mark a step `[x]` only when its **Done when** criteria are met.
4. Do **not** skip steps. Do **not** start coding steps before documentation steps are complete.
5. Update this file when you complete a step (change `[ ]` → `[x]`).

**Legend:** `[x]` = completed · `[ ]` = not done · **Current** = first unchecked step

**Current next step:** **S061** (Build Tariffs page)

**Reference:** [../plan.md](../plan.md) · [README.md](README.md) · Company data: [01-project-documentation/00-company-data.md](01-project-documentation/00-company-data.md)

---

## Block A — Project documentation

### S001 — Write project brief
- [x] **Completed** — slogan, agencies, role wording verified · UI identity link added 2026-07-11
- **Detail:** [01-project-documentation/01-project-brief.md](01-project-documentation/01-project-brief.md)
- **Done when:** Brief exists with name, slogan, goal, users, agencies, stack, approach.

### S002 — Write scope document (V1 in / out)
- [x] **Completed**
- **Detail:** [01-project-documentation/02-scope.md](01-project-documentation/02-scope.md)
- **Depends on:** S001
- **Done when:** Included and excluded V1 features are written and agreed.

### S003 — Confirm sitemap and URLs
- [x] **Completed**
- **Detail:** [01-project-documentation/03-sitemap.md](01-project-documentation/03-sitemap.md)
- **Depends on:** S002
- **Done when:** 10 public pages + admin sections + FR/EN URLs documented.

### S004 — Create content and assets checklist
- [x] **Completed** — revised 2026-07-11: colours locked to **GS Royal Safety Bands**
- **Detail:** [01-project-documentation/04-content-checklist.md](01-project-documentation/04-content-checklist.md)
- **Depends on:** S003
- **Done when:** Checklist of logo, photos, tariffs, FR/EN copy, FAQs, articles exists.

### S005 — Document operational workflows
- [x] **Completed**
- **Detail:** [01-project-documentation/05-operational-workflows.md](01-project-documentation/05-operational-workflows.md)
- **Depends on:** S004
- **Done when:** Booking, tracking, contact, and content workflows are documented.

### S006 — Write V1 / V2 boundary
- [x] **Completed**
- **Detail:** [01-project-documentation/06-v1-v2-boundary.md](01-project-documentation/06-v1-v2-boundary.md)
- **Depends on:** S005
- **Done when:** Clear list of what must wait for V2 (no lane tracking in V1, etc.).

---

## Block B — Requirements

### S007 — Write functional requirements
- [x] **Completed**
- **Detail:** [02-requirements/01-functional-requirements.md](02-requirements/01-functional-requirements.md)
- **Depends on:** S006
- **Done when:** Public + admin + booking + tracking requirements listed with IDs.

### S008 — Write non-functional requirements
- [x] **Completed** — NFR-08a brand identity (GS Royal Safety Bands) added 2026-07-11
- **Detail:** [02-requirements/02-non-functional-requirements.md](02-requirements/02-non-functional-requirements.md)
- **Depends on:** S007
- **Done when:** Bilingual, mobile, security, SEO, performance, ops requirements listed.

### S009 — Define roles, permissions, and user journeys
- [x] **Completed**
- **Detail:** [02-requirements/03-roles-and-journeys.md](02-requirements/03-roles-and-journeys.md)
- **Depends on:** S008
- **Done when:** Super Admin / Agency Admin / Content Manager matrix + journeys written.

---

## Block C — Local environment

### S010 — Verify PHP 8.2+ installed
- [x] **Completed** — PHP 8.5.6 (Homebrew)
- **Detail:** [03-local-environment/01-setup-checklist.md](03-local-environment/01-setup-checklist.md)
- **Depends on:** S009
- **Done when:** `php -v` shows 8.2 or higher.

### S011 — Verify Composer installed
- [x] **Completed** — Composer 2.9.8
- **Depends on:** S010
- **Done when:** `composer -V` works.

### S012 — Verify Node.js and npm installed
- [x] **Completed** — Node v26.0.0 · npm 11.12.1
- **Depends on:** S011
- **Done when:** `node -v` and `npm -v` work (Node 18+ recommended).

### S013 — Verify MySQL 8 available
- [x] **Completed** — MySQL 9.6.0 (Homebrew service running)
- **Depends on:** S012
- **Done when:** MySQL is running and you can create a local database later.

### S014 — Verify Git installed
- [x] **Completed** — git 2.50.1
- **Depends on:** S013
- **Done when:** `git --version` works.

### S015 — Confirm project folders exist
- [x] **Completed** — `docs/`, `brand/`, `design/`, `README.md`, `plan.md`, `docs/STEPS.md` present
- **Depends on:** S014
- **Done when:** `docs/`, `brand/`, `design/`, `README.md`, `plan.md`, `STEPS.md` path are present.

### S016 — Initialize Git repository (main + develop)
- [x] **Completed** — repo on `main` + `develop` · commit `088772a` · `.gitignore` in place
- **Depends on:** S015
- **Done when:** Git repo exists with `main` and `develop` branches (no secrets committed).

### S017 — Confirm environment plan documented
- [x] **Completed** — local / docker-dev / staging / production reviewed 2026-07-10
- **Detail:** [03-local-environment/02-environments.md](03-local-environment/02-environments.md)
- **Depends on:** S016
- **Done when:** local / docker-dev / staging / production plan is understood and file reviewed.

---

## Block D — Laravel foundation

### S018 — Create Laravel application in project root
- [x] **Completed** — Laravel 13.19.0 · `docs/`, `brand/`, `design/` preserved · smoke-tested on :8018
- **Detail:** [04-laravel-setup/README.md](04-laravel-setup/README.md) · [04-laravel-setup/01-technology-stack.md](04-laravel-setup/01-technology-stack.md)
- **Depends on:** S017
- **Done when:** Laravel runs; existing `docs/`, `brand/`, `design/` preserved.

### S019 — Configure `.env` (DB, timezone, locales, mail)
- [x] **Completed** — `Africa/Douala` · `fr`/`en` · MySQL `gs_autobilan` connected · mail=`log`
- **Depends on:** S018
- **Done when:** `APP_TIMEZONE=Africa/Douala`, `APP_LOCALE=fr`, `APP_FALLBACK_LOCALE=en`, DB connects.

### S020 — Generate app key and run default migrations
- [x] **Completed** — `APP_KEY` present · default tables on MySQL `gs_autobilan` (users, cache, jobs, sessions, …)
- **Depends on:** S019
- **Done when:** `php artisan key:generate` done; default tables exist.

### S021 — Install frontend stack (Livewire, Alpine, Tailwind, Vite)
- [x] **Completed** — Livewire 4.3.3 · Tailwind 4 + Vite 8 build OK · Alpine via Livewire
- **Depends on:** S020
- **Done when:** Assets build with Vite; Livewire available.

### S022 — Install Filament and create first Super Admin
- [x] **Completed** — Filament 5.6.8 · `/admin/login` OK · user `admin@gsautobilan.local`
- **Depends on:** S021
- **Done when:** You can log in at `/admin`.

### S023 — Install required packages (Shield, activitylog, sitemap, medialibrary, honeypot, dompdf, Pint, Pest)
- [x] **Completed** — all packages in `composer.json` · permission/activity/media migrations run · Pest 4.7 (replaced `laravel/pao`)
- **Depends on:** S022
- **Done when:** Packages listed in `composer.json` / installed successfully.

### S024 — Scaffold empty public layout and component folders
- [x] **Completed** — `layouts/` · `partials/` · `components/` · `pages/` · `resources/svg/` shells
- **Depends on:** S023
- **Done when:** Blade layout/component directories exist (even if empty shells).

### S025 — Confirm base security (CSRF, auth, protected `/admin`)
- [x] **Completed** — guests → `/admin/login` · panel has `Authenticate` + `PreventRequestForgery` · CSRF 419 outside tests · Pest `AdminSecurityTest`
- **Depends on:** S024
- **Done when:** Admin routes require login; CSRF enabled on forms.

---

## Block E — Architecture

### S026 — Document four system layers
- [x] **Completed** — four layers confirmed vs Laravel 13 / Filament 5 / Livewire 4 app (2026-07-11)
- **Detail:** [05-architecture/01-architecture-overview.md](05-architecture/01-architecture-overview.md)
- **Depends on:** S025
- **Done when:** Architecture overview reviewed/confirmed against running app structure (doc already drafted).

### S027 — Lock module boundaries
- [x] **Completed** — module map + strict owns/must-not locked 2026-07-11
- **Detail:** [05-architecture/02-module-boundaries.md](05-architecture/02-module-boundaries.md)
- **Depends on:** S026
- **Done when:** Module boundaries doc reviewed and accepted for implementation.

### S028 — Confirm permission matrix for implementation
- [x] **Completed** — roles `super_admin` / `agency_admin` / `content_manager` · policies locked for Shield 2026-07-11
- **Detail:** [05-architecture/03-permission-matrix.md](05-architecture/03-permission-matrix.md)
- **Depends on:** S027
- **Done when:** Permission matrix confirmed for Filament Shield setup.

---

## Block F — Frontend design system

### S029 — Lock colour tokens in Tailwind config
- [x] **Completed** — **GS Royal Safety Bands** tokens in `resources/css/app.css` (`gs-primary` `#145DB3`, `gs-navy` `#062A5C`, `gs-accent` `#C8202F`, soft/wall/grey/status…) · revised from centre photos 2026-07-11
- **Detail:** [06-frontend-design/01-brand-and-ui.md](06-frontend-design/01-brand-and-ui.md)
- **Depends on:** S028
- **Done when:** Primary, navy, accent, surface, status colours configured.

### S030 — Define typography and layout variants
- [x] **Completed** — type scale + layouts · surfaces updated to `gs-wall` / `gs-soft` / `gs-concrete` · blank hero uses navy + red band (2026-07-11)
- **Depends on:** S029
- **Detail:** [06-frontend-design/01-brand-and-ui.md](06-frontend-design/01-brand-and-ui.md)
- **Done when:** Home/content/listing/article/form/tracking/error layouts defined.

### S031 — Build shared layout: top strip + header + footer
- [x] **Completed** — strip, white header/nav, and banded footer render on `/` desktop/mobile with no horizontal overflow (2026-07-11)
- **Depends on:** S030
- **Detail:** [06-frontend-design/01-brand-and-ui.md](06-frontend-design/01-brand-and-ui.md) §3 (navy strip + red/white band · white header · navy footer with red/white top band)
- **Done when:** Strip, white header/nav, banded footer render on a blank public page.

### S032 — Build mobile menu + language switcher + sticky WhatsApp/call FABs
- [x] **Completed** — mobile drawer, reusable language switcher, and sticky call/WhatsApp FABs work on `/` mobile viewport (2026-07-11)
- **Depends on:** S031
- **Done when:** Mobile nav and FABs work on a phone-sized viewport.

### S033 — Build reusable cards and UI components
- [x] **Completed** — reusable agency, service, article, testimonial, status badge, FAQ accordion, and CTA group Blade components render with tests (2026-07-11)
- **Depends on:** S032
- **Detail:** [06-frontend-design/01-brand-and-ui.md](06-frontend-design/01-brand-and-ui.md) — white cards + left red band + blue headings
- **Done when:** Agency, service, status badge, FAQ accordion, CTA components exist (banded card style).

### S034 — Add placeholder brand treatment (text logo / GS favicon)
- [x] **Completed** — real `site_logo.png` is used across chrome, and favicon/touch icons were generated from the GS mark (2026-07-11)
- **Depends on:** S033
- **Done when:** Site shows text lockup until real logo arrives.

---

## Block G — Database

### S035 — Create migrations for core tables (users, agencies, settings, services)
- [x] **Completed** — core migration creates `agencies`, `settings`, `services`, extends `users`, and ran on the local database with schema coverage tests (2026-07-11)
- **Detail:** [07-database/01-schema-overview.md](07-database/01-schema-overview.md) · [07-database/02-er-diagram.md](07-database/02-er-diagram.md)
- **Depends on:** S034
- **Done when:** Migrations exist and run for these tables.

### S036 — Create migrations for tariffs, bookings, document_readiness, contact_messages
- [x] **Completed** — booking/contact migration creates `tariffs`, `bookings`, `document_readiness`, and `contact_messages`; it ran on the local database with schema coverage tests (2026-07-11)
- **Detail:** [07-database/01-schema-overview.md](07-database/01-schema-overview.md)
- **Depends on:** S035
- **Done when:** Migrations exist and run.

### S037 — Create migrations for articles, categories, faqs, gallery, testimonials
- [x] **Completed** — content migration creates `article_categories`, `articles`, `faqs`, `gallery_items`, and `testimonials`; `activity_log` is ready and schema tests pass (2026-07-11)
- **Depends on:** S036
- **Done when:** Migrations exist and run; activity log ready.

### S038 — Add Eloquent models, enums, indexes, relationships
- [x] **Completed** — Eloquent models, locked V1 status/category enums, casts, scopes, and documented relationships are in place with contract tests; key indexes were already added in S035-S037 migrations (2026-07-11)
- **Detail:** [07-database/03-indexes-and-validation.md](07-database/03-indexes-and-validation.md)
- **Depends on:** S037
- **Done when:** Models + status enums + key indexes in place.

### S039 — Seed agencies, services, settings, roles, placeholder tariffs, sample FAQs
- [x] **Completed** — base seeder loads roles, existing Super Admin role assignment, Nkolbisson/Obili agencies, settings, 8 services, 8 placeholder tariffs, 6 FAQs, and article categories; local DB seeded and verified (2026-07-11)
- **Detail:** [07-database/04-seed-inventory.md](07-database/04-seed-inventory.md)
- **Depends on:** S038
- **Done when:** Nkolbisson + Obili Scalom and base data load via seeder.

---

## Block H — Backend foundation

### S040 — Implement locale routing (`/fr`, `/en`) and SetLocale middleware
- [x] **Completed** — `/` redirects to `/fr/accueil`, localized FR/EN public route skeletons exist, `SetLocale` switches chrome translations, and shared links are locale-aware (2026-07-11)
- **Detail:** [08-backend/01-routes-and-controllers.md](08-backend/01-routes-and-controllers.md)
- **Depends on:** S039
- **Done when:** `/` redirects to `/fr/accueil`; locale switches.

### S041 — Implement BookingReferenceService (`GS-YEAR-SEQUENCE`)
- [x] **Completed** — `BookingReferenceService` reserves per-year `GS-YYYY-000001` references through a transaction-backed settings sequence and skips existing bookings; tests cover format, uniqueness, and year isolation (2026-07-11)
- **Detail:** [08-backend/02-services-policies-events.md](08-backend/02-services-policies-events.md)
- **Depends on:** S040
- **Done when:** Unique references generate correctly (covered by a test later).

### S042 — Implement BookingService + DocumentReadinessService (create path)
- [x] **Completed** — `BookingService` creates bookings inside a transaction with generated references and default `not_reviewed` document readiness; tests cover creation, uniqueness, idempotency, and rollback (2026-07-11)
- **Detail:** [08-backend/02-services-policies-events.md](08-backend/02-services-policies-events.md)
- **Depends on:** S041
- **Done when:** Creating a booking also creates `not_reviewed` readiness.

### S043 — Implement TrackingService (safe public lookup)
- [x] **Completed** — `TrackingService` matches normalized reference + phone + vehicle registration and returns a safe public `TrackingResult` DTO without customer or internal notes; tests cover success, misses, normalization, and missing-readiness fallback (2026-07-11)
- **Detail:** [08-backend/02-services-policies-events.md](08-backend/02-services-policies-events.md)
- **Depends on:** S042
- **Done when:** Lookup requires ref+phone+plate; returns public fields only.

### S044 — Implement ContactMessageService + ContentService + SEOService stubs
- [x] **Completed** — contact messages can be stored with default `new` status; active bilingual content helpers and SEO metadata helpers exist with tests for filtering, fallback, canonical, and hreflang output (2026-07-11)
- **Depends on:** S043
- **Done when:** Contact can be stored; content/SEO helpers exist.

### S045 — Implement policies (Agency, Booking, DocumentReadiness, Content, Tariff, User)
- [x] **Completed** — backend policies are registered for operations, content/services, tariffs/settings/users, and Agency Admin access is scoped to `assigned_agency_id` with policy coverage tests (2026-07-11)
- **Detail:** [08-backend/02-services-policies-events.md](08-backend/02-services-policies-events.md)
- **Depends on:** S044
- **Done when:** Agency Admin scoping enforced in policies.

### S046 — Wire Form Requests for booking, tracking, contact
- [x] **Completed** — `BookingRequest`, `TrackingLookupRequest`, and `ContactMessageRequest` validate and normalize public form input; tests cover accepted data, rejected data, active agency/service checks, past dates, and phone/plate/reference cleanup (2026-07-12)
- **Detail:** [08-backend/03-validation-notifications.md](08-backend/03-validation-notifications.md)
- **Depends on:** S045
- **Done when:** Validation rules match requirements docs.

### S047 — Add events + admin email notification stubs for booking/contact
- [x] **Completed** — `BookingCreated` and `ContactMessageCreated` events dispatch from services; event listeners send queued mail notifications to the configured direction-generale email with tests for listener registration, event dispatching, on-demand routes, and mail context (2026-07-12)
- **Detail:** [08-backend/03-validation-notifications.md](08-backend/03-validation-notifications.md)
- **Depends on:** S046
- **Done when:** Events fire; mail can be logged/queued locally.

---

## Block I — Admin dashboard

### S048 — Configure Filament Shield roles (Super Admin, Agency Admin, Content Manager)
- [x] **Completed** — Shield is registered on the admin panel, `config/filament-shield.php` is aligned to the three GS staff roles, `User::canAccessPanel()` requires an active staff role, and `RolePolicy` restricts role management to Super Admin; tests cover config, role seeding/assignment, panel access, and role authorization (2026-07-12)
- **Detail:** [09-admin-dashboard/README.md](09-admin-dashboard/README.md) · [09-admin-dashboard/01-navigation-and-widgets.md](09-admin-dashboard/01-navigation-and-widgets.md)
- **Depends on:** S047
- **Done when:** Three roles exist and can be assigned.

### S049 — Build admin navigation groups
- [x] **Completed** — admin navigation groups are centralized in `AdminNavigation`, the panel registers Dashboard / Operations / Website Content / Agencies & Services / Tariffs / Communication / Users & Settings in order, and lightweight role-aware section pages keep each group visible without building CRUD early; tests cover group order, page registration, Super Admin visibility, and Agency Admin / Content Manager scoping (2026-07-12)
- **Detail:** [09-admin-dashboard/01-navigation-and-widgets.md](09-admin-dashboard/01-navigation-and-widgets.md)
- **Depends on:** S048
- **Done when:** Dashboard / Operations / Content / Agencies & Services / Tariffs / Communication / Users & Settings visible.

### S050 — Build dashboard widgets (booking KPIs + alerts)
- [x] **Completed** — dashboard overview now uses scoped Filament widgets for booking KPIs, bookings by agency, document-readiness alerts, new contact messages, published article pulse, and latest contact/article activity; Agency Admin metrics are restricted to their assigned agency with coverage tests (2026-07-12)
- **Detail:** [09-admin-dashboard/01-navigation-and-widgets.md](09-admin-dashboard/01-navigation-and-widgets.md)
- **Depends on:** S049
- **Done when:** Overview shows new/pending/confirmed counts (scoped for Agency Admin).

### S051 — Build Filament resources: Agencies + Services
- [x] **Completed** — Filament `AgencyResource` and `ServiceResource` now provide list/create/edit/delete flows under Agencies & Services; Agency Admin lists only their assigned agency, while service management stays Super Admin / Content Manager only; Livewire resource tests cover CRUD and access scoping (2026-07-12)
- **Detail:** [09-admin-dashboard/02-admin-modules.md](09-admin-dashboard/02-admin-modules.md)
- **Depends on:** S050
- **Done when:** CRUD works for agencies and services.

### S052 — Build Filament resources: Tariffs (+ placeholder flag)
- [x] **Completed** — Filament `TariffResource` now provides Super Admin-only list/create/edit/delete flows, keeps `is_placeholder` visible in forms and the table, shows placeholder prices as pending official tariffs, and records tariff changes in the activity log (2026-07-12)
- **Detail:** [09-admin-dashboard/02-admin-modules.md](09-admin-dashboard/02-admin-modules.md)
- **Depends on:** S051
- **Done when:** Tariffs editable; `is_placeholder` visible.

### S053 — Build Filament resources: Bookings + Document readiness
- [x] **Completed** — Filament `BookingResource` and `DocumentReadinessResource` now provide operational create/list/edit flows, status workflow controls, public/internal booking notes, document next-action/public messages, `updated_by` stamping, and Agency Admin scoping by assigned agency (2026-07-12)
- **Detail:** [09-admin-dashboard/02-admin-modules.md](09-admin-dashboard/02-admin-modules.md)
- **Depends on:** S052
- **Done when:** Status workflow and public/internal notes editable; agency scoped.

### S054 — Build Filament resources: Contact messages + Articles + FAQs
- [x] **Completed** — Filament `ContactMessageResource`, `ArticleResource`, and `FaqResource` now provide list/create/edit/delete flows, status controls, contact assignment/internal notes, article publishing/SEO fields, FAQ active/order controls, Agency Admin contact scoping, and Content Manager article/FAQ access (2026-07-12)
- **Detail:** [09-admin-dashboard/02-admin-modules.md](09-admin-dashboard/02-admin-modules.md)
- **Depends on:** S053
- **Done when:** CRUD works for these modules.

### S055 — Build Filament resources: Gallery + Testimonials + Users + Settings + Audit
- [x] **Completed** — Filament `GalleryItemResource`, `TestimonialResource`, `UserResource`, `SettingResource`, and read-only `ActivityResource` now provide the remaining admin modules; Content Managers can manage gallery/testimonials, while Super Admins manage staff users/settings and view audit logs (2026-07-12)
- **Detail:** [09-admin-dashboard/02-admin-modules.md](09-admin-dashboard/02-admin-modules.md)
- **Depends on:** S054
- **Done when:** Remaining admin modules usable; Super Admin manages users/settings.

---

## Block J — Public website pages

Build order (modern plan): Home → Agencies → Booking shell → Tracking shell → Services → Tariffs → Visite Technique → Contact → News → About. S065 About was completed early by user direction; continue from S061.

### S056 — Build Home page (all main sections)
- [x] **Completed** — homepage sections built and verified in FR/EN: carousel photo hero, compact trust row, agency teaser cards, inspection/services preview, tariffs/why/gallery block, advice cards, final readiness CTA, and tightened responsive section rhythm (2026-07-16)
- **Detail:** [10-public-website/README.md](10-public-website/README.md)
- **Depends on:** S055
- **Done when:** Home shows agencies, services, CTAs, previews in FR (EN labels may still be partial until Block M).

### S057 — Build Agencies page (map + cards + actions)
- [x] **Completed** — Agencies page built and verified in FR/EN with centered photo hero, compact trust/action controls, two agency cards, live Google map embeds, map information overlays, functional map zoom controls, WhatsApp + booking actions only, current-page language switching, and focused feature coverage (2026-07-16)
- **Depends on:** S056
- **Done when:** Both agencies show hours, phone info, live maps, WhatsApp, and booking actions.

### S058 — Add Booking page shell (UI only; logic in Block K)
- [x] **Completed** — Booking page shell built and verified in FR/EN with compact expectation-setting hero, transparency notice, progressive three-step intake command center, live ticket stub, document checklist, agency/service selectors, vehicle categories with distinct icons, custom branded calendar picker, preferred-period handling, customer details, review panel, client-side virtual receipt state, and focused feature coverage (2026-07-17). Backend persistence remains in Block K.
- **Depends on:** S057
- **Done when:** Booking page layout and non-auto-confirm message visible.

### S059 — Add Tracking page shell (UI only; logic in Block L)
- [x] **Completed** — Tracking page shell built and verified in FR/EN with compact clarity hero, no-real-time-lane-tracking notice, premium lookup card, reference/phone/plate verification fields, recovery/help links, static concierge result state, four-step request timeline, appointment status/details, dossier readiness panel, next-action panel, and mobile-optimized two-column detail tiles (2026-07-21). Real lookup, loading, not-found, and persisted result logic remain in Block L.
- **Depends on:** S058
- **Done when:** Tracking form UI visible.

### S060 — Build Services page
- [x] **Completed** — Services page built and verified in FR/EN with a centered compact photo hero, three core service cards, vehicle profile selector, contextual vehicle panels, eight technical-control cards, decision gate, final action card, services page image assets, current-page language switching, and focused services page coverage (2026-07-22).
- **Depends on:** S059
- **Done when:** Core services, vehicle profiles, technical controls, and CTAs to booking/tariffs are visible.

### S061 — Build Tariffs page (table/cards, filter, print/PDF hook)
- [ ] **Pending** ← **do this next**
- **Depends on:** S060
- **Done when:** Page works with placeholder or real tariff data.

### S062 — Build Visite Technique page
- [ ] **Pending**
- **Depends on:** S061
- **Done when:** Documents, preparation, procedure, educational result cards present.

### S063 — Build Contact page with FAQ accordion
- [ ] **Pending**
- **Depends on:** S062
- **Done when:** Contact form + FAQ section + agency/DG details work.

### S064 — Build News listing + article detail pages
- [ ] **Pending**
- **Depends on:** S063
- **Done when:** Published articles list and open by slug.

### S065 — Build About page
- [x] **Completed out of sequence** — About page built and verified in FR/EN with photo hero, compact three-item trust row, mission/vision/values section, technician checklist section, agencies + direction cards without a call button, about image assets, tighter section rhythm, and current-page language switching (2026-07-16). S061 remains the next unchecked step.
- **Depends on:** S064 in the original sequence; completed early by user direction
- **Done when:** Mission/vision/values/DG block present.

---

## Block K — Booking module

### S066 — Wire booking form submit to BookingService
- [ ] **Pending**
- **Detail:** [11-booking-module/README.md](11-booking-module/README.md)
- **Depends on:** S057–S065 public pages complete (S065 is already complete out of sequence)
- **Done when:** Valid submit creates booking + readiness + shows reference.

### S067 — Build booking confirmation screen + link to tracking
- [ ] **Pending**
- **Depends on:** S066
- **Done when:** User sees `GS-YEAR-SEQUENCE` and next steps.

### S068 — Verify admin can manage new booking end-to-end
- [ ] **Pending**
- **Depends on:** S067
- **Done when:** Staff can set Pending/Confirmed/etc. and confirmed datetime.

---

## Block L — Tracking module

### S069 — Wire tracking lookup (ref + phone + plate)
- [ ] **Pending**
- **Detail:** [12-tracking-module/README.md](12-tracking-module/README.md)
- **Depends on:** S068
- **Done when:** Correct combo shows public status panel.

### S070 — Add generic failure message + rate limiting
- [ ] **Pending**
- **Depends on:** S069
- **Done when:** Wrong combo fails safely; repeated attempts limited.

---

## Block M — Bilingual completion

### S071 — Complete `lang/fr` and `lang/en` UI translation files
- [ ] **Pending**
- **Foundation note:** shared chrome strings started early before S033 using structured PHP files under `lang/fr/` and `lang/en/`; S071 still remains for full forms/statuses/errors review.
- **Detail:** [13-bilingual/README.md](13-bilingual/README.md)
- **Depends on:** S070
- **Done when:** Nav, buttons, forms, statuses translate.

### S072 — Audit all CMS `_fr` / `_en` content fields
- [ ] **Pending**
- **Depends on:** S071
- **Done when:** No empty required EN/FR fields on published content.

### S073 — Manual bilingual review pass
- [ ] **Pending**
- **Depends on:** S072
- **Done when:** Reviewer confirms no half-translated public pages.

---

## Block N — SEO and performance

### S074 — Add per-page meta titles/descriptions + hreflang
- [ ] **Pending**
- **Detail:** [14-seo-performance/README.md](14-seo-performance/README.md)
- **Depends on:** S073
- **Done when:** Each public page has bilingual meta + alternates.

### S075 — Add sitemap.xml, robots.txt, JSON-LD LocalBusiness
- [ ] **Pending**
- **Depends on:** S074
- **Done when:** Sitemap generated; `/admin` disallowed; agency schema present.

### S076 — Optimize images and public asset loading
- [ ] **Pending**
- **Depends on:** S075
- **Done when:** Lazy loading / WebP (or equivalent) in place; no heavy SPA.

---

## Block O — Security

### S077 — Apply honeypot + rate limits on public forms
- [ ] **Pending**
- **Detail:** [15-security/README.md](15-security/README.md)
- **Depends on:** S076
- **Done when:** Booking, tracking, contact protected.

### S078 — Harden uploads and confirm audit logging
- [ ] **Pending**
- **Depends on:** S077
- **Done when:** Upload mime/size rules work; key admin actions logged.

### S079 — Write and test backup restore procedure (local/docs)
- [ ] **Pending**
- **Depends on:** S078
- **Done when:** Backup steps documented and restore tested at least once.

---

## Block P — Testing

### S080 — Run booking workflow test (submit → admin → tracking)
- [ ] **Pending**
- **Detail:** [16-testing/README.md](16-testing/README.md)
- **Depends on:** S079
- **Done when:** Full happy path passes manually.

### S081 — Run tracking security tests (wrong fields + rate limit)
- [ ] **Pending**
- **Depends on:** S080
- **Done when:** Failures are safe; rate limit triggers.

### S082 — Run role isolation tests (Agency Admin)
- [ ] **Pending**
- **Depends on:** S081
- **Done when:** Agency Admin cannot see other agency records.

### S083 — Run bilingual + responsive + browser smoke tests
- [ ] **Pending**
- **Depends on:** S082
- **Done when:** FR/EN and mobile/desktop smoke checks pass.

### S084 — Add Pest tests (reference uniqueness, tracking, authorization)
- [ ] **Pending**
- **Depends on:** S083
- **Done when:** Automated tests pass in CI/local.

### S085 — Verify all public contact content (phones, addresses, hours, slogan)
- [ ] **Pending**
- **Depends on:** S084
- **Done when:** Content matches confirmed company data.

---

## Block Q — Local stabilization

### S086 — Complete local stabilization checklist
- [ ] **Pending**
- **Detail:** [17-local-stabilization/README.md](17-local-stabilization/README.md)
- **Depends on:** S085
- **Done when:** All checklist items in Phase 17 README are checked.

---

## Block R — Docker

### S087 — Write Docker Compose stack (app, nginx, mysql, redis, worker, scheduler)
- [ ] **Pending**
- **Detail:** [18-docker/README.md](18-docker/README.md)
- **Depends on:** S086
- **Done when:** Compose file exists for all required services.

### S088 — Run app successfully in Docker with persistent volumes
- [ ] **Pending**
- **Depends on:** S087
- **Done when:** Site and admin work in containers; DB/media persist.

---

## Block S — VPS

### S089 — Provision VPS (min 2 vCPU / 4 GB) with Docker and firewall
- [ ] **Pending**
- **Detail:** [19-vps-deployment/README.md](19-vps-deployment/README.md)
- **Depends on:** S088
- **Done when:** Server reachable and hardened basics in place.

### S090 — Configure domain, SSL, production `.env`
- [ ] **Pending**
- **Depends on:** S089
- **Done when:** HTTPS works; debug off; production secrets set.

### S091 — Configure backups and monitoring
- [ ] **Pending**
- **Depends on:** S090
- **Done when:** Daily DB backup + uptime/SSL monitoring configured.

---

## Block T — Launch

### S092 — Complete pre-launch checklist
- [ ] **Pending**
- **Detail:** [20-launch/README.md](20-launch/README.md)
- **Depends on:** S091
- **Done when:** All pre-launch boxes checked (tariffs, email, photos/logo decision, passwords).

### S093 — Soft launch with staff only
- [ ] **Pending**
- **Depends on:** S092
- **Done when:** Staff tested booking, tracking, contact, mobile; critical issues fixed.

### S094 — Official public launch
- [ ] **Pending**
- **Depends on:** S093
- **Done when:** Site public; staff trained; monitoring watched for first day.

---

## Block U — Maintenance (ongoing)

### S095 — Establish routine maintenance cadence
- [ ] **Pending**
- **Detail:** [21-maintenance/README.md](21-maintenance/README.md)
- **Depends on:** S094
- **Done when:** Who checks bookings/content/backups/security updates is assigned.

### S096 — Review V2 ideas only against V1/V2 boundary
- [ ] **Pending**
- **Depends on:** S095
- **Done when:** No V2 feature started without updating [01-project-documentation/06-v1-v2-boundary.md](01-project-documentation/06-v1-v2-boundary.md).

---

## Progress summary

| Block | Steps | Status |
|-------|-------|--------|
| A Documentation | S001–S006 | Completed |
| B Requirements | S007–S009 | Completed |
| C Local environment | S010–S017 | Completed |
| D Laravel | S018–S025 | Completed |
| E Architecture | S026–S028 | Completed |
| F Frontend design | S029–S034 | Completed |
| G Database | S035–S039 | Completed |
| H Backend | S040–S047 | Completed |
| I Admin | S048–S055 | Completed |
| J Public pages | S056–S065 | In progress |
| K Booking | S066–S068 | Locked |
| L Tracking | S069–S070 | Locked |
| M Bilingual | S071–S073 | Locked |
| N SEO | S074–S076 | Locked |
| O Security | S077–S079 | Locked |
| P Testing | S080–S085 | Locked |
| Q Stabilize | S086 | Locked |
| R Docker | S087–S088 | Locked |
| S VPS | S089–S091 | Locked |
| T Launch | S092–S094 | Locked |
| U Maintenance | S095–S096 | Locked |

**Total steps:** 96 · **Completed:** 61 · **Remaining:** 35 · **Next:** S061
