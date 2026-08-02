#!/usr/bin/env bash

set -euo pipefail

PROJECT_DIR="${PROJECT_DIR:-/var/www/gs-autobilan}"
BACKUP_ROOT="${BACKUP_ROOT:-/var/backups/gs-autobilan}"
COMPOSE_FILE="${COMPOSE_FILE:-docker-compose.prod.yml}"
ENV_FILE="${ENV_FILE:-.env.docker}"
RETENTION_DAYS="${RETENTION_DAYS:-14}"
INCLUDE_MEDIA="${INCLUDE_MEDIA:-auto}"

if [[ ! -d "$PROJECT_DIR" ]]; then
    echo "Project directory not found: $PROJECT_DIR" >&2
    exit 1
fi

if [[ ! -f "$PROJECT_DIR/$ENV_FILE" ]]; then
    echo "Env file not found: $PROJECT_DIR/$ENV_FILE" >&2
    exit 1
fi

cd "$PROJECT_DIR"

DC=(docker compose -f "$COMPOSE_FILE" --env-file "$ENV_FILE")

if ! "${DC[@]}" ps --status running --services mysql | grep -qx mysql; then
    echo "MySQL container is not running." >&2
    exit 1
fi

TIMESTAMP="$(date +%Y%m%d-%H%M%S)"
BACKUP_DIR="$BACKUP_ROOT/$TIMESTAMP"

mkdir -p "$BACKUP_ROOT" "$BACKUP_DIR"
chmod 700 "$BACKUP_ROOT" "$BACKUP_DIR"

echo "[$(date -Is)] Starting production backup -> $BACKUP_DIR"

"${DC[@]}" exec -T mysql sh -c '
    mysqldump \
        -uroot -p"$MYSQL_ROOT_PASSWORD" \
        --single-transaction \
        --routines \
        --triggers \
        --default-character-set=utf8mb4 \
        "$MYSQL_DATABASE"
' > "$BACKUP_DIR/database.sql"

should_backup_media=false
case "$INCLUDE_MEDIA" in
    yes|true|1)
        should_backup_media=true
        ;;
    no|false|0)
        should_backup_media=false
        ;;
    auto)
        if [[ "$(date +%u)" -eq 7 ]]; then
            should_backup_media=true
        fi
        ;;
    *)
        echo "Invalid INCLUDE_MEDIA value: $INCLUDE_MEDIA (use auto, yes, or no)" >&2
        exit 1
        ;;
esac

if [[ "$should_backup_media" == true ]]; then
    echo "[$(date -Is)] Including uploaded media archive"
    "${DC[@]}" exec -T app tar -C /var/www/html/storage/app -czf - public \
        > "$BACKUP_DIR/storage-public.tar.gz"
fi

if git -C "$PROJECT_DIR" rev-parse HEAD > "$BACKUP_DIR/git-commit.txt" 2>/dev/null; then
    :
else
    echo "unknown" > "$BACKUP_DIR/git-commit.txt"
fi

"${DC[@]}" exec -T app php artisan about > "$BACKUP_DIR/laravel-about.txt" 2>/dev/null || true

{
    shasum -a 256 "$BACKUP_DIR/database.sql"
    if [[ -f "$BACKUP_DIR/storage-public.tar.gz" ]]; then
        shasum -a 256 "$BACKUP_DIR/storage-public.tar.gz"
    fi
} > "$BACKUP_DIR/checksums.sha256"

find "$BACKUP_ROOT" -mindepth 1 -maxdepth 1 -type d -mtime +"$RETENTION_DAYS" -exec rm -rf {} +

echo "[$(date -Is)] Backup completed"
echo "backup_dir=$BACKUP_DIR"
echo "database_bytes=$(wc -c < "$BACKUP_DIR/database.sql" | tr -d ' ')"
if [[ -f "$BACKUP_DIR/storage-public.tar.gz" ]]; then
    echo "media_bytes=$(wc -c < "$BACKUP_DIR/storage-public.tar.gz" | tr -d ' ')"
fi
