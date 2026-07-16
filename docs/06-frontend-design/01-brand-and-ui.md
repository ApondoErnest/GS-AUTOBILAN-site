# Brand and UI system — V1

**System name:** GS Royal Safety Bands  
**Version:** 1.4 · **Status:** Palette revised from centre photos; homepage implemented · **Steps:** S029–S034 + S056
**Code tokens:** [`../../resources/css/app.css`](../../resources/css/app.css)

Inspired by the real centres: **royal blue + white + red bands + industrial grey**.

---

## 1. Design principles

| Role | Use |
|------|-----|
| Blue | Trust, authority, brand recognition |
| White / off-white | Clarity, cleanliness, spacing |
| Red | Bands, stripes, underlines, small active markers only |
| Grey | Industrial centre / bay feel — not decoration overload |
| Yellow | Functional safety / pending only — **not** a brand colour |

**Ratio:** royal/dark blue ≈50% · white/off-white ≈35% · industrial/concrete grey ≈8% · red bands ≈5% · functional colours ≈2%

---

## 2. Colour palette

| Purpose | Name | Hex | Token |
|---------|------|-----|-------|
| Main brand | GS Royal Blue | `#145DB3` | `gs-primary` |
| Dark blue | Deep Inspection Blue | `#062A5C` | `gs-navy` |
| Secondary blue | Technical Bay Blue | `#0B3A75` | `gs-bay` |
| Light blue bg | Soft Royal Blue | `#EEF5FF` | `gs-soft` |
| Red band | GS Signal Red | `#C8202F` | `gs-accent` |
| Soft red bg | Light Red Tint | `#FDECEE` | `gs-accent-soft` |
| Main white | Pure White | `#FFFFFF` | `gs-surface` |
| Page / section bg | Clean Wall White | `#F8FAFC` | `gs-wall` |
| Industrial grey | Centre Grey | `#4B5563` | `gs-grey` |
| Light grey | Concrete Light | `#E5E7EB` | `gs-concrete` |
| Body text | Charcoal | `#1F2937` | `gs-ink` |
| Muted text | Cool Grey | `#6B7280` | `gs-ink-muted` |
| Pending / caution | Safety Yellow | `#F5C542` | `gs-warning` |
| Success / open | Operational Green | `#16A34A` | `gs-success` |
| Error / cancelled | Alert Red | `#DC2626` | `gs-danger` |

Examples: `bg-gs-primary`, `text-gs-navy`, `border-gs-accent`, `bg-gs-soft`, `bg-gs-wall`.

### Removed / avoid

| Colour | Hex | Rule |
|--------|-----|------|
| Ox-blood red | `#7A1621` | **Removed** — real centres use clearer signal red |
| Electric blue | `#1F5EFF` | **Do not use as brand** — optional tiny hover only if needed |

---

## 3. Chrome application (S031+)

### Top strip

- Background: Deep Inspection Blue `#062A5C`
- Top band: GS Signal Red `#C8202F`
- Optional thin white line under the red band
- Text: white
- WhatsApp / status green only on functional controls

Structure: **dark blue strip + red/white top band** (not a red-only strip).

### Header

- Background: **white**
- Nav text: deep blue (`gs-navy` / `gs-bay`)
- Active link: red band underline (`gs-accent`)
- Primary CTA: royal blue (`gs-primary`)
- Secondary CTA: white + blue border

White header keeps logo/nav clean against strong blue signage elsewhere.

### Hero

- Background: real centre / inspection-bay photo when available
- Overlay: deep blue gradient (`gs-navy`)
- Heading: white
- Accent: small red/white band (horizontal or diagonal)
- CTA: white or royal blue for contrast

Until photos arrive: solid/gradient blue hero + text lockup (see placeholders).

### Home page implementation (S056)

- Hero carousel: `public/images/homepage/hero-1.png` through `hero-5.png`.
- Overlay: deep-blue gradient with a thinner left-side weight so the building imagery stays visible.
- Bottom ribbon: red/white/blue diagonal band in `resources/css/app.css`.
- Primary content: centered copy block, two CTA buttons, compact trust row, and no planning card.
- Section rhythm: homepage content sections use `py-9 sm:py-10 lg:py-12` to keep the page connected.
- Content source: `lang/fr/home.php` and `lang/en/home.php`; view: `resources/views/pages/home.blade.php`.

