# Testing — V1

**Version:** 1.8 · **Steps:** S080–S085

## S080 status

- Completed 2026-07-29.
- Added the booking workflow smoke record at [01-booking-workflow-smoke.md](01-booking-workflow-smoke.md).
- Added `tests/Feature/BookingWorkflowSmokeTest.php` to exercise the happy path through the public booking POST route, Filament booking/document-readiness edit pages, and public tracking lookup.
- Verification result: `php artisan test tests/Feature/BookingWorkflowSmokeTest.php` passed with 1 test and 45 assertions.

## S081 status

- Completed 2026-07-29.
- Added the tracking security smoke record at [02-tracking-security-smoke.md](02-tracking-security-smoke.md).
- Added `tests/Feature/TrackingSecuritySmokeTest.php` to exercise wrong reference, wrong phone, wrong plate, generic failed lookup responses, privacy non-leakage, and the five-failure tracking limiter.
- Verification result: `php artisan test tests/Feature/TrackingSecuritySmokeTest.php` passed with 4 tests and 67 assertions.

## S082 status

- Completed 2026-07-29.
- Added the role isolation smoke record at [03-role-isolation-smoke.md](03-role-isolation-smoke.md).
- Added `tests/Feature/AgencyAdminRoleIsolationSmokeTest.php` to exercise assigned-agency scoping across Filament agency, booking, document readiness, contact-message, form-option, direct-edit URL, and dashboard metric surfaces.
- Verification result: `php artisan test tests/Feature/AgencyAdminRoleIsolationSmokeTest.php` passed with 2 tests and 49 assertions.

## S083 status

- Completed 2026-07-29; expanded during S086 after News was implemented.
- Added the bilingual responsive browser smoke record at [04-bilingual-responsive-browser-smoke.md](04-bilingual-responsive-browser-smoke.md).
- Added `tests/Feature/BilingualResponsiveBrowserSmokeTest.php` to guard FR/EN public-page rendering, viewport meta, mobile navigation hooks, language alternates, placeholder absence, and untranslated-key leakage for completed public pages.
- Browser verification covered 36 page/locale/viewport combinations at 390 × 844 and 1440 × 900, opened/closed the mobile menu, and found 0 console errors.
- Verification result: `php artisan test tests/Feature/BilingualResponsiveBrowserSmokeTest.php` now covers all 10 public pages after S064 News was implemented.
- S086 stabilization bundle result: `php artisan test tests/Feature/LocalStabilizationChecklistTest.php tests/Feature/NewsPageTest.php tests/Feature/AdminDashboardWidgetTest.php tests/Feature/BookingWorkflowSmokeTest.php tests/Feature/TrackingSecuritySmokeTest.php tests/Feature/AgencyAdminRoleIsolationSmokeTest.php tests/Feature/CriticalWorkflowPestCoverageTest.php tests/Feature/PublicFormRequestTest.php tests/Feature/PublicFormSecurityTest.php tests/Feature/PublicContactContentVerificationTest.php tests/Feature/BilingualPublicPageReviewTest.php tests/Feature/BilingualResponsiveBrowserSmokeTest.php tests/Feature/PublicSeoMetadataTest.php tests/Feature/PublicSeoInfrastructureTest.php` passed with 52 tests and 1,345 assertions.

## S084 status

- Completed 2026-07-29.
- Added the critical workflow Pest coverage record at [05-critical-workflow-pest-coverage.md](05-critical-workflow-pest-coverage.md).
- Added `tests/Feature/CriticalWorkflowPestCoverageTest.php` to guard booking reference uniqueness under sequence drift, public tracking success/failure through the service and route, and booking/document-readiness authorization by staff role and agency scope.
- Verification result: `php artisan test tests/Feature/CriticalWorkflowPestCoverageTest.php` passed with 3 tests and 46 assertions.

## S085 status

- Completed 2026-07-29.
- Added the public contact content verification record at [06-public-contact-content-verification.md](06-public-contact-content-verification.md).
- Corrected public contact-page agency emails, Direction Générale address/BP/phone/email links, footer secondary phone prefixes, compact Obili Sunday hours, and the French slogan punctuation against confirmed company data. The Direction Générale email set now includes `gsautosbilan@gmail.com` and `admin@gsautobilan.com`.
- Added `tests/Feature/PublicContactContentVerificationTest.php` to guard public contact translation sources, rendered FR/EN contact pages, and seeded agency/settings contact data.
- Verification result: `php artisan test tests/Feature/PublicContactContentVerificationTest.php` passed with 4 tests and 104 assertions.

## Functional

Navigation · language · agencies · services · tariffs · booking · reference · admin booking · tracking · contact · FAQ · articles · gallery · testimonials  

## Admin roles

Super Admin · Agency Admin · Content Manager · agency restrictions · document readiness · tariffs · publishing · users  

## Booking workflow

Submit → reference → admin sees → status change → tracking correct  

## Tracking security

Correct combo · wrong phone/plate/ref · repeated failures · no leakage  

## Bilingual / responsive / browsers

All pages FR+EN · Android/iPhone/tablet/desktop · Chrome/Safari/Firefox  

## Content

Phones · email · addresses · GPS · hours · holidays · DG · slogan · tariffs  

## Pest (automated)

Reference uniqueness · tracking success/failure · role authorization  

**Acceptance:** Critical workflows pass; content verified.
