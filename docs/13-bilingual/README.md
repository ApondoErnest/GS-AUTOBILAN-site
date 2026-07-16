# Bilingual implementation — V1

**Version:** 1.1 · **Steps:** S071–S073  

- Default: **French** · Secondary: **English**  
- URLs: `/fr` · `/en` with localized slugs  
- CMS: `_fr` / `_en` fields  
- UI: structured PHP translation files under `lang/fr/` · `lang/en/`  
- Language switcher: preserve the matching localized route when available, e.g. `/fr/a-propos` ↔ `/en/about`; fall back to the locale home only when a page has no counterpart.
- Translate: menus, buttons, forms, validation, statuses, FAQ, footer, SEO, tracking errors  
- Manual review before launch — avoid machine-only translation  

**Acceptance:** Every public page and public message available in FR and EN.
