# Permission matrix — V1

**Step S028** · Role narratives: [../02-requirements/03-roles-and-journeys.md](../02-requirements/03-roles-and-journeys.md)

**Roles:** Super Admin (all) · Agency Admin (`assigned_agency_id` only) · Content Manager (content; no bookings). Public users have no admin login.

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

---

## Policy mapping

| Policy | Rule |
|--------|------|
| `AgencyPolicy` | Super Admin all; Agency Admin view own |
| `BookingPolicy` | Super Admin all; Agency Admin where `agency_id` matches; Content Manager deny |
| `DocumentReadinessPolicy` | Same scoping as booking’s agency |
| `ContactMessagePolicy` | Super Admin all; Agency Admin own agency |
| `ContentPolicy` | Super Admin + Content Manager for articles/FAQs/gallery/testimonials |
| `TariffPolicy` | Super Admin only; changes audited |
| `UserPolicy` | Super Admin only |

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

Confirm against Filament Shield at **S028**.
