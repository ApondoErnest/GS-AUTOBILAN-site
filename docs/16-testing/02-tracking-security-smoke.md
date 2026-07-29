# Tracking Security Smoke

**Step:** S081
**Scope:** Wrong tracking credentials + failed-lookup rate limit
**Last tested:** 2026-07-29

This smoke verifies that public tracking failures stay generic and that repeated failed lookups are throttled per requester.

## Scenario

- Locale: French public tracking flow.
- Existing booking reference: `GS-2026-081001`.
- Correct lookup credentials: reference `GS-2026-081001`, phone `+237699081000`, plate `CE081AB`.
- Failed lookup cases: wrong reference, wrong phone, and wrong plate.
- Requester limit: 5 failed tracking lookups per 15 minutes.

## Manual Checklist

1. Open `/fr/suivi-rendez-vous`.
2. Search with the correct reference but wrong phone.
3. Confirm the page shows a generic no-match message and no tracking result.
4. Search with the correct reference and phone but wrong plate.
5. Confirm the page still shows a generic no-match message and no tracking result.
6. Confirm the failed result does not expose customer name, email, public appointment messages, internal booking notes, or private document notes.
7. Repeat failed lookups from the same requester until 5 failures are reached.
8. Submit one more failed lookup.
9. Confirm the throttled message appears and the response includes retry/rate-limit headers.
10. Confirm a successful lookup is still possible from a requester that is not rate-limited.

## Repeatable Local Verification

Run:

```bash
php artisan test tests/Feature/TrackingSecuritySmokeTest.php
```

2026-07-29 result:

```text
Tests: 4 passed (67 assertions)
```

## Acceptance

- Wrong reference, phone, or plate never returns a partial tracking result.
- Failed tracking responses stay generic.
- Private/customer/internal fields are not rendered on failed lookups.
- The sixth failed lookup from one requester is throttled.
- Rate-limit responses include retry metadata.
