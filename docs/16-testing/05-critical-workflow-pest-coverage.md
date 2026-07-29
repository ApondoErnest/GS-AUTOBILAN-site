# Critical Workflow Pest Coverage

**Step:** S084
**Scope:** Reference uniqueness, public tracking, and staff authorization
**Last tested:** 2026-07-29

This automated Pest coverage consolidates the critical V1 checks that must keep passing locally and in CI before launch. It complements the S080-S083 smoke files by focusing on durable regression assertions rather than a manual browser pass.

## Scenario

- Reference uniqueness: booking references keep the `GS-{YEAR}-{SEQUENCE}` format and skip ahead when the stored sequence trails existing booking rows.
- Tracking: lookup requires the matching reference, phone number, and vehicle registration; normalized successful values render the public tracking result, while a wrong value redirects with a generic lookup error.
- Authorization: Super Admin keeps full access; assigned Agency Admin can manage only its own booking/document-readiness records; unassigned Agency Admin and Content Manager cannot manage booking operations.

## Repeatable Local Verification

Run:

```bash
php artisan test tests/Feature/CriticalWorkflowPestCoverageTest.php
```

2026-07-29 result:

```text
Tests: 3 passed (46 assertions)
```

## Acceptance

- Reference sequence drift cannot create duplicate generated references.
- Tracking success and failure are covered through both service and public route behavior.
- Booking and document-readiness authorization stays role- and agency-scoped.
- The S084 Pest file can run independently in CI/local test suites.
