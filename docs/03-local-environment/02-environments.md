# Environments plan

**Phase:** 3 — Local environment  
**Project:** GS AUTOBILAN Official Website  
**Previous:** [01-setup-checklist.md](01-setup-checklist.md) · **Next phase:** [../04-laravel-setup/](../04-laravel-setup/)

---

## Environment matrix

| Environment | Purpose | Debug | Notes |
|-------------|---------|-------|-------|
| **local** | Developer machine | On | MySQL local, Mailpit or `log` mail driver |
| **docker-dev** | Containerized local | On | Same app; compose stack |
| **staging** | Pre-production | Off | Optional subdomain |
| **production** | Live VPS | Off | SSL, backups, monitoring |

---

## Values to define per environment

| Key area | Examples |
|----------|----------|
| Application | `APP_NAME`, `APP_URL`, `APP_ENV`, `APP_DEBUG`, `APP_KEY` |
| Locale | `APP_LOCALE=fr`, `APP_FALLBACK_LOCALE=en`, `APP_TIMEZONE=Africa/Douala` |
| Database | host, port, database, username, password |
| Mail | Mailpit (local) / SMTP (production) |
| Queue | `sync` locally; Redis + worker in Docker/production |
| Cache | `file` locally; Redis in production |
| Storage | `public` disk; persist uploads volume in Docker |

---

## Production targets (Phase 19)

- VPS minimum: 2 vCPU, 4 GB RAM, SSD/NVMe, Ubuntu, Docker  
- SSL (Let's Encrypt)  
- Daily DB backup + weekly media backup  
- Uptime / disk / queue / SSL monitoring  

---

## Suggestion

Create `.env.example` in Phase 4 with all keys documented and **no secrets**. Never commit real `.env` files.
