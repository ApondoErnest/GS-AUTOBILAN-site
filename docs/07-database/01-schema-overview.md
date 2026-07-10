# Database schema — V1 (full)

**Project:** GS AUTOBILAN Official Website  
**Status:** Documented design (implement at steps S035–S039)  
**Related:** [01-schema-overview.md](01-schema-overview.md) · [02-er-diagram.md](02-er-diagram.md) · [03-indexes-and-validation.md](03-indexes-and-validation.md) · [04-seed-inventory.md](04-seed-inventory.md)

---

## 1. Design principles

- Simple for V1; expandable for V2
- Bilingual via `_fr` / `_en` columns (not a separate translations table in V1)
- No inspection-lane / machine result tables
- Manageable from Filament
- Customer PII only as needed for booking/contact

---

## 2. Entity list (15)

| # | Table | Purpose |
|---|-------|---------|
| 1 | `users` | Admin users |
| 2 | `agencies` | Nkolbisson, Obili Scalom |
| 3 | `settings` | Key/value site + DG settings |
| 4 | `services` | Public service catalogue |
| 5 | `tariffs` | Prices |
| 6 | `bookings` | Booking intake |
| 7 | `document_readiness` | 1:1 with booking |
| 8 | `contact_messages` | Contact form |
| 9 | `article_categories` | News categories |
| 10 | `articles` | News & advice |
| 11 | `faqs` | Contact FAQ |
| 12 | `gallery_items` | Photos |
| 13 | `testimonials` | Quotes |
| 14 | `activity_log` | Spatie package table |
| 15 | `roles` / `permissions` / pivots | Spatie Permission (package) |

> Media files may use `media` table from spatie/laravel-medialibrary (additional package table).

---

## 3. Field definitions

### 3.1 `users`

| Column | Type | Notes |
|--------|------|-------|
| id | bigint PK | |
| name | string | |
| email | string unique | |
| password | string | hashed |
| assigned_agency_id | FK nullable | Agency Admin |
| is_active | boolean | default true |
| last_login_at | timestamp nullable | |
| remember_token | string nullable | |
| timestamps | | |

Roles via Spatie (`model_has_roles`), not a single `role` string column (preferred).

### 3.2 `agencies`

| Column | Type | Notes |
|--------|------|-------|
| id | bigint PK | |
| name_fr / name_en | string | |
| slug | string unique | |
| address_fr / address_en | text | |
| city | string nullable | e.g. Yaoundé |
| quarter | string nullable | |
| phones | json | array of E.164-ish strings |
| whatsapp | string nullable | |
| email | string | |
| opening_hours_fr / opening_hours_en | json or text | structured preferred |
| latitude / longitude | decimal | |
| map_link | string nullable | |
| status | string | e.g. operational |
| sort_order | int | |
| description_fr / description_en | text nullable | |
| is_active | boolean | |
| timestamps | | |

### 3.3 `settings`

| Column | Type | Notes |
|--------|------|-------|
| id | bigint PK | |
| key | string unique | e.g. `direction_generale`, `slogan`, `seo_defaults` |
| value | json | flexible payload |
| timestamps | | |

**Direction Générale** stored under settings (address, BP, phone, email) — not a separate table required for V1.

### 3.4 `services`

| Column | Type | Notes |
|--------|------|-------|
| id | bigint PK | |
| title_fr / title_en | string | |
| slug_fr / slug_en | string unique each | |
| short_description_fr / en | text | |
| full_description_fr / en | text nullable | |
| icon | string nullable | heroicon or path |
| image | string nullable | or media library |
| sort_order | int | |
| is_active | boolean | |
| timestamps | | |

### 3.5 `tariffs`

| Column | Type | Notes |
|--------|------|-------|
| id | bigint PK | |
| category | string | |
| vehicle_type_fr / vehicle_type_en | string | |
| price | decimal(12,2) nullable | null if placeholder |
| currency | string | default `XAF` |
| validity | string nullable | |
| notes_fr / notes_en | text nullable | |
| sort_order | int | |
| is_active | boolean | |
| is_placeholder | boolean | **true until official prices** |
| last_updated_at | timestamp nullable | |
| timestamps | | |

### 3.6 `bookings`

