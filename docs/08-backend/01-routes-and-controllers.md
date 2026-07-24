# Routes and controllers — V1

**Version:** 1.2 · **Steps:** S040+

---

## 1. Language routes

- Prefixes: `/fr` · `/en`  
- Root `/` → `/fr/accueil`  
- Localized slugs where needed  

Examples: `/fr/rendez-vous` · `/en/booking` · `/fr/suivi-rendez-vous` · `/en/appointment-tracking`

---

## 2. Public routes

| Area | Routes |
|------|--------|
| Pages | home, about, agencies, services, tariffs, visite-technique, news list, article detail, contact |
| Booking | show form · submit |
| Tracking | show form · lookup |
| Contact | show · submit |
| Locale | language switch |

---

## 3. Admin routes

All under protected Filament `/admin`:

login · dashboard · agencies · services · tariffs · bookings · document readiness · articles · FAQs · gallery · testimonials · contact messages · users · settings

---

## 4. Controllers (thin)

| Group | Responsibility |
|-------|----------------|
| Page controllers | Load content; render views |
| Booking | Show form; validate; call BookingService; confirmation |
| Tracking | Show form; validate; call TrackingService; safe result/error |
| Contact | Page + FAQs; agency slug preselection; validate; store; success |
| Article | List; filter category; detail; locale slug |

Prefer Livewire components for booking/tracking/contact where it improves UX; keep service calls identical.

S063 implementation note: the public Contact form posts through `ContactMessageRequest` and `ContactMessageService`, accepts an agency slug from the page (`nkolbisson` / `obili-scalom`), resolves it to an active `Agency`, and stores the selected request type in the message subject context.

---

## 5. Models (required)

User · Agency · Service · Tariff · Booking · DocumentReadiness · ContactMessage · Article · ArticleCategory · FAQ · GalleryItem · Testimonial · Setting  

(+ Spatie Permission / Activity / Media models as installed)

Each model: fillable, relationships, casts, scopes (`active`, `published`), status helpers.
