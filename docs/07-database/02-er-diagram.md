# Entity-relationship diagram — V1

**Project:** GS AUTOBILAN Official Website  
**Related:** [01-schema-overview.md](01-schema-overview.md)

---

## 1. ER diagram

```mermaid
erDiagram
  AGENCIES ||--o{ BOOKINGS : has
  SERVICES ||--o{ BOOKINGS : has
  BOOKINGS ||--|| DOCUMENT_READINESS : has
  USERS ||--o| AGENCIES : assigned_to
  USERS ||--o{ DOCUMENT_READINESS : updates
  AGENCIES ||--o{ CONTACT_MESSAGES : concerns
  USERS ||--o{ CONTACT_MESSAGES : assigned
  AGENCIES ||--o{ GALLERY_ITEMS : shows
  ARTICLE_CATEGORIES ||--o{ ARTICLES : groups

  AGENCIES {
    bigint id PK
    string slug UK
    string name_fr
    string name_en
    json phones
    decimal latitude
    decimal longitude
    boolean is_active
  }

  SERVICES {
    bigint id PK
    string slug_fr UK
    string slug_en UK
    string title_fr
    boolean is_active
  }

  USERS {
    bigint id PK
    string email UK
    bigint assigned_agency_id FK
    boolean is_active
  }

  BOOKINGS {
    bigint id PK
    string reference UK
    bigint agency_id FK
    bigint service_id FK
    string phone
    string vehicle_registration
    string status
    date preferred_date
  }

  DOCUMENT_READINESS {
    bigint id PK
    bigint booking_id FK_UK
    string status
    bigint updated_by FK
  }

  CONTACT_MESSAGES {
    bigint id PK
    bigint agency_id FK
    bigint assigned_user_id FK
    string status
  }

  TARIFFS {
    bigint id PK
    string category
    boolean is_placeholder
    decimal price
  }

  ARTICLE_CATEGORIES {
    bigint id PK
    string slug_fr UK
  }

  ARTICLES {
    bigint id PK
    bigint category_id FK
    string slug_fr UK
    string status
  }

  FAQS {
    bigint id PK
    int sort_order
    boolean is_active
  }

  GALLERY_ITEMS {
    bigint id PK
    bigint agency_id FK
    string category
  }

  TESTIMONIALS {
    bigint id PK
    boolean is_active
  }

  SETTINGS {
    bigint id PK
    string key UK
    json value
  }
```

---

## 2. Relationship rules

| Relationship | Cardinality | Notes |
|--------------|-------------|-------|
| Agency → Bookings | 1:N | Required on booking |
| Service → Bookings | 1:N | Required on booking |
| Booking → DocumentReadiness | 1:1 | Created with booking |
| User → Agency | N:1 optional | Agency Admin assignment |
| User → DocumentReadiness updates | 1:N | `updated_by` |
| Agency → ContactMessages | 1:N optional | |
| Agency → GalleryItems | 1:N optional | |
| ArticleCategory → Articles | 1:N optional | |

---

## 3. Public tracking join path

To resolve a tracking lookup:

1. Find `bookings` where `reference` + `phone` + `vehicle_registration` all match (normalize phone/plate).
2. Load `agency` and `document_readiness`.
3. Return DTO with public fields only (no `internal_notes`).

---

## 4. Suggestion

Keep `document_readiness` as a separate table (not only columns on `bookings`) so readiness updates can be audited cleanly via `updated_by` without overloading the booking row — matches the plan’s one-to-one design.
