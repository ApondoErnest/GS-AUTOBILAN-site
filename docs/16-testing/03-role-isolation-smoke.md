# Role Isolation Smoke

**Step:** S082
**Scope:** Agency Admin assigned-agency isolation
**Last tested:** 2026-07-29

This smoke verifies that Agency Admin users only see records that belong to their assigned agency across the practical Filament admin surface.

## Scenario

- Role: Agency Admin.
- Assigned agency: GS AUTOBILAN Nkolbisson.
- Other agency: GS AUTOBILAN Obili Scalom.
- Scoped modules: agencies, bookings, document readiness, contact messages, and dashboard booking metrics.
- Unassigned Agency Admin users must not access scoped operational resources.

## Manual Checklist

1. Sign in as an Agency Admin assigned to Nkolbisson.
2. Open `/admin/agencies` and confirm only Nkolbisson is listed.
3. Open `/admin/bookings` and confirm only Nkolbisson bookings are listed.
4. Try opening an Obili booking edit URL directly and confirm it is unavailable.
5. Open `/admin/document-readiness` and confirm only readiness rows for Nkolbisson bookings are listed.
6. Try opening an Obili readiness edit URL directly and confirm it is unavailable.
7. Open `/admin/contact-messages` and confirm only Nkolbisson contact messages are listed.
8. Try opening Obili and unassigned contact-message edit URLs directly and confirm they are unavailable.
9. Confirm booking/contact agency selectors only offer the assigned agency.
10. Sign in as an Agency Admin without an assigned agency and confirm scoped operational resources are forbidden.

## Repeatable Local Verification

Run:

```bash
php artisan test tests/Feature/AgencyAdminRoleIsolationSmokeTest.php
```

2026-07-29 result:

```text
Tests: 2 passed (49 assertions)
```

## Acceptance

- Agency Admin resource queries return only assigned-agency records.
- Filament tables do not render other-agency or unassigned operational records.
- Direct edit URLs for other-agency records are unavailable.
- Scoped form select options do not include other agencies.
- Dashboard booking counts are limited to the assigned agency.
- Unassigned Agency Admin users cannot access scoped operational resources.
