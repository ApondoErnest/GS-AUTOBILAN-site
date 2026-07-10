# Technology stack — V1

**Project:** GS AUTOBILAN Official Website  
**Version:** 1.1 · **Status:** Locked for V1 · **Steps:** S018–S025  
**Related:** [README.md](README.md) · [../05-architecture/01-architecture-overview.md](../05-architecture/01-architecture-overview.md)

---

## 1. Recommended stack

**Laravel + Blade + Livewire + Alpine.js + Tailwind CSS + Filament + Heroicons**

| Layer | Choice | Why |
|-------|--------|-----|
| Backend | Laravel 11, PHP 8.2+ | Routing, auth, queues, ORM, mail, validation in one ecosystem |
| Database | **MySQL 8** | Simple, common Laravel hosting; PostgreSQL optional later |
| Public UI | Blade + Livewire 3 + Alpine.js | Reactive forms without a heavy SPA |
| Styling | Tailwind CSS + Vite | Fast custom UI; utility-first |
| Admin | Filament 3 | Resources, tables, forms, widgets quickly |
| Icons | Heroicons + custom SVG | UI + inspection-specific visuals |
| Maps | Leaflet + OpenStreetMap | No paid API key for V1 |
| Deploy | Local → Docker Compose → VPS | Progressive, controllable |

---

## 2. Backend capabilities used

- Eloquent ORM  
- Form Requests / validation  
- Authentication & authorization (policies)  
- Notifications & mail  
- Queues (prepared; lightly used in V1)  
- Scheduler (prepared for later)  

---

## 3. Frontend capabilities used

- Blade layouts and components  
- Livewire for booking, tracking, contact dynamics  
- Alpine.js for light UI (menus, accordions)  
- Vite asset bundling  
- Heroicons for standard UI  
- Custom SVG for braking, suspension, emissions, headlights, tyres, visual inspection, lane, chassis  

---

## 4. Admin capabilities used

- Filament panel at `/admin`  
- Resources, forms, tables, widgets  
- Relation managers where useful  
- Filament Shield + Spatie Permission for roles  
- Laravel policies for agency scoping  

---

## 5. Recommended packages

| Package | Purpose |
|---------|---------|
| Filament Shield + spatie/laravel-permission | Roles |
| spatie/laravel-activitylog | Audit trail |
| spatie/laravel-sitemap | Sitemap |
| spatie/laravel-medialibrary | Images |
| spatie/laravel-honeypot | Spam protection |
| barryvdh/laravel-dompdf | Tariff PDF |
| Laravel Pint + Pest | Style + tests |

---

## 6. Application defaults

| Setting | Value |
|---------|--------|
| `APP_LOCALE` | `fr` |
| `APP_FALLBACK_LOCALE` | `en` |
| `APP_TIMEZONE` | `Africa/Douala` |
| Local mail | Mailpit or `log` |
| Queue (local) | `sync` initially; Redis in Docker/production |

---

## 7. Why not a React/Vue SPA for V1?

The product needs SEO-friendly marketing pages, forms, and a strong admin — not a client-heavy SPA. Livewire keeps the stack unified in PHP/Laravel and is faster to deliver for this scope.

---

## 8. Database choice

**MySQL is sufficient for V1.** PostgreSQL remains an option if advanced reporting is required later; switching would be a deliberate migration, not a V1 requirement.
