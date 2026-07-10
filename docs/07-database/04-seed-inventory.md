# Seed data inventory — V1

**Step S039** · Schema: [01-schema-overview.md](01-schema-overview.md)

**Agencies & DG values:** copy from [../01-project-documentation/00-company-data.md](../01-project-documentation/00-company-data.md) — do not maintain a second copy here.

---

| Seed | Notes |
|------|--------|
| Roles | Super Admin · Agency Admin · Content Manager |
| Super Admin user | Via env/prompt — never commit password |
| Agencies (×2) | From company data · `operational` · `is_active` |
| Site settings | slogan · DG block · site name · SEO defaults FR/EN |
| Services (×8) | From [sitemap](../01-project-documentation/03-sitemap.md) · FR/EN titles · active |
| Tariffs | Placeholder rows · `is_placeholder = true` · **no invented prices** |
| FAQs | Sample set for Contact |
| Article categories | maintenance · inspection · road safety · news · advice |
| Optional | 1–2 draft articles · empty gallery/testimonials OK |

Content checklist: [../01-project-documentation/04-content-checklist.md](../01-project-documentation/04-content-checklist.md)
