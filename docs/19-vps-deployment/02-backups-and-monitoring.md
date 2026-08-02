# Backups and monitoring — S091

**Version:** 1.0 · **Step:** S091 · **Depends on:** S090

Production backup automation and monitoring for the VPS Docker stack.

## Scripts

| Script | Purpose |
|--------|---------|
| [../../scripts/vps/backup-production.sh](../../scripts/vps/backup-production.sh) | MySQL dump + optional media archive |
| [../../scripts/vps/restore-production-smoke.sh](../../scripts/vps/restore-production-smoke.sh) | Restore latest backup into disposable DB |
| [../../scripts/vps/health-check.sh](../../scripts/vps/health-check.sh) | Containers, `/up`, disk, SSL presence |
| [../../scripts/vps/cron.example](../../scripts/vps/cron.example) | Cron template |

## What gets backed up

- **Daily:** MySQL database (`database.sql`)
- **Weekly (Sunday):** uploaded media (`storage-public.tar.gz`)
- **Always:** git commit, `php artisan about`, checksums

Backups are stored outside the project:

```text
/var/backups/gs-autobilan/YYYYMMDD-HHMMSS/
├── database.sql
├── storage-public.tar.gz   # Sundays only (INCLUDE_MEDIA=auto)
├── git-commit.txt
├── laravel-about.txt
└── checksums.sha256
```

Retention default: **14 days** (`RETENTION_DAYS`).

## VPS setup (one-time)

```bash
ssh ernesto@89.117.37.202
cd /var/www/gs-autobilan
git pull origin main

chmod +x scripts/vps/*.sh
sudo mkdir -p /var/backups/gs-autobilan
sudo chown ernesto:ernesto /var/backups/gs-autobilan
sudo chmod 700 /var/backups/gs-autobilan

# Manual backup test
./scripts/vps/backup-production.sh

# Restore smoke test (uses latest backup)
./scripts/vps/restore-production-smoke.sh

# Health check
./scripts/vps/health-check.sh
```

## Cron (daily backup + health checks)

```bash
sudo cp /var/www/gs-autobilan/scripts/vps/cron.example /etc/cron.d/gs-autobilan
sudo chmod 644 /etc/cron.d/gs-autobilan
sudo systemctl restart cron || sudo service cron restart
```

Verify:

```bash
sudo cat /etc/cron.d/gs-autobilan
ls -la /var/backups/gs-autobilan/
tail -20 /var/log/gs-autobilan-backup.log
```

## External uptime / SSL monitoring

Configure **UptimeRobot** (free tier is enough for V1):

| Monitor | URL | Interval |
|---------|-----|----------|
| HTTPS uptime | `https://gsautobilan.com/up` | 5 min |
| HTTPS homepage | `https://gsautobilan.com/fr/accueil` | 5 min |
| SSL expiry | `gsautobilan.com` (SSL monitor) | daily |

Alert contact: your ops email (e.g. `admin@gsautobilan.com`).

Certbot auto-renew is already on the VPS from S090. UptimeRobot SSL monitor is a second line of defense.

## Restore procedure (production)

**Never restore directly over live data without a maintenance window.**

1. Put site in maintenance mode (optional):  
   `docker compose -f docker-compose.prod.yml --env-file .env.docker exec app php artisan down`
2. Restore DB from chosen backup:  
   see [../15-security/01-backup-restore-procedure.md](../15-security/01-backup-restore-procedure.md) MySQL section
3. Restore media if needed:  
   extract `storage-public.tar.gz` into `storage/app/public` via app container
4. `php artisan optimize:clear && php artisan optimize`
5. Smoke-test `/fr/accueil`, `/admin/login`, booking list
6. `php artisan up`

Full detail: [01-backup-restore-procedure.md](../15-security/01-backup-restore-procedure.md)

## Acceptance (S091)

- [ ] `/var/backups/gs-autobilan/` exists with at least one backup
- [ ] `restore-production-smoke.sh` passes
- [ ] Cron installed (`/etc/cron.d/gs-autobilan`)
- [ ] UptimeRobot monitors `https://gsautobilan.com/up` + SSL
- [ ] `health-check.sh` returns exit 0

## Environment variables (optional overrides)

| Variable | Default | Purpose |
|----------|---------|---------|
| `PROJECT_DIR` | `/var/www/gs-autobilan` | App root on VPS |
| `BACKUP_ROOT` | `/var/backups/gs-autobilan` | Backup storage |
| `INCLUDE_MEDIA` | `auto` | `auto` = Sundays, `yes`, `no` |
| `RETENTION_DAYS` | `14` | Delete backups older than N days |
| `PUBLIC_URL` | `https://gsautobilan.com/up` | Health-check URL |
