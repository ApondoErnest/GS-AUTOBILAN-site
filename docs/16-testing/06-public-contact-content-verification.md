# Public Contact Content Verification

**Step:** S085
**Scope:** Phones, addresses, hours, Direction Générale, emails, and slogan
**Last tested:** 2026-07-29

This verification compares the public contact surfaces against the confirmed company-data source of truth at [../01-project-documentation/00-company-data.md](../01-project-documentation/00-company-data.md). It covers translation-backed public pages plus seeded operational settings used by admin/runtime data.

## Confirmed Data Checked

- Slogan: `Votre sécurité, c’est notre métier.`
- Nkolbisson: Carrefour Onana, à côté de la station Ajaxx, venant de Dagobert; `+237 678 844 791 / +237 652 516 527`; Monday-Saturday `07h00-18h00`; public holidays open.
- Obili Scalom: Obili Scalom; `+237 678 844 791 / +237 658 473 182`; Monday-Saturday `07h00-19h00`; Sunday `07h00-15h00`; public holidays open.
- Direction Générale: Bastos, derrière Hôtel Le Diplomate; `BP 12525`; `+237 653 283 107`; `gsautosbilan@gmail.com`; `admin@gsautobilan.com`.

## Corrections Made

- Replaced stale public contact-page agency emails with `gsautosbilan@gmail.com`.
- Replaced stale Direction Générale phone, email, address, call link, and mail link on the contact page.
- Added the second Direction Générale email address `admin@gsautobilan.com` to the public Contact, Footer, and About surfaces.
- Added the Direction Générale BP line to the public contact card.
- Restored the `+237` prefix on secondary agency phone numbers in the footer.
- Added Obili Scalom Sunday hours to the compact public hours summary.
- Aligned the French slogan punctuation with the confirmed wording.

## Repeatable Local Verification

Run:

```bash
php artisan test tests/Feature/PublicContactContentVerificationTest.php
```

2026-07-29 result:

```text
Tests: 4 passed (110 assertions)
```

## Acceptance

- Public translations no longer contain stale agency/head-office emails or old Direction Générale phone numbers.
- Public contact page renders confirmed phones, addresses, hours, BP, emails, and slogan in FR/EN.
- Seeded agency/settings data matches confirmed company contact values.
