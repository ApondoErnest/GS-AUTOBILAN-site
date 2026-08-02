#!/usr/bin/env bash

set -euo pipefail

BASE_URL="${BASE_URL:-https://gsautobilan.com}"
FAIL=0

check_http() {
    local label="$1"
    local url="$2"
    local expected="${3:-200}"
    local code

    code="$(curl -sS -o /dev/null -w '%{http_code}' --max-time 20 "$url" || true)"

    if [[ "$code" == "$expected" ]]; then
        echo "[OK] $label ($code) $url"
    else
        echo "[FAIL] $label expected $expected got ${code:-000} $url"
        FAIL=1
    fi
}

echo "S092 pre-launch checks against $BASE_URL"
echo

check_http "health" "$BASE_URL/up"
check_http "homepage FR" "$BASE_URL/fr/accueil"
check_http "homepage EN" "$BASE_URL/en/home"
check_http "admin login" "$BASE_URL/admin/login"
check_http "booking FR" "$BASE_URL/fr/rendez-vous"
check_http "tracking FR" "$BASE_URL/fr/suivi-rendez-vous"
check_http "contact FR" "$BASE_URL/fr/contact"
check_http "tariffs FR" "$BASE_URL/fr/tarifs"
check_http "sitemap" "$BASE_URL/sitemap.xml"
check_http "robots" "$BASE_URL/robots.txt"

ROBOTS="$(curl -sS --max-time 20 "$BASE_URL/robots.txt" || true)"
if echo "$ROBOTS" | grep -q 'Disallow: /admin'; then
    echo "[OK] robots.txt disallows /admin"
else
    echo "[FAIL] robots.txt missing Disallow: /admin"
    FAIL=1
fi

if echo "$ROBOTS" | grep -q 'Sitemap:'; then
    echo "[OK] robots.txt references sitemap"
else
    echo "[FAIL] robots.txt missing Sitemap line"
    FAIL=1
fi

HTTP_ROOT="$(curl -sS -o /dev/null -w '%{http_code} %{redirect_url}' --max-time 20 "http://gsautobilan.com/" || true)"
if echo "$HTTP_ROOT" | grep -qE '^30[18] https://'; then
    echo "[OK] HTTP redirects to HTTPS ($HTTP_ROOT)"
else
    echo "[WARN] HTTP redirect check: $HTTP_ROOT"
fi

echo
if [[ "$FAIL" -eq 0 ]]; then
    echo "S092 automated public checks passed."
else
    echo "S092 automated public checks failed."
fi

exit "$FAIL"
