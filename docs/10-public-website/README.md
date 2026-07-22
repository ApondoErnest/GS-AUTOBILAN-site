# Public website implementation — V1

**Steps:** S056–S065 · **Status:** S056–S061 and S065 complete; S062 next · Sitemap: [../01-project-documentation/03-sitemap.md](../01-project-documentation/03-sitemap.md)

---

## Build order

1. Home · 2. Agencies · 3. Booking shell · 4. Tracking shell · 5. Services · 6. Tariffs · 7. Visite Technique · 8. Contact + FAQ · 9. News · 10. About  

S065 About was completed early by user direction; continue the remaining public build from S062 Visite Technique page.

*(Chrome: navy+red strip · white header · banded footer — Block F / S031.)*

---

## Current status

| Step | Page | Status | Notes |
|------|------|--------|-------|
| S056 | Home | Complete | Implemented in `resources/views/pages/home.blade.php` with FR/EN translations and homepage assets under `public/images/homepage/`. |
| S057 | Agencies | Complete | Implemented in `resources/views/pages/agencies.blade.php` with FR/EN translations, `public/images/agencies/hero-agencies.png`, live Google map embeds, map overlays/zoom controls, WhatsApp + booking actions, and focused page/language-switch tests. |
| S058 | Booking shell | Complete | Implemented in `resources/views/pages/booking.blade.php` with FR/EN translations, compact expectation hero, non-auto-confirmation notice, progressive booking command center, live ticket summary, custom calendar UI, and focused feature tests. Backend submit logic remains in Block K. |
| S059 | Tracking shell | Complete | Implemented in `resources/views/pages/tracking.blade.php` with FR/EN translations, compact clarity hero, secure lookup card, static concierge result state, mobile two-column detail tiles, and focused feature tests. Real lookup logic remains in Block L. |
| S060 | Services | Complete | Implemented in `resources/views/pages/services.blade.php` with FR/EN translations, centered compact photo hero, core service cards, vehicle profile selector, contextual vehicle panels, eight technical-control cards, decision gate, final action card, services page assets, and focused feature tests. |
| S061 | Tariffs | Complete | Implemented in `resources/views/pages/tariffs.blade.php` with FR/EN translations, compact authority hero, official tariff navigator, price passport panels, matrix search/filter controls, desktop table, mobile tariff cards, print/download/share/reset hooks, clarification tiles, supplied tariff images, and focused feature tests. |
| S065 | About | Complete (built early) | Implemented in `resources/views/pages/about.blade.php` with FR/EN translations, `public/images/aboutpage/hero-about.png`, `technician-about.png`, and focused page/language-switch tests. |

---

## Page checklists

| Page | Must include |
|------|----------------|
| Home | Complete: photo carousel hero (blue overlay) · trust row · agencies teaser · inspection/services preview · booking/tracking CTAs · tariff preview · why GS · agency gallery · advice/news cards · final readiness CTA · red/white/blue ribbon and compact section rhythm |
| Agencies | Complete: centered photo hero · compact trust row · two agency cards · hours/phone info · live Google maps with info overlays and zoom controls · WhatsApp + book actions only · FR/EN |
| Booking | Complete shell: non-auto-confirm notice · form sections · live ticket · custom date picker · client-side success/receipt state; real persistence wired in Block K |
| Tracking | Complete shell: no-real-time tracking notice · secure lookup card · reference/phone/plate fields · static result/timeline/status/dossier/next-action panels; real lookup wired in Block L |
| Services | Complete: centered compact photo hero · three core service cards · vehicle profile selector · contextual vehicle panel · eight technical-control cards · decision gate · booking/tariff CTAs · FR/EN |
| Tariffs | Complete: compact authority hero · official category navigator · price passports · searchable/filterable matrix · mobile cards · print/download/share/reset hooks · clarification tiles · booking category links · FR/EN |
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
- The home agency teaser uses `agency-1.png` and `agency-2.png`; the full Agencies page final action set is WhatsApp + booking, with map interaction handled by the live embedded map.
- The inspection preview includes the controlled points grid and the six-step process; step 04 is **Contrôle Technique**.
- The tariff preview uses the supplied category list and prices, plus the why-choose list and gallery images `agence-3.png` through `agence-6.png`.
- The advice/readiness block uses `prepare-visit.png`, `necessary-docs.png`, `case-cv.png`, and `agence-6.png`; the right CTA keeps only the title plus two checklist columns.
- Section padding was tightened to `py-9 sm:py-10 lg:py-12` so homepage sections do not feel too far apart.
- Coverage: `tests/Feature/HomepageHeroTest.php`, `npm run build`, and browser checks on desktop/mobile.

## Agencies implementation notes

- The hero uses `public/images/agencies/hero-agencies.png` with a light navy overlay, centered copy, compact mobile height, and responsive background zoom.
- The bilingual copy lives in `lang/fr/agencies.php` and `lang/en/agencies.php`; the view is `resources/views/pages/agencies.blade.php`.
- The page includes two agency cards for Nkolbisson and Obili Scalom, using confirmed addresses, hours, phone text, GPS coordinates, and WhatsApp links.
- Each agency card embeds a live Google map iframe with a visible information overlay (`Agrandir le plan` / `Open larger map`) and functional `+ / -` zoom controls wired in `resources/js/app.js`.
- The final agency-card actions intentionally omit call and directions buttons; only WhatsApp and booking remain.
- Coverage: `tests/Feature/AgenciesPageTest.php`, `tests/Feature/LocaleRoutingTest.php`, `npm run build`, and desktop/mobile browser checks.

