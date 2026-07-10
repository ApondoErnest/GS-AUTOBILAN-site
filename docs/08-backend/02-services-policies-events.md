# Services, policies, and events — V1

**Version:** 1.1 · **Steps:** S041–S047

---

## 1. Service layer

| Service | Responsibilities |
|---------|------------------|
| **BookingService** | Create booking; initial status; create document readiness; confirmation message; notify; log |
| **BookingReferenceService** | Unique `GS-YEAR-SEQUENCE` (e.g. `GS-2026-000123`); prevent duplicates |
| **TrackingService** | Match ref+phone+plate; return safe public DTO; hide internal notes |
| **DocumentReadinessService** | Default status; updates; next-action copy; authorization-aware |
| **ContactMessageService** | Store; status; agency assign; notify; spam hooks |
| **ContentService** | Active bilingual content; homepage sections; translation fallback |
| **SEOService** | Title, description, OG, canonical, hreflang |
| **MediaService** | Validate uploads; store safely; replace |
| **AuditLogService** | Record sensitive admin actions (via activitylog) |

---

## 2. Policies

| Policy | Rules |
|--------|-------|
| AgencyPolicy | Super Admin all; Agency Admin read/own as defined |
| BookingPolicy | Super Admin all; Agency Admin own agency; Content Manager none |
| DocumentReadinessPolicy | Same agency scoping as booking |
| ContentPolicy | Super Admin + Content Manager for articles/FAQs/gallery/testimonials |
| TariffPolicy | Super Admin only; audited |
| UserPolicy | Super Admin only |

---

## 3. Events

| Event | Typical listeners |
|-------|-------------------|
| BookingCreated | Admin mail · activity log |
| BookingStatusUpdated | Activity log · optional customer mail |
| DocumentReadinessUpdated | Activity log |
| ContactMessageCreated | Admin mail |
| ArticlePublished | Sitemap refresh (later) |
| TariffUpdated | Activity log |

---

## 4. Jobs / queues (V1)

Prepare queue worker; use for:

- Admin booking notification  
- Admin contact notification  
- Optional customer confirmation email  

Do not block HTTP on slow mail in production.
