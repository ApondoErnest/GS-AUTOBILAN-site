# S094 — Official public launch

**Step:** S094 · **Depends on:** S093 · **Next:** S095 maintenance cadence  
**Site:** https://gsautobilan.com  
**Admin:** https://gsautobilan.com/admin

S093 validated staff workflows. S094 is the **public announcement** and **launch-day watch**. The site is already live — this step makes it **official** and ensures the first days run smoothly.

---

## Go / no-go (before announcing)

All must be **yes**:

| Gate | Check |
|------|-------|
| S092 pre-launch | Completed |
| S093 soft launch | Completed · no open **critical** bugs |
| HTTPS | https://gsautobilan.com loads on mobile + desktop |
| Booking → admin → tracking | Tested on production (both agencies) |
| Tariffs | Official prices · no placeholders on public page |
| Staff guide | [03-staff-quick-guide.md](03-staff-quick-guide.md) shared |
| Backups | S091 cron + restore smoke passed |
| Monitoring | UptimeRobot alerts active |

Run automated check:

```bash
bash scripts/vps/pre-launch-check.sh
bash scripts/vps/health-check.sh   # on VPS
```

- [ ] Go / no-go signed off by Super Admin

---

## Phase 1 — Google Business Profile

Update **both** agency listings (or create if missing):

| Field | Value |
|-------|-------|
| **Website** | https://gsautobilan.com |
| **Name** | GS AUTOBILAN — Nkolbisson / Obili Scalom |
| **Phone** | See [00-company-data.md](../01-project-documentation/00-company-data.md) |
| **Address** | Confirmed agency addresses |
| **Hours** | Match website |
| **Category** | Vehicle inspection station / related local category |

Actions:

1. Log in to [Google Business Profile](https://business.google.com)
2. Add or update website URL for each location
3. Verify hours, phone, address match live site
4. Add 3–5 photos (logo, exterior, reception) if not already done
5. Optional: first post announcing the new website + online booking

- [ ] Nkolbisson listing updated with website
- [ ] Obili Scalom listing updated with website
- [ ] Hours / phone / address verified

---

## Phase 2 — Social media announcement

Use consistent message FR (adapt for EN if you post bilingually):

**Suggested post (FR):**

> GS AUTOBILAN lance son site officiel : informations, tarifs, prise de rendez-vous en ligne et suivi de dossier.  
> Visite technique à Nkolbisson et Obili Scalom.  
> https://gsautobilan.com  
> *Votre sécurité, c'est notre métier.*

**Include:**

- Link: https://gsautobilan.com
- Key CTAs: **Tarifs** · **Rendez-vous** · **Contact**
- Agency phones if platform allows

Platforms (as available):

- [ ] Facebook page
- [ ] Instagram (bio link + story/post)
- [ ] WhatsApp Business status / broadcast list (if used)
- [ ] LinkedIn or other — optional

Record posted URLs and date in launch log below.

---

## Phase 3 — Print / in-agency (optional)

- [ ] Flyer or counter card with URL + QR code to https://gsautobilan.com
- [ ] QR tested on phone → opens homepage
- [ ] Poster at reception: “Demandez votre rendez-vous en ligne”

QR generators: any trusted tool pointing to `https://gsautobilan.com/fr/rendez-vous` for direct booking.

---

## Phase 4 — Staff training (final)

Confirm with each desk:

- [ ] Staff know admin login URL
- [ ] Staff read [03-staff-quick-guide.md](03-staff-quick-guide.md)
- [ ] Staff know: online booking = **request**, not auto-confirm
- [ ] Staff know how to update booking status + document readiness
- [ ] Staff know who to call for technical issues (Super Admin)

Optional 15-minute desk demo:

1. Show a test booking appearing in admin
2. Show tracking page after status update
3. Show contact message inbox

---

## Phase 5 — Launch day (D-day)

### Morning checklist

```bash
# VPS — set DC if new session
cd /var/www/gs-autobilan
DC="docker compose -f docker-compose.prod.yml --env-file .env.docker"
$DC ps
bash scripts/vps/health-check.sh
```

From Mac:

```bash
bash scripts/vps/pre-launch-check.sh
curl -sS -o /dev/null -w "https:%{http_code}\n" https://gsautobilan.com/fr/accueil
```

- [ ] All six containers Up
- [ ] Health + pre-launch scripts pass
- [ ] UptimeRobot green

### Publish announcements

- [ ] Google Business post (if using)
- [ ] Social posts live
- [ ] Flyers / QR at agencies (if ready)

### Watch during day 1

| What | Where | Action if problem |
|------|-------|-------------------|
| Site down | UptimeRobot alert | VPS: `$DC ps`, `$DC logs app` |
| 500 errors | `storage/logs/laravel.log` | Fix or rollback deploy |
| Booking spike | `/admin/bookings` | Ensure staff monitoring inbox |
| Failed queue jobs | `$DC logs worker` | Restart worker |
| SSL | Certbot / UptimeRobot | Renew if near expiry |

Check at: **09:00 · 14:00 · 18:00 · end of day** (Africa/Douala).

- [ ] Launch day monitoring log completed (below)

---

## Phase 6 — First 48 hours post-launch

| When | Action |
|------|--------|
| **Day 1 evening** | Review bookings + contact messages in admin |
| **Day 2 morning** | Re-run `health-check.sh` + scan Laravel log |
| **Day 2** | Confirm at least one real customer booking handled correctly |
| **Day 2** | Note any UX confusion from staff/customers |

- [ ] No unresolved production incidents
- [ ] First real bookings processed by staff

---

## Launch log

| Item | URL / notes | Date |
|------|-------------|------|
| Google Business — Nkolbisson | | |
| Google Business — Obili | | |
| Facebook post | | |
| Instagram | | |
| WhatsApp / other | | |
| Flyers / QR | | |
| Launch announcement date | | |

---

## Issue log (launch week)

| # | Date | Source | Issue | Severity | Resolved |
|---|------|--------|-------|----------|----------|
| 1 | | | | | [ ] |

---

## S094 sign-off

| Criterion | Done |
|-----------|------|
| Public announcement made (≥1 channel) | [ ] |
| Google Business website linked | [ ] |
| Staff trained / guide distributed | [ ] |
| Launch day monitoring completed | [ ] |
| First 48h stable (no critical incidents) | [ ] |

| Role | Name | Date |
|------|------|------|
| Super Admin | | |
| GS AUTOBILAN management | | |

**Done when:** Site is public and stable; staff manage daily requests; monitoring watched on launch day.

Then proceed to **S095 — Establish routine maintenance cadence**.

---

## Quick reference

| Resource | Link |
|----------|------|
| Public site | https://gsautobilan.com |
| Booking | https://gsautobilan.com/fr/rendez-vous |
| Admin | https://gsautobilan.com/admin |
| Staff guide | [03-staff-quick-guide.md](03-staff-quick-guide.md) |
| Backups | [../19-vps-deployment/02-backups-and-monitoring.md](../19-vps-deployment/02-backups-and-monitoring.md) |
| Maintenance (next) | [../21-maintenance/README.md](../21-maintenance/README.md) |
