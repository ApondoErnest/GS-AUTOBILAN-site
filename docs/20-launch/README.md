# Launch — V1

**Version:** 1.2 · **Steps:** S092–S094 · **S094 completed:** 2026-08-03  

## Docs

| Step | File |
|------|------|
| **S092 Pre-launch checklist** | [01-pre-launch-checklist.md](01-pre-launch-checklist.md) |
| **S093 Soft launch runbook** | [02-soft-launch-runbook.md](02-soft-launch-runbook.md) |
| **S094 Official launch runbook** | [04-official-launch-runbook.md](04-official-launch-runbook.md) |
| Staff quick guide | [03-staff-quick-guide.md](03-staff-quick-guide.md) |
| Content gate | [../01-project-documentation/04-content-checklist.md](../01-project-documentation/04-content-checklist.md) |
| Company data | [../01-project-documentation/00-company-data.md](../01-project-documentation/00-company-data.md) |

## Pre-launch checklist (summary)

See **[01-pre-launch-checklist.md](01-pre-launch-checklist.md)** for the full S092 runbook.

- Domain + SSL  
- Public pages FR/EN  
- Admin login + roles + agency scoping  
- Booking + tracking + contact  
- Emails if configured  
- Mobile layout  
- Official tariffs (`is_placeholder` cleared)  
- Email spelling confirmed  
- Photos/logo decision  
- SEO + sitemap + robots.txt  
- Backups restore-tested  
- Admin passwords changed  
- Phones / addresses / GPS verified  

Automated public checks:

```bash
bash scripts/vps/pre-launch-check.sh
```

## Soft launch (S093)

See **[02-soft-launch-runbook.md](02-soft-launch-runbook.md)** · share **[03-staff-quick-guide.md](03-staff-quick-guide.md)** with desk staff.

Staff-only tests: bookings, statuses, tracking, contact, mobile · fix critical issues before S094.

## Official launch (S094)

See **[04-official-launch-runbook.md](04-official-launch-runbook.md)**.

Public announcement · Google Business · social · flyers · staff training · launch-day monitoring.

## Acceptance

Site public and stable; staff manage daily requests.
