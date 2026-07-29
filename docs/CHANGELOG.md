# Documentation changelog

## 1.33 — 2026-07-29

### Changed

- **S064:** Built the public News listing and article detail pages with published article filtering, localized category queries, localized detail slugs, related articles, article-specific SEO metadata, and booking/contact CTAs.
- **S086:** Completed the local stabilization checklist and added `tests/Feature/LocalStabilizationChecklistTest.php` to render all public pages, seeded News article detail routes, and crawl same-site links for 404/500 regressions.
- The active roadmap/checklists now show **S064 and S086 complete** with **S087 Docker Compose** as the next step; the S086 stabilization bundle passed with 52 tests and 1,345 assertions.

## 1.32 — 2026-07-29

### Changed

- **S085:** Verified public contact content against the confirmed company-data source of truth, covering agency phones/emails, addresses, opening hours, Direction Générale address/BP/phone/email, and the public slogan.
- Corrected stale contact-page agency emails, stale Direction Générale contact values, missing Direction Générale BP display, footer secondary phone prefixes, compact Obili Sunday hours, and French slogan punctuation.
- Added `tests/Feature/PublicContactContentVerificationTest.php` plus the S085 testing runbook/log; roadmap/testing notes now show **S080–S085 complete out of sequence** while **S064 News listing + article detail pages** remains first unchecked.

## 1.31 — 2026-07-29

### Changed

- **S084:** Added critical workflow Pest coverage for booking reference uniqueness when stored sequence state trails existing rows, tracking success/failure through service and public route behavior, and booking/document-readiness authorization by staff role and assigned agency.
- Added `tests/Feature/CriticalWorkflowPestCoverageTest.php` as a repeatable CI/local guard for the S084 reference, tracking, and authorization acceptance checks.
- Added the S084 testing runbook/log and updated the roadmap/testing notes to show **S080–S084 complete out of sequence** while **S064 News listing + article detail pages** remains first unchecked.

## 1.30 — 2026-07-29

### Changed

- **S083:** Added a bilingual responsive browser smoke pass covering completed public pages in FR/EN at mobile and desktop browser viewports, with horizontal-overflow, placeholder, translation-key, mobile-menu, and browser-console checks.
- Added `tests/Feature/BilingualResponsiveBrowserSmokeTest.php` as a repeatable Pest companion for locale rendering, viewport meta, mobile navigation hooks, language alternates, placeholder absence, and untranslated-key leakage.
- Added the S083 testing runbook/log and updated the roadmap/testing notes to show **S080–S083 complete out of sequence** while **S064 News listing + article detail pages** remains first unchecked.

## 1.29 — 2026-07-29

### Changed

- **S082:** Added an Agency Admin role isolation smoke test covering assigned-agency scoping across Filament agencies, bookings, document readiness, contact messages, scoped form options, direct edit URLs, and dashboard booking metrics.
- Added unassigned Agency Admin assertions so scoped operational resources stay forbidden when no agency is assigned.
- Added the S082 testing runbook/log and updated the roadmap/testing notes to show **S080–S082 complete out of sequence** while **S064 News listing + article detail pages** remains first unchecked.

## 1.28 — 2026-07-29

### Changed

- **S081:** Added a tracking security smoke test that verifies wrong reference, wrong phone, and wrong vehicle registration submissions stay generic and never render a tracking result.
- Added rate-limit assertions for the sixth failed tracking lookup from the same requester, including retry/rate-limit headers and localized throttle feedback.
- Added the S081 testing runbook/log and updated the roadmap/testing notes to show **S080–S081 complete out of sequence** while **S064 News listing + article detail pages** remains first unchecked.

## 1.27 — 2026-07-29

### Changed

- **S080:** Added a booking workflow smoke test that submits a public French booking, confirms the same request through Filament as assigned Agency Admin staff, updates document readiness, and verifies the customer tracking result.
- Added the S080 testing runbook/log with the manual checklist and repeatable local command; tracking assertions verify public appointment/document messages while hiding customer email, customer name, internal booking notes, and private document notes.
- Roadmap and testing notes now show **S080 complete out of sequence** while **S064 News listing + article detail pages** remains first unchecked.