| Column | Type | Notes |
|--------|------|-------|
| id | bigint PK | |
| reference | string unique | `GS-2026-000123` |
| customer_name | string | |
| phone | string | |
| whatsapp | string nullable | |
| email | string nullable | |
| agency_id | FK | |
| service_id | FK | |
| vehicle_registration | string | |
| vehicle_type | string nullable | |
| vehicle_category | string nullable | |
| vehicle_brand_model | string nullable | |
| preferred_date | date | |
| preferred_time_slot | string | |
| confirmed_date | date nullable | |
| confirmed_time_slot | string nullable | |
| status | string/enum | see enums |
| customer_message | text nullable | |
| internal_notes | text nullable | admin only |
| public_message | text nullable | tracking |
| timestamps | | |

### 3.7 `document_readiness`

| Column | Type | Notes |
|--------|------|-------|
| id | bigint PK | |
| booking_id | FK unique | one-to-one |
| status | string/enum | |
| missing_information_note | text nullable | |
| next_action_fr / next_action_en | text nullable | |
| public_message_fr / public_message_en | text nullable | |
| updated_by | FK users nullable | |
| timestamps | | |

### 3.8 `contact_messages`

| Column | Type | Notes |
|--------|------|-------|
| id | bigint PK | |
| name | string | |
| phone | string nullable | |
| email | string nullable | |
| agency_id | FK nullable | |
| subject | string | |
| message | text | |
| status | string/enum | |
| assigned_user_id | FK nullable | |
| internal_notes | text nullable | |
| timestamps | | |

### 3.9 `article_categories`

| Column | Type | Notes |
|--------|------|-------|
| id | bigint PK | |
| name_fr / name_en | string | |
| slug_fr / slug_en | string unique each | |
| sort_order | int | |
| is_active | boolean | |
| timestamps | | |

### 3.10 `articles`

| Column | Type | Notes |
|--------|------|-------|
| id | bigint PK | |
| category_id | FK nullable | |
| title_fr / title_en | string | |
| slug_fr / slug_en | string unique each | |
| summary_fr / summary_en | text nullable | |
| content_fr / content_en | longText | |
| featured_image | string nullable | |
| status | string/enum | draft/published/archived |
| published_at | timestamp nullable | |
| meta_title_fr / en | string nullable | |
| meta_description_fr / en | text nullable | |
| timestamps | | |

### 3.11 `faqs`

| Column | Type | Notes |
|--------|------|-------|
| id | bigint PK | |
| question_fr / question_en | text | |
| answer_fr / answer_en | text | |
| sort_order | int | |
| is_active | boolean | |
| timestamps | | |

### 3.12 `gallery_items`

| Column | Type | Notes |
|--------|------|-------|
| id | bigint PK | |
| caption_fr / caption_en | string nullable | |
| agency_id | FK nullable | |
| category | string | exterior, reception, lane, staff, equipment, customer_area |
| image_path | string | or media library |
| sort_order | int | |
| is_active | boolean | |
| timestamps | | |

### 3.13 `testimonials`

| Column | Type | Notes |
|--------|------|-------|
| id | bigint PK | |
| customer_name | string | |
| customer_type_fr / customer_type_en | string nullable | |
| message_fr / message_en | text | |
| rating | tinyint nullable | 1–5 |
| image_path | string nullable | |
| sort_order | int | |
| is_active | boolean | |
| timestamps | | |

---

## 4. Enums (locked for V1)

### Booking status

`new_request` · `pending_confirmation` · `confirmed` · `rescheduled` · `cancelled` · `completed` · `no_show`

### Document readiness status

`not_reviewed` · `complete` · `missing_info` · `contact_agency` · `ready_for_visit`

### Contact status

`new` · `in_review` · `responded` · `closed` · `spam`

### Article status

`draft` · `published` · `archived`

### Gallery category

`agency_exterior` · `reception` · `inspection_lane` · `staff` · `equipment` · `customer_area`

---

## 5. Booking reference

- Format: `GS-{YEAR}-{SEQUENCE}`  
- Example: `GS-2026-000123`  
- Unique index on `bookings.reference`  
- Generated by `BookingReferenceService` (atomic sequence)

---

## 6. Explicitly out of schema (V1)

Do **not** create tables/columns for:

- Lane position / machine results  
- Certificate numbers / QR payloads  
- Online payments  
- Customer accounts / passwords for public users  
- Fleet vehicle inventories  

---

## 7. Implementation steps

See [../STEPS.md](../STEPS.md): **S035–S039**.
