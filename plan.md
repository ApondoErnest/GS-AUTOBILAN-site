# GS AUTOBILAN — Master technical plan (V1)

**Type:** Technical roadmap (no code) · **Version:** 1.8 · **Updated:** 2026-07-22
**Slogan:** Votre sécurité, c’est notre métier.

**Execute:** [docs/STEPS.md](docs/STEPS.md) one step at a time (S001→S096). First unchecked: **S062**.
**Company data:** [docs/01-project-documentation/00-company-data.md](docs/01-project-documentation/00-company-data.md)

---

## 1. Summary

| Item | Value |
|------|--------|
| Product | GS AUTOBILAN Official Website |
| Agencies | Nkolbisson · Obili Scalom |
| Languages | French (default) · English |
| Stack | Laravel · Blade · Livewire · Alpine.js · Tailwind · Filament · Heroicons · MySQL 8 |
| Path | Local → stabilize → Docker → VPS |
| Timezone | Africa/Douala |

**Goal:** Professional bilingual site + admin + booking intake + appointment/document tracking.

---

## 2. V1 principles (locked)

| Topic | Rule |
|-------|------|
| Booking | Digital **intake** — staff confirm by phone/WhatsApp |
| Tracking | Appointment + document readiness only |
| Never in V1 | Lane/machine status · live Accepté/Suspendu/Refusé as booking status |
| FAQ | Section on Contact (not a separate page) |
| Visite Technique | Procedure + preparation merged |
| Reference | `GS-{YEAR}-{SEQUENCE}` |

Boundary: [docs/01-project-documentation/06-v1-v2-boundary.md](docs/01-project-documentation/06-v1-v2-boundary.md)

---

## 3. Stack

**Laravel + Blade + Livewire + Alpine.js + Tailwind CSS + Filament + Heroicons + MySQL**

Rationale: [docs/04-laravel-setup/01-technology-stack.md](docs/04-laravel-setup/01-technology-stack.md)

---

## 4. Scope snapshot

**Public:** Home · About · Agencies · Services · Tariffs · Visite Technique · Booking · Tracking · News · Contact (+ FAQ)  

**Admin:** Dashboard · agencies · services · tariffs · bookings · document readiness · contacts · articles · FAQs · gallery · testimonials · users · settings · audit  

**Out:** Lane APIs · WhatsApp/SMS APIs · payment · customer/fleet portals · certificate/QR  

Detail: [docs/01-project-documentation/02-scope.md](docs/01-project-documentation/02-scope.md) · Sitemap: [03-sitemap.md](docs/01-project-documentation/03-sitemap.md)

---

## 5. Phases → steps

```
Docs → Requirements → Local → Laravel → Architecture → Frontend
→ Database → Backend → Admin → Public → Booking → Tracking
→ Bilingual → SEO → Security → Testing → Stabilize
→ Docker → VPS → Launch → Maintain
```

| Phase | Folder | Steps |
|------:|--------|-------|
| 1 Documentation | [docs/01-…](docs/01-project-documentation/) | S001–S006 ✓ |
| 2 Requirements | [docs/02-…](docs/02-requirements/) | S007–S009 ✓ |
| 3 Local | [docs/03-…](docs/03-local-environment/) | S010–S017 |
| 4 Laravel | [docs/04-…](docs/04-laravel-setup/) | S018–S025 |
| 5 Architecture | [docs/05-…](docs/05-architecture/) | S026–S028 |
| 6 Frontend design | [docs/06-…](docs/06-frontend-design/) | S029–S034 |
| 7 Database | [docs/07-…](docs/07-database/) | S035–S039 |
| 8 Backend | [docs/08-…](docs/08-backend/) | S040–S047 |
| 9 Admin | [docs/09-…](docs/09-admin-dashboard/) | S048–S055 |
| 10 Public site | [docs/10-…](docs/10-public-website/) | S056–S061 and S065 complete · S062–S064 remaining |
| 11 Booking | [docs/11-…](docs/11-booking-module/) | S066–S068 |
| 12 Tracking | [docs/12-…](docs/12-tracking-module/) | S069–S070 |
| 13 Bilingual | [docs/13-…](docs/13-bilingual/) | S071–S073 |
| 14 SEO | [docs/14-…](docs/14-seo-performance/) | S074–S076 |
| 15 Security | [docs/15-…](docs/15-security/) | S077–S079 |
| 16 Testing | [docs/16-…](docs/16-testing/) | S080–S085 |
| 17 Stabilize | [docs/17-…](docs/17-local-stabilization/) | S086 |
| 18 Docker | [docs/18-…](docs/18-docker/) | S087–S088 |
| 19 VPS | [docs/19-…](docs/19-vps-deployment/) | S089–S091 |
| 20 Launch | [docs/20-…](docs/20-launch/) | S092–S094 |
| 21 Maintenance | [docs/21-…](docs/21-maintenance/) | S095–S096 |

---

## 6. Workflows (summary)

**Booking:** submit → reference → admin review → phone/WhatsApp confirm → customer tracks  
**Tracking:** reference + phone + plate → appointment + document status  

Full: [docs/01-project-documentation/05-operational-workflows.md](docs/01-project-documentation/05-operational-workflows.md)

---

## 7. Risks

| Risk | Mitigation |
|------|------------|
| No official tariffs | Placeholders; block go-live until confirmed |
| No brand assets | Text logo / maps until assets arrive |
| Email spelling | Confirm before launch |
| Instant-booking expectation | Clear FR/EN messaging + FAQ |
| Tracking abuse | Triple check + rate limit |
| Scope creep | V1/V2 boundary + locked statuses |

---

## 8. Next

Open **[docs/STEPS.md](docs/STEPS.md)** → first unchecked step (**S062**).
