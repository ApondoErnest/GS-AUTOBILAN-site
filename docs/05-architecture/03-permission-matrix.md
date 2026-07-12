# Permission matrix — V1

**Step S028** · **Status:** Confirmed 2026-07-11 for Filament Shield / Spatie Permission  
**Role narratives:** [../02-requirements/03-roles-and-journeys.md](../02-requirements/03-roles-and-journeys.md)  
**Module boundaries:** [02-module-boundaries.md](02-module-boundaries.md)

**Roles (system):** Super Admin · Agency Admin · Content Manager  
**Public:** no admin login. Reception staff use Agency Admin (or shared desk account) — not a fourth role.

**Spatie / Shield role names (locked):** `super_admin` · `agency_admin` · `content_manager`

---

## Matrix

| Module | Super Admin | Agency Admin | Content Manager |
|--------|:-----------:|:------------:|:---------------:|
| Dashboard (all agencies) | ✓ | — | — |
| Dashboard (own agency) | ✓ | ✓ | — |
| Agencies | ✓ full | read own | — |
| Services | ✓ | — | ✓ |
| Tariffs | ✓ | — | — |
| Bookings | ✓ | own agency | — |
| Document readiness | ✓ | own agency | — |
| Contact messages | ✓ | own agency | — |
| Articles | ✓ | — | ✓ |
| FAQs | ✓ | — | ✓ |
| Gallery | ✓ | — | ✓ |
| Testimonials | ✓ | — | ✓ |
| Editable page content | ✓ | — | ✓ |
| Users | ✓ | — | — |
| Site settings | ✓ | — | — |
| Audit log view | ✓ | limited own actions optional | — |
| Roles / Shield config | ✓ | — | — |

---

## Policy mapping

| Policy | Rule |
|--------|------|
| `AgencyPolicy` | Super Admin all; Agency Admin view own (`assigned_agency_id`) |
| `BookingPolicy` | Super Admin all; Agency Admin where `agency_id` matches; Content Manager deny |
| `DocumentReadinessPolicy` | Same scoping as booking’s agency |
| `ContactMessagePolicy` | Super Admin all; Agency Admin own agency |
| `ContentPolicy` | Super Admin + Content Manager for articles/FAQs/gallery/testimonials/page content |
| `ServicePolicy` | Super Admin + Content Manager; Agency Admin deny |
| `TariffPolicy` | Super Admin only; changes audited |
| `UserPolicy` | Super Admin only |
| `SettingsPolicy` | Super Admin only |

Agency scoping: Agency Admin queries **must** filter by `assigned_agency_id` / booking `agency_id`. Never rely on UI hiding alone.

---

## Public vs private data

| Data | Public | Admin |
|------|--------|-------|
| Booking internal notes | Never | Yes |
| Booking public message | Tracking | Yes |
| Document next action | Tracking | Yes |
| Customer phone/email | Never on tracking beyond auth match | Yes |
| Inspection results | Never as live status | N/A in V1 |

---

## Shield setup notes (Block I)

1. Run Shield install / generate permissions from Filament resources when resources exist (S048+).
2. Seed the three roles; assign first user `super_admin` (`admin@gsautobilan.local`).
3. Enforce `canAccessPanel` + role checks; tighten `User::canAccessPanel` beyond “any authenticated” before production.
4. Tariff and user changes → activity log.

**Confirmed S028:** matrix matches requirements journeys and module boundaries; ready for Filament Shield implementation.
