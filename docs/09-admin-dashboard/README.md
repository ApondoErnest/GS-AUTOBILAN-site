# Admin dashboard design — V1

**Project:** GS AUTOBILAN Official Website  
**Version:** 1.5 · **Status:** S048-S051 implemented; continue S052  
**Related:** [01-navigation-and-widgets.md](01-navigation-and-widgets.md) · [02-admin-modules.md](02-admin-modules.md) · [../05-architecture/03-permission-matrix.md](../05-architecture/03-permission-matrix.md)

---

## 1. Objective

Design a private admin that is secure, simple for staff, role-based, fast, and focused on daily operations — separate from the public marketing site.

---

## 2. Principles

- Role-based access (Super Admin · Agency Admin · Content Manager)  
- Agency scoping for operational data  
- Clear status workflows (no free text)  
- Audit sensitive changes (tariffs, bookings, users)  
- Non-technical staff can work without developer help  

---

## 3. Acceptance

Authorized staff can manage all V1 website content and operational requests **without editing code**.

---

## 4. Implementation notes

Use Filament 5 + Shield. Theme accents may follow **GS Royal Blue** `#145DB3` (and navy `#062A5C`) where Filament theming allows. Keep navigation grouped (see companion docs).

**Implemented at S048:** Shield is registered on the admin panel, the built-in role resource is available under Users & Settings, the three GS staff roles are seedable/assignable, and only active users with one of those roles can enter `/admin`.

**Implemented at S049:** the admin panel has the documented navigation groups in stable order with role-aware section overview pages. Super Admin sees all groups; Agency Admin sees operational agency groups; Content Manager sees content and services groups.

**Implemented at S050:** the dashboard now shows booking KPI cards, bookings by agency, document-readiness alerts, new contact messages, published article pulse, and latest contact/article activity. Operational metrics are scoped to the Agency Admin's assigned agency.

**Implemented at S051:** Agencies and Services now have Filament resources with list/create/edit/delete flows. Agency Admin access is scoped to the assigned agency; services remain Super Admin / Content Manager managed.
