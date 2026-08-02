# S092 — Pre-launch checklist

**Step:** S092 · **Depends on:** S091 · **Next:** S093 soft launch  
**Reference:** [00-company-data.md](../01-project-documentation/00-company-data.md) · [04-content-checklist.md](../01-project-documentation/04-content-checklist.md)

Work through each section. Mark `[x]` only when verified. Business items need **GS AUTOBILAN sign-off**.

---

## A. Infrastructure (verify on production)

Run from Mac or VPS:

```bash
bash /var/www/gs-autobilan/scripts/vps/pre-launch-check.sh
```

Or manually:

| Check | Command | Expected |
|-------|---------|----------|
| HTTPS health | `curl -sS -o /dev/null -w '%{http_code}\n' https://gsautobilan.com/up` | 200 |
| Homepage FR | `curl -sS -o /dev/null -w '%{http_code}\n' https://gsautobilan.com/fr/accueil` | 200 |
| Homepage EN | `curl -sS -o /dev/null -w '%{http_code}\n' https://gsautobilan.com/en/home` | 200 |
| Admin login | `curl -sS -o /dev/null -w '%{http_code}\n' https://gsautobilan.com/admin/login` | 200 |
| HTTP → HTTPS | `curl -sI http://gsautobilan.com` | 301/308 to https |
| Sitemap | `curl -sS https://gsautobilan.com/sitemap.xml \| head` | XML with URLs |
| Robots | `curl -sS https://gsautobilan.com/robots.txt` | `Disallow: /admin` + Sitemap |

- [ ] Domain + SSL working
- [ ] Public pages FR respond (200)
- [ ] Public pages EN respond (200)
- [ ] SEO: sitemap.xml live
- [ ] SEO: robots.txt live
- [ ] Backups restore-tested (S091 `restore-production-smoke.sh` passed)
- [ ] UptimeRobot monitors active

---

## B. Application (verify in admin + browser)

| Check | How to verify |
|-------|----------------|
| Admin login | Log in at `/admin` with production super-admin |
| Roles | Super Admin, agency_admin, content_manager exist |
| Agency scoping | Agency admin sees only their agency data |
| Booking page | Open `/fr/rendez-vous` — form loads |
| Tracking page | Open `/fr/suivi-rendez-vous` — lookup form loads |
| Booking flow | Submit test booking on `/fr/rendez-vous` |
| Tracking flow | Lookup test reference on `/fr/suivi-rendez-vous` |
| Mobile layout | Spot-check homepage, booking, contact on phone |
| Queue worker | `$DC ps` — worker Up; no stuck failed jobs |

- [ ] Admin login + roles work
- [ ] Booking flow works end-to-end
- [ ] Tracking flow works
- [ ] Contact form works
- [ ] Mobile layout acceptable on key pages

---

## C. Official data (GS AUTOBILAN sign-off required)

Source: [00-company-data.md](../01-project-documentation/00-company-data.md)

### Phones and addresses

| Agency | Phones | Address | GPS |
|--------|--------|---------|-----|
| Nkolbisson | +237 678 844 791 / +237 652 516 527 | Carrefour Onana… | 3.8882487, 11.4549352 |
| Obili Scalom | +237 678 844 791 / +237 658 473 182 | Obili Scalom | 3.8471748, 11.4967492 |
| Direction Générale | +237 653 283 107 | Bastos… | — |

- [ ] Phones verified on live site (Contact + Agencies pages)
- [ ] Addresses verified
- [ ] Google Maps embeds open correct locations

### Email spelling

Confirm on live Contact page and company docs:

- [ ] `gsautosbilan@gmail.com` — spelling confirmed
- [ ] `admin@gsautobilan.com` — spelling confirmed (admin/DG use)

### Tariffs (`is_placeholder`)

Seeded tariffs default to **`is_placeholder = true`**. Before public launch:

1. Log in as Super Admin → **Tariffs**
2. Enter **official prices** from GS AUTOBILAN tariff table
3. Set **`is_placeholder` = false** for each official row
4. Verify public `/fr/tarifs` shows final prices (not “pending” labels)

Reference prices (reconfirm with company): A 4 900 · B 17 900 · B1 15 500 · C <3,5T 15 500 · C 19 080 · D poids lourds 26 235 · D autres engins 41 750 FCFA.

- [ ] Official tariff prices entered in admin
- [ ] All public tariffs have `is_placeholder` cleared
- [ ] Public tariffs page matches official table

### Photos / logo

Current V1 assets are in place (`public/images/site_logo.png`, hero/gallery images). Confirm acceptance:

- [ ] Logo / lockup accepted for launch (or replacement supplied)
- [ ] Hero and agency photos accepted (or “Photos à venir” acceptable)

---

## D. Security and operations

- [ ] **Admin passwords changed** from initial seed defaults (`GS_SUPER_ADMIN_PASSWORD` is strong and known only to ops)
- [ ] `.env.docker` on VPS is `chmod 600` and not in git
- [ ] Production `APP_DEBUG=false` (`$DC exec app php artisan about`)
- [ ] Mail driver configured or consciously left as `log` until SMTP ready

### Email delivery (if launching with live mail)

If still `MAIL_MAILER=log`, contact/booking emails are **not sent to customers** — acceptable for soft launch if staff monitor admin.

- [ ] Mail strategy decided: `log` for soft launch **or** SMTP configured and test email sent

---

## E. Content gate (FR + EN)

Spot-check in browser — not machine-only translation:

- [ ] Homepage FR + EN
- [ ] About, Services, Tariffs, Visite Technique, Contact (FR + EN)
- [ ] Booking disclaimer + tracking notice visible
- [ ] No obvious placeholder/lorem text on public pages

Full content status: [04-content-checklist.md](../01-project-documentation/04-content-checklist.md)

---

## S092 sign-off

| Role | Name | Date | Signature |
|------|------|------|-----------|
| Technical (deploy) | | | |
| GS AUTOBILAN (content/tariffs) | | | |

**Done when:** All sections A–E checked; tariffs/email/photos/passwords decisions recorded.

Then proceed to **S093** — soft launch with staff only.

---

## Quick commands (VPS)

```bash
cd /var/www/gs-autobilan
DC="docker compose -f docker-compose.prod.yml --env-file .env.docker"

$DC exec app php artisan about
$DC ps
bash scripts/vps/pre-launch-check.sh
```
