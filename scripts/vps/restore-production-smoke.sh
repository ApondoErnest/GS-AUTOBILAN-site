#!/usr/bin/env bash

set -euo pipefail

PROJECT_DIR="${PROJECT_DIR:-/var/www/gs-autobilan}"
BACKUP_ROOT="${BACKUP_ROOT:-/var/backups/gs-autobilan}"
COMPOSE_FILE="${COMPOSE_FILE:-docker-compose.prod.yml}"
ENV_FILE="${ENV_FILE:-.env.docker}"
RESTORE_DB="${RESTORE_DB:-gs_autobilan_restore}"
BACKUP_DIR="${BACKUP_DIR:-}"

if [[ ! -d "$PROJECT_DIR" ]]; then
    echo "Project directory not found: $PROJECT_DIR" >&2
    exit 1
fi

cd "$PROJECT_DIR"

DC=(docker compose -f "$COMPOSE_FILE" --env-file "$ENV_FILE")

if [[ -z "$BACKUP_DIR" ]]; then
    BACKUP_DIR="$(find "$BACKUP_ROOT" -mindepth 1 -maxdepth 1 -type d | sort | tail -1)"
fi

if [[ -z "$BACKUP_DIR" || ! -f "$BACKUP_DIR/database.sql" ]]; then
    echo "No backup directory with database.sql found." >&2
    echo "Set BACKUP_DIR or run backup-production.sh first." >&2
    exit 1
fi

echo "[$(date -Is)] Restore smoke test using $BACKUP_DIR"

"${DC[@]}" exec -T mysql sh -c "
    mysql -uroot -p\"\$MYSQL_ROOT_PASSWORD\" -e \"
        DROP DATABASE IF EXISTS \\\`$RESTORE_DB\\\`;
        CREATE DATABASE \\\`$RESTORE_DB\\\`
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_unicode_ci;
    \"
"

"${DC[@]}" exec -T mysql sh -c "mysql -uroot -p\"\$MYSQL_ROOT_PASSWORD\" \"$RESTORE_DB\"" \
    < "$BACKUP_DIR/database.sql"

agencies="$("${DC[@]}" exec -T mysql sh -c "
    mysql -uroot -p\"\$MYSQL_ROOT_PASSWORD\" -Nse 'SELECT COUNT(*) FROM agencies' \"$RESTORE_DB\"
" | tr -d '\r')"

settings="$("${DC[@]}" exec -T mysql sh -c "
    mysql -uroot -p\"\$MYSQL_ROOT_PASSWORD\" -Nse 'SELECT COUNT(*) FROM settings' \"$RESTORE_DB\"
" | tr -d '\r')"

if [[ "${agencies:-0}" -lt 1 ]]; then
    echo "Restore verification failed: agencies=${agencies:-0}" >&2
    exit 1
fi

if [[ "${settings:-0}" -lt 1 ]]; then
    echo "Restore verification failed: settings=${settings:-0}" >&2
    exit 1
fi

if [[ -f "$BACKUP_DIR/storage-public.tar.gz" ]]; then
    TEMP_MEDIA="$(mktemp -d)"
    tar -C "$TEMP_MEDIA" -xzf "$BACKUP_DIR/storage-public.tar.gz"
    if [[ ! -d "$TEMP_MEDIA/public" && ! -f "$TEMP_MEDIA/public" ]]; then
        if [[ -d "$TEMP_MEDIA/uploads" || "$(find "$TEMP_MEDIA" -mindepth 1 -maxdepth 1 | wc -l | tr -d ' ')" -gt 0 ]]; then
            :
        else
            echo "Restore verification failed: media archive appears empty." >&2
            rm -rf "$TEMP_MEDIA"
            exit 1
        fi
    fi
    rm -rf "$TEMP_MEDIA"
fi

"${DC[@]}" exec -T mysql sh -c "
    mysql -uroot -p\"\$MYSQL_ROOT_PASSWORD\" -e \"DROP DATABASE IF EXISTS \\\`$RESTORE_DB\\\`;\"
"

echo "agencies=$agencies"
echo "settings=$settings"
echo "S091 production restore smoke test passed."
echo "backup_dir=$BACKUP_DIR"