## 1.26 — 2026-07-29

### Changed

- **S079:** Added the local backup/restore runbook for database, uploaded media, environment references, SQLite dry-run restore, and the future MySQL dump/restore shape for Docker/VPS.
- Added `scripts/backup-restore-smoke.sh`, then ran it to migrate/seed a disposable SQLite database, back up database plus sample media, damage the source, restore into a separate target, and verify restored agencies, settings, and media.
- Roadmap and security notes now show **S077–S079 complete out of sequence** while **S064 News listing + article detail pages** remains first unchecked.

## 1.25 — 2026-07-29

### Changed

- **S078:** Hardened admin image uploads for services, articles, gallery items, and testimonials with a shared JPEG/PNG/WebP allow-list, `jpg/jpeg/png/webp` extension validation, a 2 MB cap, public-disk directories, and server-generated UUID filenames.
- Extended Spatie activity logging to key admin workflow/content/settings/staff models, with tracked changes stored in `attribute_changes` and user password fields excluded from audit payloads.
- Roadmap and security notes now show **S077–S078 complete out of sequence** while **S064 News listing + article detail pages** remains first unchecked.

## 1.24 — 2026-07-29

### Changed

- **S077:** Added honeypot fields and explicit spam-protection middleware to public booking, tracking, and contact form submissions.
- Added booking/contact submission rate limits of five attempts per requester over fifteen minutes with localized generic full-page and JSON feedback; tracking keeps the S070 failed-lookup limiter and now runs behind honeypot protection.
- Roadmap and security notes now show **S077 complete out of sequence** while **S064 News listing + article detail pages** remains first unchecked.

## 1.23 — 2026-07-29

### Changed

- **S076:** Added WebP siblings for public raster imagery, introduced shared `x-media.picture` rendering with WebP sources and PNG fallbacks, and marked public heroes with eager/high-priority loading while keeping below-fold imagery lazy/async.
- Updated the tariffs CSS hero background to use `image-set()` and added focused asset optimization coverage for WebP availability, rendered loading attributes, and the lightweight non-SPA frontend entry.
- Roadmap and SEO notes now show **S074–S076 complete out of sequence** while **S064 News listing + article detail pages** remains first unchecked.

## 1.22 — 2026-07-29

### Changed

- **S075:** Added generated `/sitemap.xml` output with localized public page URLs, FR/EN/x-default alternates, and published article URLs when available.
- Replaced robots handling with a route-backed `/robots.txt` response that disallows `/admin` and points crawlers to the sitemap.
- Added Agencies page LocalBusiness JSON-LD for both GS AUTOBILAN agencies and focused SEO infrastructure coverage; roadmap and SEO notes now show **S075 complete out of sequence** while **S064 News listing + article detail pages** remains first unchecked.

## 1.21 — 2026-07-29

### Changed

- **S074:** Added per-page bilingual SEO metadata for public FR/EN routes, including meta titles, descriptions, canonical URLs, OpenGraph tags, `hreflang` alternates, and French `x-default`.
- Added SEO metadata coverage for all public page skeletons plus placeholder article routes; `SEOService` now tolerates missing `settings` tables so explicit route metadata does not fail in lean public-page contexts.
- Roadmap and SEO notes updated to show **S074 complete out of sequence** while **S064 News listing + article detail pages** remains the first unchecked step.

## 1.20 — 2026-07-29

### Changed

- **S073:** Completed the manual bilingual review pass for completed public pages in FR/EN, added a review log, and added repeatable smoke coverage for locale-specific page copy, document `lang`, placeholder absence, and unresolved translation-key leaks.
- Roadmap and bilingual module notes updated to show **S071–S073 complete out of sequence** while **S064 News listing + article detail pages** remains first unchecked and must receive its own bilingual review when implemented.

## 1.19 — 2026-07-29

### Changed

