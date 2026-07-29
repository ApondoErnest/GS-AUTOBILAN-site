# Backup And Restore Procedure

**Step:** S079
**Scope:** Local V1 procedure and restore smoke test
**Last tested:** 2026-07-29

This procedure proves that a GS AUTOBILAN backup is useful by restoring it into a separate target before launch. Production automation and monitoring are still handled later in S091.

## What To Back Up

- Database: bookings, contacts, tracking readiness, CMS content, staff users, settings, tariffs, roles, and audit logs.
- Public uploaded files: `storage/app/public`.
- Environment reference: `.env` values must be stored securely outside git. Do not put real secrets in the backup folder committed to the repo.
- Deployment reference: current git commit, Laravel/PHP versions, and backup timestamp.

## Local SQLite Backup

Use this when the local environment is using `DB_CONNECTION=sqlite`.

```bash
BACKUP_DIR="storage/app/backups/local/$(date +%Y%m%d-%H%M%S)"
mkdir -p "$BACKUP_DIR"
cp database/database.sqlite "$BACKUP_DIR/database.sqlite"
tar -C storage/app -czf "$BACKUP_DIR/storage-public.tar.gz" public
php artisan about > "$BACKUP_DIR/laravel-about.txt"
git rev-parse HEAD > "$BACKUP_DIR/git-commit.txt"
shasum -a 256 "$BACKUP_DIR/database.sqlite" "$BACKUP_DIR/storage-public.tar.gz" > "$BACKUP_DIR/checksums.sha256"
```

Keep the backup outside the web root and restrict access to trusted admins only.

## Local SQLite Restore

Restore into a separate database first. Replace the real local database only after the dry run passes.

```bash
RESTORE_DIR="/tmp/gs-autobilan-restore-check"
mkdir -p "$RESTORE_DIR/storage"
cp "$BACKUP_DIR/database.sqlite" "$RESTORE_DIR/database.sqlite"
tar -C "$RESTORE_DIR/storage" -xzf "$BACKUP_DIR/storage-public.tar.gz"
APP_ENV=local DB_CONNECTION=sqlite DB_DATABASE="$RESTORE_DIR/database.sqlite" php artisan migrate:status
APP_ENV=local DB_CONNECTION=sqlite DB_DATABASE="$RESTORE_DIR/database.sqlite" php artisan test tests/Feature/BookingServiceTest.php tests/Feature/TrackingServiceTest.php
```

If a real local restore is needed after the dry run:

```bash
cp "$BACKUP_DIR/database.sqlite" database/database.sqlite
mv storage/app/public "storage/app/public.pre-restore-$(date +%Y%m%d-%H%M%S)"
tar -C storage/app -xzf "$BACKUP_DIR/storage-public.tar.gz"
php artisan optimize:clear
php artisan storage:link
```

Then smoke-check the admin login, booking list, tracking lookup, contact messages, published content, and representative uploaded images.

## MySQL Backup For VPS/Docker

Use this shape once the Docker/VPS database exists. Run the dump from a trusted shell with environment variables already loaded.

```bash
BACKUP_DIR="storage/app/backups/mysql/$(date +%Y%m%d-%H%M%S)"
mkdir -p "$BACKUP_DIR"
MYSQL_PWD="$DB_PASSWORD" mysqldump \
  --host="$DB_HOST" \
  --port="${DB_PORT:-3306}" \
  --user="$DB_USERNAME" \
  --single-transaction \
  --routines \
  --triggers \
  --default-character-set=utf8mb4 \
  "$DB_DATABASE" > "$BACKUP_DIR/database.sql"
tar -C storage/app -czf "$BACKUP_DIR/storage-public.tar.gz" public
shasum -a 256 "$BACKUP_DIR/database.sql" "$BACKUP_DIR/storage-public.tar.gz" > "$BACKUP_DIR/checksums.sha256"
```

Restore MySQL only into a disposable restore database first:

```bash
MYSQL_PWD="$DB_PASSWORD" mysql --host="$DB_HOST" --port="${DB_PORT:-3306}" --user="$DB_USERNAME" -e "CREATE DATABASE gs_autobilan_restore CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
MYSQL_PWD="$DB_PASSWORD" mysql --host="$DB_HOST" --port="${DB_PORT:-3306}" --user="$DB_USERNAME" gs_autobilan_restore < "$BACKUP_DIR/database.sql"
```

Point a local/staging app at `gs_autobilan_restore`, run smoke checks, then decide whether to restore production during a maintenance window.

## Restore Smoke Test

Run the repeatable local smoke script:

```bash
bash scripts/backup-restore-smoke.sh
```

Expected result:

```text
agencies=2
settings=3
S079 backup restore smoke test passed.
```

The script creates a temporary SQLite database, runs migrations and base seed data, writes a sample uploaded file, backs up both database and media, deliberately damages the source, restores into a separate target, and verifies restored data plus the sample media file.

## Acceptance

- Backup includes database and uploaded media.
- Restore is tested into a separate target before replacing any live data.
- Restored database can run Laravel checks.
- Restored media is present and readable.
- Backup artifacts remain outside git and outside public web paths.