### Cards (agency, service, article)

- White background
- Blue heading
- Small **red vertical band** (top-left or left edge)
- Grey body text
- Blue CTA link

```
| red | GS AUTOBILAN Nkolbisson
|     | Address…
|     | [Itinéraire] [Rendez-vous]
```

### Section dividers

Red line → white gap → blue or wall section — inspired by building bands.

### Footer

- Background: deep blue (`gs-navy`)
- Top: red/white band
- Text: white · secondary: light grey
- Hovers: blue / red accents

---

## 4. Typography

Bold headings · clean body · generous line height · strong CTAs · large mobile form labels (≈44px touch targets).

**Font:** Instrument Sans (via Vite/Bunny) until brand fonts are specified.

| Token | Size | Use |
|-------|------|-----|
| `text-gs-display` | 2.5rem | Error codes, rare hero display |
| `text-gs-h1` | 2rem | Page titles |
| `text-gs-h2` | 1.5rem | Section titles |
| `text-gs-h3` | 1.25rem | Card / subsection titles |
| `text-gs-lead` | 1.125rem | Intro / supporting sentence |
| `text-gs-body` | 1rem | Body copy |
| `text-gs-small` | 0.875rem | Meta, notices, captions |

Stay on **GS Royal Safety Bands** — avoid purple/cream “AI default” looks and ox-blood accents.

---

## 5. Layout variants

| Variant | Blade | Sections | Used by |
|---------|-------|----------|---------|
| Base chrome | `layouts/app` | strip · header · main · footer · FABs | All public |
| **Home** | `layouts/home` | `hero` (navy/photo + red band) · `sections` · `final-cta` (`gs-soft`) | Accueil |
| **Content** | `layouts/content` | heading on `gs-soft` · body on `gs-wall` | About, Visite Technique |
| **Listing** | `layouts/listing` | white header · `gs-wall` listing area | Agencies, Services, News, Tariffs |
| **Article** | `layouts/article` | white header · related on `gs-soft` | News detail |
| **Form** | `layouts/form` | notice uses `gs-accent-soft` | Booking, Contact |
| **Tracking** | `layouts/tracking` | white panels · `gs-concrete` borders | Appointment tracking |
| **Error** | `layouts/error` | `gs-wall` | 404 / 500 |
| Admin | Filament panel | — | `/admin` |

---

## 6. Reusable components

Top strip · white header · mobile menu · language switcher · photo hero · CTA group · banded agency/service/article cards · tariff table · tariff mobile card · status badge · FAQ accordion · map card · booking form · tracking panel · banded footer · sticky WhatsApp + call FABs

---

## 7. Icons

**Heroicons:** phone, envelope, map pin, clock, calendar, document, shield check, check circle, exclamation triangle, building office, truck, wrench, language, user, magnifying glass  

**Custom SVG:** braking, suspension, emissions, headlight alignment, tyres, visual inspection, vehicle lane, chassis  

---

## 8. Responsive rules

**Mobile:** call/WhatsApp easy · simple booking · readable agency cards · tariffs as cards · short tracking · clear language switch  

**Desktop:** wide photo heroes · agencies side-by-side · service grids · tariff table · spacious sections · visible CTAs  

---

## 9. Page design order

1. Header and footer · 2. Home · 3. Agencies · 4. Booking · 5. Tracking · 6. Services · 7. Tariffs · 8. Visite Technique · 9. Contact · 10. News · 11. Article · 12. About  

---

## 10. Placeholders until assets arrive

Text logo “GS AUTOBILAN” in `#145DB3` · “GS” favicon · map-based agency cards · gallery “Photos à venir” · hero gradient without photo  

Official files: [`../../brand/`](../../brand/)

## 11. WhatsApp / phone

Deep links only: `wa.me` · `tel:` — pre-filled FR/EN per agency. No WhatsApp Business API in V1. Green only for functional WhatsApp/status UI.