- **S072:** Added an executable CMS bilingual audit for active/published public content, including required `_fr` / `_en` fields on CMS models and recursive bilingual pairs inside settings JSON.
- Feature coverage now verifies clean live content, detected missing live fields, ignored draft/inactive records, and seeded base CMS data; roadmap and bilingual notes show **S072 complete out of sequence** while **S064 News listing + article detail pages** remains first unchecked.

## 1.18 — 2026-07-29

### Changed

- **S071:** Completed the FR/EN UI translation review by aligning translation-file structures, adding localized Laravel validation dictionaries for public booking/tracking/contact errors and field labels, and covering translation parity plus localized contact validation responses in feature tests.
- Roadmap and bilingual module notes updated to show **S071 complete out of sequence** while **S064 News listing + article detail pages** remains the first unchecked step.

## 1.17 — 2026-07-27

### Changed

- **S070:** Tracking lookup failures now use a requester-scoped limiter: invalid or unmatched submissions count toward five failed attempts in fifteen minutes, throttled users receive compact generic FR/EN feedback, and successful matches clear prior failed attempts.
- Roadmap, step tracker, and tracking module notes updated to show **S069–S070 complete out of sequence** while **S064 News listing + article detail pages** remains the first unchecked step.

## 1.16 — 2026-07-27

### Changed

- **S069:** Tracking lookup now posts through `TrackingLookupRequest`, resolves matches through `TrackingService`, shows compact generic feedback for invalid/unmatched submissions, and renders a real safe public result panel only when reference + phone + vehicle registration all match. Blank tracking pages no longer show the static demo result.
- Roadmap, step tracker, and tracking module notes updated to show **S069 complete out of sequence** while **S064 News listing + article detail pages** remains the first unchecked step and **S070** remains for generic failed lookup/rate-limit hardening.

## 1.15 — 2026-07-27

### Changed

- **S068:** Added end-to-end admin verification for public-created bookings: assigned agency staff can open the request in Filament, move it through every V1 booking status, set confirmed date/time, and save public/internal follow-up messages.
- Roadmap, step tracker, and booking module notes updated to show **S066–S068 complete out of sequence** while **S064 News listing + article detail pages** remains the first unchecked step.

## 1.14 — 2026-07-27

### Changed

- **S067:** Booking confirmation now presents a dedicated server-backed confirmation screen with the generated `GS-YEAR-SEQUENCE`, normalized registration, bilingual next-step guidance, tracking credentials, and a tracking link that pre-fills reference + phone + plate on the tracking page.
- Roadmap, step tracker, and booking module notes updated to show **S067 complete out of sequence** while **S064 News listing + article detail pages** remains the first unchecked step.

## 1.13 — 2026-07-26

### Changed

- **S066:** Public booking form submit now posts through localized FR/EN routes, normalizes wizard fields into `BookingRequest`, persists bookings through `BookingService`, creates default document readiness, dispatches the existing booking-created event, shows the generated `GS-YEAR-SEQUENCE` reference in the server-backed receipt, guards wizard navigation with no-reload required-field highlighting, and downloads a dedicated booking-summary PDF instead of printing the full page.
- Roadmap, step tracker, and booking module notes updated to show **S066 complete out of sequence** while **S064 News listing + article detail pages** remains the first unchecked step.

## 1.12 — 2026-07-24

### Changed

- **S063:** Contact page completed with FR/EN compact smart contact router, generated contact icons, agency contact/map panels, live Google map embeds, Message Desk form, administrative Direction Générale — Bastos card, query-string agency preselection, localized contact submit handling, compact FAQ accordion, and focused Contact page coverage.
- Roadmap, step tracker, public website notes, frontend design notes, content checklist, and root project docs updated so **S064 News listing + article detail pages** is now the next step.

## 1.11 — 2026-07-24

### Changed

- **S062:** Visite Technique page completed with FR/EN compact inspection-bay hero, why-it-matters section, custom SVG control-point grid, five-step passage timeline, educational result outcomes, preparation checklist cards, dark scope/confirmation card, bottom preparation notice strip, normalized `public/images/inspection/` assets, and focused Technical Inspection page coverage.
- Roadmap, step tracker, public website notes, frontend design notes, content checklist, and root project docs updated so **S063 Contact page with FAQ accordion** is now the next step.

