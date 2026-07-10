# Roles and user journeys — V1

**Project:** GS AUTOBILAN Official Website

---

## 1. Public roles

| Role | Description |
|------|-------------|
| Visitor | Browses information; may not book |
| Customer | Submits booking and/or tracking lookup |
| Company representative | May book for company vehicles; same forms in V1 (no fleet portal) |

---

## 2. Admin roles

| Role | Access summary |
|------|----------------|
| **Super Admin** | Full access: all agencies, bookings, content, tariffs, users, settings |
| **Agency Admin** | Own agency only: bookings, document readiness, contact messages; limited dashboard |
| **Content Manager** | Articles, FAQs, gallery, testimonials, editable page content; not bookings |

---

## 3. Permission matrix

| Module | Super Admin | Agency Admin | Content Manager |
|--------|:-----------:|:------------:|:---------------:|
| Dashboard (all agencies) | ✓ | — | — |
| Dashboard (own agency) | ✓ | ✓ | — |
| Agencies | ✓ | read own | — |
| Services | ✓ | — | ✓ |
| Tariffs | ✓ | — | — |
| Bookings | ✓ | own agency | — |
| Document readiness | ✓ | own agency | — |
| Contact messages | ✓ | own agency | — |
| Articles / FAQs / Gallery / Testimonials | ✓ | — | ✓ |
| Editable page content | ✓ | — | ✓ |
| Users | ✓ | — | — |
| Site settings | ✓ | — | — |

---

## 4. User journeys

### 4.1 Customer booking journey

1. Customer visits the site (often on mobile).
2. Opens Booking page (or CTA from Home / Agency card).
3. Reads non-auto-confirm message.
4. Selects agency; enters vehicle and contact information.
5. Chooses preferred date/time; submits.
6. System generates reference (e.g. `GS-2026-000123`).
7. Staff reviews request in admin.
8. Staff confirms by phone or WhatsApp.
9. Customer tracks status online.

### 4.2 Appointment tracking journey

1. Customer opens tracking page.
2. Enters booking reference, phone number, vehicle registration.
3. System validates the combination.
4. System shows appointment and document status + next action.
5. Customer follows next action or contacts the agency.

### 4.3 Admin booking journey

1. Admin logs in.
2. Opens booking requests (filtered by agency if Agency Admin).
3. Reviews new request.
4. Contacts customer.
5. Updates status and confirmed datetime.
6. Updates public message / document readiness if needed.
7. Tracking page reflects the update.

### 4.4 Contact handling journey

1. Customer submits Contact form.
2. Message stored as New.
3. Admin reviews, assigns agency if needed, responds offline (phone/email/WhatsApp).
4. Marks Responded / Closed (or Spam).

### 4.5 Content publishing journey

1. Content Manager drafts article in FR (and EN).
2. Adds image, category, SEO.
3. Publishes after review.
4. Article appears on News (and optionally Home preview).

---

## 5. Suggestion — training note for staff

Before launch, prepare a one-page staff guide:

- How to confirm a booking in admin  
- What to say on the phone (“your online request is received; we are confirming availability”)  
- How to update document readiness  
- How customers track (reference + phone + plate)  

This reduces support confusion more than any extra feature.
