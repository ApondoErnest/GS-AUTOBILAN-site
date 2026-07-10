# Non-functional requirements — V1

**Project:** GS AUTOBILAN Official Website

---

## 1. Language and content

| ID | Requirement |
|----|-------------|
| NFR-01 | Fully bilingual public UI (French default, English secondary) |
| NFR-02 | Admin-managed content stored with `_fr` / `_en` fields where needed |
| NFR-03 | Manual language review before launch (avoid machine-only translation) |

## 2. Usability

| ID | Requirement |
|----|-------------|
| NFR-04 | Mobile-first design; primary target is smartphone users in Cameroon |
| NFR-05 | Call and WhatsApp actions easy to reach on mobile |
| NFR-06 | Forms usable with large touch targets (≈44px) |
| NFR-07 | Tariff table becomes cards on small screens |
| NFR-08 | Admin UI simple enough for non-technical staff |

## 3. Performance

| ID | Requirement |
|----|-------------|
| NFR-09 | Acceptable load time on typical mobile networks (incl. slower 3G) |
| NFR-10 | Optimized images (e.g. WebP), lazy loading where appropriate |
| NFR-11 | Minimal JavaScript; no heavy SPA for the public site |
| NFR-12 | Efficient database queries (avoid N+1 on listings) |

## 4. Security

| ID | Requirement |
|----|-------------|
| NFR-13 | HTTPS in production |
| NFR-14 | CSRF protection on forms |
| NFR-15 | Server-side validation |
| NFR-16 | Rate limiting on booking, tracking, and contact |
| NFR-17 | Spam protection (e.g. honeypot) on public forms |
| NFR-18 | Role-based access control for admin |
| NFR-19 | Secure file upload validation |
| NFR-20 | No public exposure of private customer data via tracking |

## 5. SEO and discoverability

| ID | Requirement |
|----|-------------|
| NFR-21 | Per-page SEO title and meta description (bilingual) |
| NFR-22 | Clean locale-prefixed URLs |
| NFR-23 | Sitemap and robots.txt (disallow `/admin`) |
| NFR-24 | Structured data for agencies (LocalBusiness) where appropriate |

## 6. Maintainability and operations

| ID | Requirement |
|----|-------------|
| NFR-25 | Content and tariffs manageable from admin without code changes |
| NFR-26 | Clear module boundaries for future developers |
| NFR-27 | Local development first; Dockerizable after stabilization |
| NFR-28 | Deployable on a VPS with backups and monitoring |
| NFR-29 | Timezone `Africa/Douala` |

## 7. Reliability

| ID | Requirement |
|----|-------------|
| NFR-30 | Daily database backup plan in production |
| NFR-31 | Application errors logged without exposing details to the public |
| NFR-32 | Soft launch with staff before public announcement |

---

## Suggestion

Prioritize **NFR-04** (mobile-first) and **NFR-20** (tracking privacy) during every UI and API review — they are the highest-risk quality attributes for this product in Cameroon.