## 1.10 — 2026-07-22

### Changed

- **S061:** Tariffs page completed with FR/EN compact authority hero, official tariff navigator, price passport panels, supplied tariff vehicle imagery, searchable/filterable official matrix, mobile tariff cards, print/download/share/reset hooks, clarification tiles, booking category query links, and focused Tariffs page coverage.
- Roadmap, step tracker, public website notes, frontend design notes, content checklist, and root project docs updated so **S062 Visite Technique page** is now the next step.

## 1.9 — 2026-07-22

### Changed

- **S060:** Services page completed with FR/EN centered compact photo hero, three core service cards, vehicle profile selector, contextual vehicle panels, eight technical-control cards, decision gate, final action card, custom services icon work, supplied vehicle/service imagery, and focused Services page coverage.
- Roadmap, step tracker, public website notes, frontend design notes, content checklist, and root project docs updated so **S061 Tariffs page** is now the next step.

## 1.8 — 2026-07-21

### Changed

- **S059:** Tracking page shell completed with FR/EN compact clarity hero, no-real-time lane notice, secure lookup card, reference/phone/plate verification fields, static concierge result state, four-step timeline, confirmed appointment status, key information grid, dossier readiness, next action panel, and mobile two-column detail tiles.
- Roadmap, step tracker, public website notes, frontend design notes, content checklist, and tracking module handoff updated so **S060 Services page** is now the next step.

## 1.7 — 2026-07-17

### Changed

- **S058:** Booking page shell completed with FR/EN compact expectation hero, non-auto-confirmation transparency notice, progressive intake command center, official-ticket-style live summary, document checklist, agency/service/vehicle/date/contact steps, custom branded calendar picker, client-side virtual receipt state, and focused Booking page coverage.
- Roadmap, step tracker, public website notes, frontend design notes, content checklist, and booking module handoff updated so **S059 Tracking shell** is now the next step.

## 1.6 — 2026-07-16

### Changed

- **S057:** Agencies page completed with FR/EN centered photo hero, compact mobile hero treatment, two agency cards, confirmed hours/phone/GPS data, live Google map embeds, visible map info overlays, functional map zoom controls, WhatsApp + booking actions only, and focused Agencies feature coverage; S058 is now next.
- Roadmap, step tracker, public website notes, frontend design notes, and content checklist updated to reflect the completed home/agencies/about pages and the next Booking shell step.

## 1.5 — 2026-07-16

### Changed

- **S056:** Home page completed with the FR/EN carousel hero, compact trust row, agency teaser cards, inspection/services preview, tariffs/why/gallery section, advice cards, final readiness CTA, homepage image assets, translations, and focused homepage feature coverage.
- **S065:** About page completed out of sequence with FR/EN photo hero, compact trust row, mission/vision/values, technician checklist, agencies/direction cards, about page assets, tightened section rhythm, and focused About feature coverage.
- Language switcher now preserves the matching localized route on public pages, such as `/fr/a-propos` ↔ `/en/about`, instead of sending users back to the homepage.

## 1.4 — 2026-07-12

### Changed

- **S055:** Filament resources added for Gallery, Testimonials, Users, Settings, and read-only Audit with Content Manager gallery/testimonial access, Super Admin user/settings management, JSON settings editing, and audit visibility; S056 is now next.
- **S054:** Filament resources added for Contact messages, Articles, and FAQs with queue/content CRUD flows, contact agency scoping, article publishing/SEO fields, and FAQ active/order controls.
- **S053:** Filament resources added for Bookings and Document readiness with status workflows, generated booking references, default readiness creation, editable public/internal messages, `updated_by` stamping, and Agency Admin scoping.
- **S052:** Filament resource added for Tariffs with Super Admin-only CRUD, visible placeholder handling, pending official tariff table text, and activity-log auditing.
- **S051:** Filament resources added for Agencies and Services with list/create/edit/delete flows, Agency Admin agency scoping, and Livewire resource tests.
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
