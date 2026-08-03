# S095 — Routine maintenance cadence

**Step:** S095 · **Depends on:** S094 · **Next:** S096 V2 boundary review  
**Site:** https://gsautobilan.com · **Admin:** https://gsautobilan.com/admin

Assign **who** does **what**, and **how often**, so the site stays accurate and secure after launch.

---

## 1. Role assignments (fill in names)

Complete this table once. Review quarterly.

| Area | Primary owner | Backup | Frequency |
|------|---------------|--------|-----------|
| **New booking requests** | Agency Admin (each desk) | Super Admin | Daily (business hours) |
| **Contact messages** | Agency Admin | Super Admin | Daily |
| **Document readiness updates** | Agency Admin | — | Per booking |
| **Public content (articles, FAQ, gallery)** | Content Manager | Super Admin | Weekly |
| **Tariffs / official prices** | Super Admin | — | When official table changes |
| **Agency hours / phones / addresses** | Super Admin | Agency Admin | When changed |
| **Staff user accounts** | Super Admin | — | As needed |
| **Technical / VPS / Docker** | Super Admin (Ernesto) | — | Weekly + on alert |
| **Backups verification** | Super Admin | — | Monthly |
| **UptimeRobot / SSL alerts** | Super Admin | — | On notification |
| **Security updates (OS, Docker, Laravel)** | Super Admin | — | Monthly review |

### Named assignments (example — replace with real names)

| Role | Person | Contact |
|------|--------|---------|
| Super Admin / technical | Ernesto | |
| Nkolbisson Agency Admin | | |
| Obili Scalom Agency Admin | | |
| Content Manager | | |
| Uptime alert email | admin@gsautobilan.com | |

- [ ] All rows assigned
- [ ] Backup contacts documented
- [ ] Staff know who to escalate to

---

## 2. Daily checklist (business days)

**Owner:** Agency Admin (each agency) · **Time:** start of shift + mid-afternoon

| Task | Where | Done |
|------|-------|------|
| Open admin · check **new bookings** for your agency | `/admin/bookings` | [ ] |
| Contact customers for pending requests (phone/WhatsApp) | — | [ ] |
| Update booking status + confirmed datetime | `/admin/bookings` | [ ] |
| Update **document readiness** when papers reviewed | booking record | [ ] |
| Check **contact messages** · respond · mark closed | `/admin/contact-messages` | [ ] |
| Spot-check site on phone (homepage loads) | https://gsautobilan.com | [ ] |

**Escalate to Super Admin if:** site down, 500 errors, login broken, data wrong on public pages.

---

## 3. Weekly checklist

**Owner:** Super Admin (technical) + Content Manager (content)

### Operations (Super Admin)

| Task | Command / location | Done |
|------|------------------|------|
| Docker containers all Up | `$DC ps` on VPS | [ ] |
| Health check | `bash scripts/vps/health-check.sh` | [ ] |
| Scan Laravel log for errors | `$DC exec app tail -100 storage/logs/laravel.log` | [ ] |
| Worker running · no failed jobs pile-up | `$DC logs worker --tail=50` | [ ] |
| Disk space OK | `df -h /` on VPS | [ ] |
| UptimeRobot dashboard green | uptimerobot.com | [ ] |

```bash
cd /var/www/gs-autobilan
DC="docker compose -f docker-compose.prod.yml --env-file .env.docker"
$DC ps
bash scripts/vps/health-check.sh
```

### Content (Content Manager)

| Task | Done |
|------|------|
| Review published articles / FAQs for outdated info | [ ] |
| Check gallery / testimonials if new photos approved | [ ] |
| Verify tariffs still match official table | [ ] |
| Quick FR + EN spot-check on one public page | [ ] |

---

## 4. Monthly checklist

**Owner:** Super Admin

| Task | Done |
|------|------|
| Confirm backup cron ran (`/var/log/gs-autobilan-backup.log`) | [ ] |
| Run restore smoke test | `./scripts/vps/restore-production-smoke.sh` | [ ] |
| Review backup disk usage (`/var/backups/gs-autobilan/`) | [ ] |
| `certbot renew --dry-run` | [ ] |
| Check for Laravel / package security advisories | [ ] |
| Review admin user list · deactivate leavers | `/admin/users` | [ ] |
| Review activity log for unusual admin actions | `/admin/activities` | [ ] |

---

## 5. When official data changes

Trigger immediate update (do not wait for weekly review):

| Change | Who updates | Where |
|--------|-------------|-------|
| New official tariff | Super Admin | `/admin/tariffs` · clear `is_placeholder` |
| Agency hours | Super Admin | `/admin/agencies` + public pages |
| Phone / email | Super Admin | agencies + contact content |
| New service wording | Content Manager | `/admin/services` + public copy |
| New FAQ | Content Manager | `/admin/faqs` |

Source of truth: [00-company-data.md](../01-project-documentation/00-company-data.md)

---

## 6. Incident response (quick)

| Symptom | First action |
|---------|--------------|
| Site down | Check UptimeRobot · VPS: `$DC ps` · `$DC logs app nginx` |
| 502 / 500 | `$DC logs app --tail=100` · Laravel log |
| Bookings not saving | Check worker + mysql healthy · `$DC ps` |
| SSL warning | `sudo certbot certificates` · renew if needed |
| Suspected breach | Change admin passwords · review activity log · restore from backup if needed |

Technical reference: [../19-vps-deployment/02-backups-and-monitoring.md](../19-vps-deployment/02-backups-and-monitoring.md)

---

## 7. Deployment updates (when code changes)

**Owner:** Super Admin

```bash
cd /var/www/gs-autobilan
git pull origin main
DC="docker compose -f docker-compose.prod.yml --env-file .env.docker"
$DC build app nginx
$DC up -d --force-recreate app nginx worker scheduler
$DC exec app php artisan migrate --force
$DC exec app php artisan optimize
$DC restart worker scheduler
bash scripts/vps/pre-launch-check.sh
```

Never run `docker compose down -v` on production.

---

## 8. Maintenance log (optional)

| Week | Daily ops OK | Weekly tech OK | Weekly content OK | Notes |
|------|--------------|----------------|-------------------|-------|
| | [ ] | [ ] | [ ] | |
| | [ ] | [ ] | [ ] | |

---

## S095 sign-off

| Criterion | Done |
|-----------|------|
| Role assignment table completed with real names | [ ] |
| Daily checklist shared with agency desk staff | [ ] |
| Weekly owner understands technical checklist | [ ] |
| Monthly backup verification scheduled | [ ] |
| Escalation path documented | [ ] |

| Signed | Name | Date |
|--------|------|------|
| Super Admin | | |
| GS AUTOBILAN management | | |

**Done when:** Who checks bookings, content, backups, and security updates is assigned.

Then proceed to **S096 — Review V2 ideas against V1/V2 boundary**.

---

## Related

- [03-staff-quick-guide.md](../20-launch/03-staff-quick-guide.md)
- [02-backups-and-monitoring.md](../19-vps-deployment/02-backups-and-monitoring.md)
- [06-v1-v2-boundary.md](../01-project-documentation/06-v1-v2-boundary.md)
