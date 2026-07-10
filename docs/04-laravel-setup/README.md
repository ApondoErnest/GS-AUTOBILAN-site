# Laravel setup — V1

**Version:** 1.1 · **Steps:** S018–S025  

## Documents

| File | Purpose |
|------|---------|
| [01-technology-stack.md](01-technology-stack.md) | Stack rationale, packages, defaults |

## Do this (in order) — see STEPS.md

1. Create Laravel app (preserve `docs/`, `brand/`, `design/`, `README.md`, `plan.md`)  
2. Configure `.env` (MySQL, `Africa/Douala`, `fr`/`en`, mail)  
3. App key + default migrations  
4. Livewire · Alpine · Tailwind · Vite  
5. Filament + first Super Admin (`/admin`)  
6. Install packages (Shield, activitylog, sitemap, medialibrary, honeypot, dompdf, Pint, Pest)  
7. Scaffold layout/component folders  
8. Confirm CSRF, auth, protected admin  

## Acceptance

App runs locally; admin accessible; database connected.
