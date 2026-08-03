# S093 — Soft launch with staff

**Step:** S093 · **Depends on:** S092 · **Next:** S094 official launch  
**Production URL:** https://gsautobilan.com  
**Admin:** https://gsautobilan.com/admin

The site is **live on HTTPS** but not yet publicly announced. Staff test real workflows on production, log issues, fix critical bugs, then proceed to S094.

Share **[03-staff-quick-guide.md](03-staff-quick-guide.md)** with desk staff before testing.

---

## Who tests what

| Role | Tester | Focus |
|------|--------|-------|
| **Super Admin** | Ernesto / tech lead | All agencies, tariffs, users, settings, full booking lifecycle |
| **Agency Admin** | Nkolbisson desk staff | Own agency bookings, contact messages, document readiness |
| **Agency Admin** | Obili Scalom desk staff | Same, scoped to Obili |
| **Content Manager** | Optional | Articles, FAQs, gallery — if assigned |
| **Public (customer)** | Any staff member on personal phone | Booking + tracking + contact on mobile |

---

## Phase 1 — Prepare test accounts

Confirm production logins exist in `/admin` → **Users**:

- [ ] Super Admin account works
- [ ] At least one **Agency Admin** per agency (Nkolbisson + Obili Scalom)
- [ ] Passwords are **not** default seed values (changed in S092)

If agency admin accounts are missing, Super Admin creates them:

1. `/admin/users` → Create
2. Assign agency + role `agency_admin`
3. Share credentials securely (not by public chat)

---

## Phase 2 — Test matrix (check each box)

Use **real phones** for at least one full pass. Test on **Wi‑Fi and mobile data**.

### A. Public site (mobile + desktop)

| # | Test | URL | Pass |
|---|------|-----|------|
| 1 | Homepage FR loads, styled | `/fr/accueil` | [ ] |
| 2 | Homepage EN loads | `/en/home` | [ ] |
| 3 | Agencies page + maps | `/fr/agences` | [ ] |
| 4 | Tariffs show official prices (not placeholder) | `/fr/tarifs` | [ ] |
| 5 | Contact form + map | `/fr/contact` | [ ] |
| 6 | Language switch FR ↔ EN on 2 pages | any | [ ] |

### B. Booking (customer → admin)

**Tester:** staff member acting as customer, then Agency Admin.

| # | Step | Pass |
|---|------|------|
| 1 | Open `/fr/rendez-vous` on **mobile** | [ ] |
| 2 | Read non-auto-confirm disclaimer — clear? | [ ] |
| 3 | Submit booking (Nkolbisson, real test phone, test plate e.g. `TEST001`) | [ ] |
| 4 | Confirmation shows reference `GS-2026-XXXXXX` | [ ] |
| 5 | Open tracking link from confirmation (if shown) | [ ] |
| 6 | Agency Admin sees booking in `/admin/bookings` | [ ] |
| 7 | Admin updates status → **Confirmed**, date/time, public message | [ ] |
| 8 | Admin updates **document readiness** + public next action | [ ] |
| 9 | Customer tracks on `/fr/suivi-rendez-vous` with ref + phone + plate | [ ] |
| 10 | Tracking shows updated status; **no** internal notes exposed | [ ] |
| 11 | Repeat one booking for **Obili Scalom** agency | [ ] |

### C. Tracking edge cases

| # | Test | Expected | Pass |
|---|------|----------|------|
| 1 | Wrong phone with correct ref + plate | Generic “not found” (FR) | [ ] |
| 2 | Wrong plate | Generic “not found” | [ ] |
| 3 | Empty form submit | Validation errors | [ ] |

### D. Contact form

| # | Step | Pass |
|---|------|------|
| 1 | Submit message on `/fr/contact` (assign Nkolbisson if prompted) | [ ] |
| 2 | Super Admin or Agency Admin sees message in `/admin/contact-messages` | [ ] |
| 3 | Admin marks **in review** → **responded** → **closed** | [ ] |
| 4 | Agency Admin at Obili **cannot** see Nkolbisson-only message (if scoped) | [ ] |

### E. Admin operations (Super Admin)

| # | Test | Pass |
|---|------|------|
| 1 | View dashboard widgets | [ ] |
| 2 | Open a booking audit / activity log entry after edit | [ ] |
| 3 | Tariffs page — prices match official table | [ ] |
| 4 | Log out and back in — session stable over HTTPS | [ ] |

---

## Phase 3 — Staff script (what to tell test “customers”)

Use this wording during soft launch tests:

> *Votre demande en ligne est bien reçue. Ce n'est pas une confirmation automatique — nous vous contactons par téléphone ou WhatsApp pour confirmer le créneau. Vous pouvez suivre votre dossier sur le site avec votre numéro de référence, votre téléphone et votre immatriculation.*

EN equivalent on `/en/booking` flow if testing bilingual desk.

---

## Phase 4 — Issue log

Record every problem. Fix **critical** before S094; defer **minor** to post-launch if agreed.

| # | Date | Reporter | Page / module | Issue | Severity | Fixed? |
|---|------|----------|---------------|-------|----------|--------|
| 1 | | | | | critical / minor | [ ] |
| 2 | | | | | | [ ] |
| 3 | | | | | | [ ] |

**Critical examples:** cannot submit booking, admin cannot see bookings, tracking leaks private data, site down, wrong agency data, payment of wrong tariff.

**Minor examples:** typo, spacing on mobile, non-blocking EN wording tweak.

---

## Phase 5 — Technical monitoring during soft launch

Daily during soft launch week:

```bash
# VPS
cd /var/www/gs-autobilan
docker compose -f docker-compose.prod.yml --env-file .env.docker ps
bash scripts/vps/health-check.sh
tail -50 storage/logs/laravel.log   # via exec app if needed
```

From Mac:

```bash
bash scripts/vps/pre-launch-check.sh
```

Check **UptimeRobot** dashboard for alerts.

---

## Phase 6 — Sign-off

Soft launch is complete when:

- [ ] All **Phase 2** critical paths pass (booking, admin confirm, tracking, contact)
- [ ] Mobile test completed on at least one iPhone and one Android (or two browsers)
- [ ] Both agencies tested
- [ ] No **open critical** issues in Phase 4 log
- [ ] Staff received [03-staff-quick-guide.md](03-staff-quick-guide.md)
- [ ] Super Admin agrees site is ready for public announcement (S094)

| Role | Name | Date |
|------|------|------|
| Super Admin / tech | | |
| Nkolbisson lead | | |
| Obili Scalom lead | | |

Then proceed to **S094 — Official public launch**.

---

## Quick links

| Resource | URL |
|----------|-----|
| Booking FR | https://gsautobilan.com/fr/rendez-vous |
| Tracking FR | https://gsautobilan.com/fr/suivi-rendez-vous |
| Contact FR | https://gsautobilan.com/fr/contact |
| Admin | https://gsautobilan.com/admin |
| Automated checks | `bash scripts/vps/pre-launch-check.sh` |
