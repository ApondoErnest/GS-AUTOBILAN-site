# Security — V1

**Version:** 1.4 · **Steps:** S077–S079

## S077 status

- Completed 2026-07-29.
- Booking, tracking, and contact forms render the Spatie honeypot fields and submit through explicit spam-protection middleware.
- Booking and contact submissions are limited to five attempts per requester over fifteen minutes, with localized generic feedback for full-page and JSON/no-reload submissions.
- Tracking remains protected by the S070 failed-lookup limiter and now also uses honeypot spam protection before lookup throttling.
- Verification: `php artisan test tests/Feature/PublicFormSecurityTest.php`; `php artisan test tests/Feature/PublicFormSecurityTest.php tests/Feature/PublicBookingSubmitTest.php tests/Feature/ContactPageTest.php tests/Feature/TrackingPageTest.php tests/Feature/PublicFormRequestTest.php tests/Feature/LocaleRoutingTest.php tests/Feature/BilingualPublicPageReviewTest.php`; `php -d memory_limit=512M vendor/bin/pest`.

## S078 status

- Completed 2026-07-29.
- Admin image uploads for services, articles, gallery items, and testimonials now share one hardened FileUpload configuration.
- Accepted upload types are limited to JPEG, PNG, and WebP, with matching extension validation, a 2 MB maximum size, public-disk scoped directories, and server-generated UUID filenames.
- Key admin changes on agencies, services, bookings, document readiness, contact messages, articles, FAQs, gallery items, testimonials, settings, and staff users emit Spatie activity logs; tracked model changes are stored in `attribute_changes`, and user password fields are excluded from staff audit payloads.
- Verification: `php artisan test tests/Feature/AdminSecurityHardeningTest.php`; `php artisan test tests/Feature/AdminSecurityHardeningTest.php tests/Feature/FilamentAgencyServiceResourceTest.php tests/Feature/FilamentCommunicationContentResourceTest.php tests/Feature/FilamentBookingReadinessResourceTest.php tests/Feature/FilamentFinalAdminResourceTest.php tests/Feature/FilamentTariffResourceTest.php`; `php -d memory_limit=512M vendor/bin/pest`.

## S079 status

- Completed 2026-07-29.
- Added the local backup and restore runbook at [01-backup-restore-procedure.md](01-backup-restore-procedure.md), covering database, uploaded media, environment references, local SQLite backup/restore, and the future MySQL dump/restore shape for Docker/VPS.
- Added `scripts/backup-restore-smoke.sh` as a repeatable restore smoke test that uses a disposable SQLite database and temporary storage paths.
- Restore test result: `agencies=2`, `settings=3`, and the restored sample media file matched the backup.
- Verification: `bash -n scripts/backup-restore-smoke.sh`; `bash scripts/backup-restore-smoke.sh`.

## Public forms

CSRF · server-side validation · rate limiting · honeypot / spam protection · safe errors  

## Admin

Secure login · RBAC · protected routes · inactive user blocking · password reset control · audit logs  

## Tracking

Require reference + phone + plate · never plate-only · generic failure copy · five failed attempts per requester over fifteen minutes  

## Uploads

Validate type/size · store safely · block unsafe extensions · no exposed server paths  

## Backups

Local backup/restore runbook · disposable restore target first · database + public uploads · smoke-tested restore proof

**Acceptance:** Forms, admin, uploads, tracking, and customer data protected for V1.
