#!/usr/bin/env bash

set -euo pipefail

PROJECT_DIR="${PROJECT_DIR:-/var/www/gs-autobilan}"
COMPOSE_FILE="${COMPOSE_FILE:-docker-compose.prod.yml}"
ENV_FILE="${ENV_FILE:-.env.docker}"
PUBLIC_URL="${PUBLIC_URL:-https://gsautobilan.com/up}"
DISK_WARN_PERCENT="${DISK_WARN_PERCENT:-85}"

FAIL=0

log_ok() {
    echo "[OK] $*"
}

log_warn() {
    echo "[WARN] $*"
}

log_fail() {
    echo "[FAIL] $*"
    FAIL=1
}

if [[ ! -d "$PROJECT_DIR" ]]; then
    log_fail "project directory missing: $PROJECT_DIR"
    exit "$FAIL"
fi

cd "$PROJECT_DIR"
DC=(docker compose -f "$COMPOSE_FILE" --env-file "$ENV_FILE")

for service in app nginx mysql redis worker scheduler; do
    if "${DC[@]}" ps --status running --services "$service" 2>/dev/null | grep -qx "$service"; then
        log_ok "container running: $service"
    else
        log_fail "container not running: $service"
    fi
done

if "${DC[@]}" exec -T mysql sh -c 'mysqladmin ping -h 127.0.0.1 -uroot -p"$MYSQL_ROOT_PASSWORD" --silent' >/dev/null 2>&1; then
    log_ok "mysql responds to ping"
else
    log_fail "mysql health check failed"
fi

HTTP_CODE="$(curl -sS -o /dev/null -w '%{http_code}' --max-time 15 "$PUBLIC_URL" || true)"
if [[ "$HTTP_CODE" == "200" ]]; then
    log_ok "health endpoint $PUBLIC_URL returned 200"
else
    log_fail "health endpoint $PUBLIC_URL returned ${HTTP_CODE:-000}"
fi

DISK_USE="$(df -P / | awk 'NR==2 {print $5}' | tr -d '%')"
if [[ "$DISK_USE" -lt "$DISK_WARN_PERCENT" ]]; then
    log_ok "root disk usage ${DISK_USE}%"
else
    log_warn "root disk usage ${DISK_USE}% (threshold ${DISK_WARN_PERCENT}%)"
fi

if command -v certbot >/dev/null 2>&1; then
    if sudo certbot certificates 2>/dev/null | grep -q "Certificate Name: gsautobilan.com"; then
        EXPIRY="$(sudo certbot certificates 2>/dev/null | awk '/Expiry Date/ {print $0; exit}')"
        log_ok "certbot certificate present (${EXPIRY})"
    else
        log_warn "certbot installed but gsautobilan.com certificate not found"
    fi
else
    log_warn "certbot not installed on host"
fi

exit "$FAIL"
