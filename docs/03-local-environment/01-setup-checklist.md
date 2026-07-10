# Phase 3 — Local setup checklist

**Status:** In progress (tools verified 2026-07-10)

---

## 1. Required tools

| Tool | Minimum | Check command | Done |
|------|---------|---------------|------|
| PHP | 8.2+ | `php -v` | ☑ 8.5.6 |
| Composer | 2.x | `composer -V` | ☑ 2.9.8 |
| Node.js | 18+ LTS recommended | `node -v` | ☑ v26.0.0 |
| npm | with Node | `npm -v` | ☑ 11.12.1 |
| MySQL | 8.x | `mysql --version` | ☑ 9.6.0 (service running) |
| Git | 2.x | `git --version` | ☑ 2.50.1 |

Optional: Mailpit (local email), TablePlus/DBeaver (DB GUI), VS Code or PhpStorm.

---

## 2. Repository folders (already present)

```
GS-AUTOBILAN/
├── docs/          ← chronological phase docs (you are here)
├── brand/         ← logo/favicon when available
├── design/        ← wireframes/mockups
├── README.md
└── plan.md
```

---

## 3. Git workflow

| Branch | Purpose |
|--------|---------|
| `main` | Stable / production-ready |
| `develop` | Integration |
| `feature/...` | One module per branch |

Suggested feature branches:

`feature/project-foundation` · `feature/frontend-layout` · `feature/admin-dashboard` · `feature/agencies` · `feature/services` · `feature/tariffs` · `feature/booking` · `feature/tracking` · `feature/bilingual` · `feature/contact-faq` · `feature/news`

**When executing this phase:** `git init`, create `main`/`develop`, add `.gitignore` suitable for Laravel (full ignore file comes with Phase 4 scaffold).

---

## 4. After this checklist

Continue with [02-environments.md](02-environments.md), then [../04-laravel-setup/](../04-laravel-setup/).
