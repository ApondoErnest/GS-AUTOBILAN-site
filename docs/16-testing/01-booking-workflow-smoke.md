# Booking Workflow Smoke

**Step:** S080
**Scope:** Public booking submit -> admin confirmation -> customer tracking
**Last tested:** 2026-07-29

This smoke verifies the V1 booking happy path with the same public routes and Filament admin pages staff use.

## Scenario

- Locale: French public flow.
- Agency: GS AUTOBILAN Nkolbisson.
- Service: Vehicules legers.
- Public customer submits a booking request with phone `+237699080000` and plate `CE080AB`.
- Assigned Agency Admin opens the new booking in `/admin/bookings`.
- Staff confirms appointment date/time and adds a public tracking message.
- Staff marks document readiness as ready for visit and adds public next-action copy.
- Customer tracks the booking with reference + phone + plate.

## Manual Checklist

1. Open `/fr/rendez-vous`.
2. Submit a complete booking form and confirm the generated reference is shown.
3. Sign in as an assigned Agency Admin.
4. Open `/admin/bookings` and confirm the new request is visible.
5. Edit the booking to set `confirmed`, confirmed date/time, public message, and internal notes.
6. Edit the booking document readiness to set `ready_for_visit`, next action, and public message.
7. Open `/fr/suivi-rendez-vous`.
8. Search with the generated reference, the submitted phone, and normalized plate.
9. Confirm the tracking result shows the appointment, document status, public messages, and summary PDF link.
10. Confirm the tracking result does not expose customer name, email, internal booking notes, or private document notes.

## Repeatable Local Verification

Run:

```bash
php artisan test tests/Feature/BookingWorkflowSmokeTest.php
```

2026-07-29 result:

```text
Tests: 1 passed (45 assertions)
```

## Acceptance

- Public booking creates a `GS-YEAR-SEQUENCE` reference.
- Admin can see and confirm the same request.
- Document readiness updates are saved by staff.
- Tracking lookup succeeds only with the matching reference, phone, and plate.
- Tracking shows public operational information and hides private/customer fields.
