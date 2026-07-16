# Public website implementation — V1

**Steps:** S056–S065 · **Status:** S056 and S065 complete, S057 next · Sitemap: [../01-project-documentation/03-sitemap.md](../01-project-documentation/03-sitemap.md)

---

## Build order

1. Home · 2. Agencies · 3. Booking shell · 4. Tracking shell · 5. Services · 6. Tariffs · 7. Visite Technique · 8. Contact + FAQ · 9. News · 10. About  

S065 About was completed early by user direction; continue the remaining public build from S057 Agencies.

*(Chrome: navy+red strip · white header · banded footer — Block F / S031.)*

---

## Current status

| Step | Page | Status | Notes |
|------|------|--------|-------|
| S056 | Home | Complete | Implemented in `resources/views/pages/home.blade.php` with FR/EN translations and homepage assets under `public/images/homepage/`. |
| S057 | Agencies | Next | Full agencies page should expand the teaser cards with maps, call/WhatsApp, directions, hours, and booking actions. |
| S065 | About | Complete (built early) | Implemented in `resources/views/pages/about.blade.php` with FR/EN translations, `public/images/aboutpage/hero-about.png`, `technician-about.png`, and focused page/language-switch tests. |

---

## Page checklists

| Page | Must include |
|------|----------------|
| Home | Complete: photo carousel hero (blue overlay) · trust row · agencies teaser · inspection/services preview · booking/tracking CTAs · tariff preview · why GS · agency gallery · advice/news cards · final readiness CTA · red/white/blue ribbon and compact section rhythm |
| Agencies | Banded white cards · maps · call/WhatsApp · hours · book |
| Booking | Non-auto-confirm notice · form sections · success + reference (wired in Block K) |
| Tracking | Explanation · lookup · safe error · result panel (wired in Block L) |
| Services | Grid · who for · CTAs to booking/tariffs |
| Tariffs | Table + mobile cards · filter · last updated · print · book CTA |
| Visite Technique | What/why · documents · prepare · procedure · checks · Accepté/Suspendu/Refusé (educational) · contre-visite · failures |
| Contact | DG · agency cards · form · maps · FAQ · call/WhatsApp |
| News | Listing · filters · detail · related · CTAs |
| About | Complete: photo hero · three-item trust row · mission/vision/values · technician checklist · agencies/direction cards · FR/EN |

---

## Acceptance

All public pages work FR/EN, mobile-friendly, DB-driven where required.

---

## Home implementation notes

- The hero uses `public/images/homepage/hero-1.png` through `hero-5.png` as a carousel with a deep-blue overlay and GS red/white/blue ribbon.
- The home agency teaser uses `agency-1.png` and `agency-2.png`; the call button is intentionally omitted on home and belongs on the full Agencies page.
- The inspection preview includes the controlled points grid and the six-step process; step 04 is **Contrôle Technique**.
- The tariff preview uses the supplied category list and prices, plus the why-choose list and gallery images `agence-3.png` through `agence-6.png`.
- The advice/readiness block uses `prepare-visit.png`, `necessary-docs.png`, `case-cv.png`, and `agence-6.png`; the right CTA keeps only the title plus two checklist columns.
- Section padding was tightened to `py-9 sm:py-10 lg:py-12` so homepage sections do not feel too far apart.
- Coverage: `tests/Feature/HomepageHeroTest.php`, `npm run build`, and browser checks on desktop/mobile.

## About implementation notes

- The hero uses `public/images/aboutpage/hero-about.png` with a deep-blue overlay, responsive background positioning, and a compact three-item trust row.
- The bilingual copy lives in `lang/fr/about.php` and `lang/en/about.php`; the view is `resources/views/pages/about.blade.php`.
- The page includes the mission/vision/values cards, the technician inspection checklist using `technician-about.png`, and the agencies/direction cards.
- The locations section intentionally omits the call button requested for agency cards elsewhere; only the action set shown in the About design is present.
- Section spacing was tightened across the About page to keep consecutive sections closer together.
- Coverage: `tests/Feature/AboutPageTest.php`, `tests/Feature/LocaleRoutingTest.php`, `php artisan test`, `npm run build`, and desktop/mobile browser checks.
