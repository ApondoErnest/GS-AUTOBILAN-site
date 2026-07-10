# Functional requirements — V1

**Step S007** · Scope: [../01-project-documentation/02-scope.md](../01-project-documentation/02-scope.md)

## 1. Public website

Visitors must be able to:

| ID | Requirement |
|----|-------------|
| FR-P01 | View company information (About, slogan, mission/vision when published) |
| FR-P02 | View agency information (address, phones, hours, holiday policy, GPS) |
| FR-P03 | Get directions to each agency (map / map link) |
| FR-P04 | Call each agency (`tel:` links) |
| FR-P05 | Open WhatsApp to each agency (deep link with optional pre-filled message) |
| FR-P06 | View the list of services with short descriptions |
| FR-P07 | View tariffs by vehicle category (when official data published) |
| FR-P08 | Print or download tariffs (PDF) when data is available |
| FR-P09 | Learn about technical inspection (Visite Technique page) |
| FR-P10 | Submit a booking request with preferred agency, service, date, time |
| FR-P11 | Receive a unique booking reference after submission |
| FR-P12 | Understand that booking is not automatically confirmed |
| FR-P13 | Track booking status using reference + phone + plate |
| FR-P14 | Track document-readiness status on the same tracking result |
| FR-P15 | Submit a contact message (optionally linked to an agency) |
| FR-P16 | Read FAQs on the Contact page |
| FR-P17 | Read news/advice articles in the current language |
| FR-P18 | Switch language between French and English |
| FR-P19 | Use the site comfortably on a mobile phone |

---

## 2. Admin dashboard

The system must allow authorized admins to:

| ID | Requirement |
|----|-------------|
| FR-A01 | Log in securely to `/admin` |
| FR-A02 | View a dashboard with booking KPIs and alerts |
| FR-A03 | Manage agencies (details, hours, GPS, photos, active flag) |
| FR-A04 | Manage services (bilingual content, order, active flag) |
| FR-A05 | Manage tariffs (including placeholder flag and last updated) |
| FR-A06 | Manage bookings (status, confirmed datetime, internal/public notes) |
| FR-A07 | Manage document readiness linked to a booking |
| FR-A08 | Manage contact messages (status, assignment, notes) |
| FR-A09 | Manage articles (draft/publish/archive, SEO, bilingual) |
| FR-A10 | Manage FAQs (bilingual, order, active) |
| FR-A11 | Manage gallery images (captions, agency, category) |
| FR-A12 | Manage testimonials |
| FR-A13 | Manage users (role, assigned agency, active) — Super Admin |
| FR-A14 | Manage site settings (slogan, logo, footer, SEO defaults) — Super Admin |
| FR-A15 | See only their agency’s bookings/messages when role is Agency Admin |
| FR-A16 | Have important changes recorded in an audit log |

---

## 3. Booking module rules

| ID | Requirement |
|----|-------------|
| FR-B01 | Generate unique references in format `GS-YEAR-SEQUENCE` |
| FR-B02 | Create document-readiness record automatically on booking create |
| FR-B03 | Restrict booking statuses to the V1 enum only |
| FR-B04 | Reject preferred dates in the past |
| FR-B05 | Require phone; email optional but validated if present |
| FR-B06 | Notify admin of new bookings when mail is configured |

---

## 4. Tracking module rules

| ID | Requirement |
|----|-------------|
| FR-T01 | Require reference + phone + vehicle registration |
| FR-T02 | Return only public-safe fields |
| FR-T03 | Use a generic error when lookup fails |
| FR-T04 | Rate-limit lookup attempts |
| FR-T05 | Never expose internal notes or inspection-lane data |

---

## 5. Out of scope (not requirements for V1)

See [../01-project-documentation/06-v1-v2-boundary.md](../01-project-documentation/06-v1-v2-boundary.md). Anything listed there is **not** a V1 functional requirement.
