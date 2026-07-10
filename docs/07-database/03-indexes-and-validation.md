# Indexes and validation rules — V1

**Project:** GS AUTOBILAN Official Website  
**Related:** [01-schema-overview.md](01-schema-overview.md)

---

## 1. Indexes

| Table | Index | Reason |
|-------|-------|--------|
| `bookings` | UNIQUE `reference` | Lookup + integrity |
| `bookings` | `phone` | Tracking match |
| `bookings` | `vehicle_registration` | Tracking match |
| `bookings` | `status` | Admin filters |
| `bookings` | `agency_id` | Agency scoping |
| `bookings` | `service_id` | Reporting |
| `bookings` | `(preferred_date)` | Calendar views |
| `document_readiness` | UNIQUE `booking_id` | One-to-one |
| `document_readiness` | `status` | Alerts widget |
| `contact_messages` | `status`, `agency_id` | Admin queues |
| `articles` | UNIQUE `slug_fr`, UNIQUE `slug_en` | Routing |
| `articles` | `status`, `published_at` | Listings |
| `services` | UNIQUE `slug_fr`, UNIQUE `slug_en` | Routing |
| `agencies` | UNIQUE `slug` | Routing |
| `tariffs` | `is_active`, `is_placeholder`, `sort_order` | Public table |
| `faqs` / `gallery_items` / `testimonials` | `is_active`, `sort_order` | Public display |
| `settings` | UNIQUE `key` | Fast lookup |
| `users` | UNIQUE `email` | Auth |

**Composite suggestion for tracking:** optional composite index `(reference, phone, vehicle_registration)` if explain plans show need after load testing.

---

## 2. Validation rules (application + DB)

| Rule | Enforcement |
|------|-------------|
| Booking reference unique | DB unique + service |
| Preferred date not in the past | Form Request |
| Agency exists and active | Form Request + FK |
| Service exists and active | Form Request + FK |
| Phone required on booking | Form Request |
| Email valid if present | Form Request |
| Vehicle registration required | Form Request |
| Tracking requires all three fields | Form Request |
| Contact: name + message + subject; phone or email | Form Request |
| Article slug unique per language | DB unique |
| Inactive records hidden on public site | Global scopes / queries |
| Tariff `is_placeholder` not shown as final price publicly (or labelled) | Query / UI rule |

---

## 3. Normalization notes

- Phones stored consistently (prefer digits with country code, strip spaces on compare).
- Vehicle registration normalized uppercase, strip spaces on compare for tracking.
- Do not store plaintext secrets in `settings`.

---

## 4. Soft deletes

**V1 recommendation:** no soft deletes on bookings/contacts initially (keep simple). Use statuses (`cancelled`, `spam`, `archived`) instead. Revisit in V2 if needed.