## Booking shell implementation notes

- The bilingual copy lives in `lang/fr/booking.php` and `lang/en/booking.php`; the view is `resources/views/pages/booking.blade.php`.
- Routes now point `/fr/rendez-vous` and `/en/booking` to the booking page shell.
- The hero is intentionally compact, uses the GS blue gradient, and keeps the transparency notice prominent without implying confirmed availability.
- The command center uses a sticky live-ticket sidebar on desktop and a mobile summary drawer; unfilled fields show the localized empty state until selected.
- Step 1 covers agency and service selection, including four service cards: periodic technical inspection, re-inspection, document verification, and information/guidance.
- Step 2 covers vehicle category selection with distinct neutral SVG vehicle icons and accessible vehicle detail fields.
- Step 3 covers preferred date, preferred period, identity/contact fields, review, and the required acknowledgement that an agent must confirm the request.
- The date field uses a branded custom calendar instead of the native browser calendar. It prevents past dates, marks Nkolbisson Sundays unavailable, and keeps Obili Scalom Sunday periods at the shorter published hours.
- The virtual receipt and generated reference shown after submit are client-side shell behavior only. Actual booking creation, persisted references, notifications, and document-readiness creation remain Block K.
- Coverage: `tests/Feature/BookingPageTest.php`, `tests/Feature/LocaleRoutingTest.php`, `npm run build`, `node --check resources/js/app.js`, and PHP syntax checks for the booking locale files.

## Tracking shell implementation notes

- The bilingual copy lives in `lang/fr/tracking.php` and `lang/en/tracking.php`; the view is `resources/views/pages/tracking.blade.php`.
- Routes now point `/fr/suivi-rendez-vous` and `/en/appointment-tracking` to the tracking page shell.
- The hero is intentionally compact, uses the GS blue gradient, and clearly states that the page does not track a vehicle in real time on the inspection line.
- The lookup card uses reference, phone/WhatsApp number, and registration fields, plus help and recovery links.
- The static result state mirrors the final concierge structure: four-step timeline, confirmed status, key appointment details, dossier readiness, and next action.
- Mobile result details intentionally use two-column tiles instead of a long plain stack.
- This is shell behavior only. Real lookup, loading, not-found, persisted status, and error states from `TrackingService` remain Block L.
- Coverage: `tests/Feature/TrackingPageTest.php`, `tests/Feature/LocaleRoutingTest.php`, `npm run build`, and PHP syntax checks for the tracking locale files.

## Services implementation notes

- The bilingual copy lives in `lang/fr/services.php` and `lang/en/services.php`; the view is `resources/views/pages/services.blade.php`.
- Routes now point `/fr/services` and `/en/services` to the services page.
- The hero uses `public/images/servicespage/services-hero.png` with a deep-blue overlay, centered content, a red `NOS SERVICES` label, compact height, focus chips, and no hero CTAs.
- The service architecture starts with three core cards: periodic technical inspection, re-inspection, and orientation/preparation.
- The vehicle profile selector covers light vehicle, utility, taxi/transport, and heavy vehicle with compact contextual panels, document notes, centre availability, booking action, and the four supplied vehicle images.
- The technical matrix uses eight compact cards with custom line icons for braking, suspension, lighting, tyres, vehicle identification, visual inspection, alignment/ripage, and administrative coherence.
- The decision gate combines customer-intent routing with a deep-blue final action card for booking, preparation, agencies, and tariffs.
- Coverage: `tests/Feature/ServicesPageTest.php`, `npm run build`, and responsive implementation checks during the page build.

## Tariffs implementation notes

- The bilingual copy lives in `lang/fr/tariffs.php` and `lang/en/tariffs.php`; the view is `resources/views/pages/tariffs.blade.php`.
- Routes now point `/fr/tarifs` and `/en/tariffs` to the tariffs page.
- The hero uses the compact GS blue authority treatment with a centered red label, deep overlay, single-line desktop lead, and four proof points.
- The tariff data is currently public-page copy sourced from the referenced official tariff table: A 4 900 FCFA, B 17 900 FCFA, B1 15 500 FCFA, C < 3,5T 15 500 FCFA, C 19 080 FCFA, D poids lourds 26 235 FCFA, and D autres engins 41 750 FCFA. Reconfirm with GS AUTOBILAN before launch.
- The navigator includes six customer-facing categories, supplied images under `public/images/tariffs/`, price passport panels, effective date messaging, and booking links that pass `categorie=...`.
- The official matrix includes desktop table controls, mobile cards, live client-side filtering/search, and print/download/share/reset hooks. A dedicated database-backed PDF template remains the future parity target when tariff publication is wired end to end.
- Coverage: `tests/Feature/TariffsPageTest.php`, `npm run build`, and responsive implementation checks during the page build.

## About implementation notes

- The hero uses `public/images/aboutpage/hero-about.png` with a deep-blue overlay, responsive background positioning, and a compact three-item trust row.
- The bilingual copy lives in `lang/fr/about.php` and `lang/en/about.php`; the view is `resources/views/pages/about.blade.php`.
- The page includes the mission/vision/values cards, the technician inspection checklist using `technician-about.png`, and the agencies/direction cards.
- The locations section intentionally omits the call button requested for agency cards elsewhere; only the action set shown in the About design is present.
- Section spacing was tightened across the About page to keep consecutive sections closer together.
- Coverage: `tests/Feature/AboutPageTest.php`, `tests/Feature/LocaleRoutingTest.php`, `php artisan test`, `npm run build`, and desktop/mobile browser checks.
