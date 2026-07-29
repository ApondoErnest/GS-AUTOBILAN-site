# Bilingual Responsive Browser Smoke

**Step:** S083
**Scope:** FR/EN public pages across mobile and desktop browser viewports
**Last tested:** 2026-07-29

This smoke verifies the completed public pages in French and English with a real browser viewport pass plus a repeatable Pest guard. The original browser pass covered the nine completed public pages before S064; the repeatable Pest guard now includes News after the S064 implementation.

## Scenario

- Pages: Home, About, Agencies, Services, Tariffs, Visite Technique, Booking, Tracking, News, Contact.
- Locales: French and English.
- Browser viewports:
  - Mobile: 390 × 844.
  - Desktop: 1440 × 900.
- Browser database: temporary SQLite database migrated and seeded from `BaseDataSeeder`.

## Browser Checklist

1. Start the app with a migrated/seeded temporary SQLite database.
2. Open each completed public page in French and English.
3. Check each page at mobile and desktop viewport sizes.
4. Confirm the document `lang` matches the route locale.
5. Confirm expected localized copy is visible.
6. Confirm the viewport meta tag is present.
7. Confirm no untranslated translation-key strings are visible.
8. Confirm no placeholder shell text is visible.
9. Confirm no horizontal document overflow is present.
10. Confirm the mobile menu button is visible on mobile.
11. Open and close the mobile menu.
12. Confirm the browser console has no error logs.

## Repeatable Local Verification

Run:

```bash
php artisan test tests/Feature/BilingualResponsiveBrowserSmokeTest.php
```

2026-07-29 S086 result:

```text
Tests: 10 passed
```

## Browser Result

2026-07-29 in-app browser result:

```text
Checked: 36 page/locale/viewport combinations
Failures: 0
Mobile menu: opened and closed
Console errors: 0
```

The browser result predates S064 News. The repeatable Pest guard above is the current all-public-pages check.

## Acceptance

- Completed public pages render in FR and EN.
- Mobile and desktop viewport checks pass without horizontal overflow.
- Mobile navigation opens and closes.
- No visible untranslated keys or placeholder shell copy.
- Browser console remains clean during the smoke pass.
