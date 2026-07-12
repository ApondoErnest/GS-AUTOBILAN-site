# Module boundaries — V1

**Project:** GS AUTOBILAN Official Website  
**Status:** **Locked S027** (2026-07-11) — accepted for implementation  
**Related:** [01-architecture-overview.md](01-architecture-overview.md) · [03-permission-matrix.md](03-permission-matrix.md) · [../07-database/01-schema-overview.md](../07-database/01-schema-overview.md)

---

## 1. Rule

Each module owns **one responsibility**. Do not mix booking intake logic into tracking display, or inspection education into booking statuses.

When adding a feature, ask: “Which single module owns this?” If the answer is two modules, split the work or reject it for V1.

---

## 2. Module map

```mermaid
flowchart LR
  subgraph public [Public]
    BookingUI[Booking_UI]
    TrackingUI[Tracking_UI]
    ContactUI[Contact_UI]
    ContentUI[Content_pages]
  end
  subgraph modules [Domain_modules]
    Booking[Booking]
    DocReady[DocumentReadiness]
    Tracking[Tracking]
    Contact[Contact]
    Tariff[Tariff]
    Agency[Agency]
    Service[Service]
    Article[Article]
    FAQ[FAQ]
    Gallery[Gallery]
    Testimonial[Testimonial]
    Settings[Settings]
  end
  BookingUI --> Booking
  Booking --> DocReady
  TrackingUI --> Tracking
  Tracking --> Booking
  Tracking --> DocReady
  ContactUI --> Contact
  ContentUI --> Agency
  ContentUI --> Service
  ContentUI --> Tariff
  ContentUI --> Article
  ContentUI --> FAQ
```

---

## 3. Boundaries (strict)

| Module | Owns | Must not own | Primary tables |
|--------|------|--------------|----------------|
| **Booking** | Intake create, reference, booking status workflow, confirmed datetime, public/internal booking messages | Document checklist details beyond creating default readiness; inspection results | `bookings` |
| **DocumentReadiness** | Document status, missing info, next action, public readiness message | Changing booking status; lane/inspection results | `document_readiness` |
| **Tracking** | Public lookup orchestration; mapping DB → safe DTO | Writing bookings; exposing internal notes | read-only over Booking + DocReady |
| **Contact** | Contact form messages and their statuses | Bookings | `contact_messages` |
| **Tariff** | Price rows, placeholder flag, validity, PDF export data | Payments | `tariffs` |
| **Agency** | Agency profile, hours, geo, phones | Booking business rules | `agencies` |
| **Service** | Service catalogue | Pricing (tariffs module) | `services` |
| **Article / FAQ / Gallery / Testimonial** | CMS content | Operational booking data | `articles`, `faqs`, `gallery_items`, `testimonials` |
| **Settings** | Slogan, DG, logo, SEO defaults | Per-booking data | `settings` |
| **Users / Roles** | Admin accounts and permissions | Public customer accounts (none in V1) | `users` + Spatie roles/permissions |

---

## 4. Status ownership

| Status family | Owner module | Where shown publicly |
|---------------|--------------|----------------------|
| Booking statuses | Booking | Tracking result |
| Document statuses | DocumentReadiness | Tracking result |
| Contact statuses | Contact | Admin only |
| Article statuses | Article | News (published only) |
| Accepté / Suspendu / Refusé | **Neither** (educational copy on Visite Technique only) | Visite Technique page text — **not** booking/tracking enums |

---

## 5. Cross-module allowed interactions

| From | To | Allowed interaction |
|------|----|---------------------|
| Booking | DocumentReadiness | Create default row on booking create |
| Tracking | Booking + DocumentReadiness | Read for public DTO |
| Admin Filament | Booking / DocReady / Contact / CMS | Update via policies |
| Agency | Booking / Contact / Gallery | Foreign keys / filters |

**Not allowed:** Tracking writing bookings · Tariff owning payments · Visite Technique educational outcomes becoming booking statuses · any module calling lane/machine APIs.

---

## 6. Suggested code homes (implementation)

| Module | Suggested namespace / area |
|--------|---------------------------|
| Booking / Tracking / Contact / DocReady | `app/Services/…` + Livewire under `app/Livewire/` or `resources/views/components` |
| Agency / Service / Tariff / CMS | Eloquent models + Filament Resources |
| Users / Roles | `User` + Shield / Spatie Permission |
| Public UI shells | `resources/views/layouts`, `partials`, `components`, `pages` |

Exact folder layout is finalized in Blocks H–J; this table only locks **ownership**, not file paths.
