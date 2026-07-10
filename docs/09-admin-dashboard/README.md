# Admin dashboard design — V1

**Project:** GS AUTOBILAN Official Website  
**Version:** 1.1 · **Status:** Design complete (implement S048–S055)  
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

Use Filament 3 + Shield. Theme accents may follow brand blue `#0B3A75` where Filament theming allows. Keep navigation grouped (see companion docs).
