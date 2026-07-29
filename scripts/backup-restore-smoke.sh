#!/usr/bin/env bash

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
TMP_BASE="${TMPDIR:-/tmp}"
TMP_BASE="${TMP_BASE%/}"
WORK_DIR="${BACKUP_SMOKE_WORK_DIR:-$TMP_BASE/gs-autobilan-s079-backup-smoke}"
WORK_DIR="${WORK_DIR%/}"
SOURCE_DB="$WORK_DIR/source.sqlite"
RESTORED_DB="$WORK_DIR/restored.sqlite"
SOURCE_PUBLIC="$WORK_DIR/source-storage-public"
RESTORED_PUBLIC="$WORK_DIR/restored-storage-public"
BACKUP_DIR="$WORK_DIR/backup"
PROOF_FILE="uploads/s079-restore-proof.txt"

case "$WORK_DIR" in
    /tmp/* | /private/tmp/* | /var/folders/*) ;;
    *)
        echo "Refusing to clean non-temporary work directory: $WORK_DIR" >&2
        echo "Set BACKUP_SMOKE_WORK_DIR to a path under /tmp for this smoke test." >&2
        exit 1
        ;;
esac

rm -rf "$WORK_DIR"
mkdir -p "$BACKUP_DIR" "$SOURCE_PUBLIC/uploads" "$RESTORED_PUBLIC"
touch "$SOURCE_DB"

cd "$ROOT_DIR"

run_artisan() {
    APP_ENV=local \
    APP_DEBUG=false \
    APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA= \
    DB_CONNECTION=sqlite \
    DB_DATABASE="$SOURCE_DB" \
    CACHE_STORE=array \
    SESSION_DRIVER=array \
    QUEUE_CONNECTION=sync \
    php artisan "$@" --no-interaction
}

assert_sqlite_count_at_least() {
    local database="$1"
    local table="$2"
    local minimum="$3"

    php -r '
        [$script, $database, $table, $minimum] = $argv;
        if (! preg_match("/^[A-Za-z0-9_]+$/", $table)) {
            fwrite(STDERR, "Unsafe table name: {$table}\n");
            exit(1);
        }

        $pdo = new PDO("sqlite:{$database}");
        $count = (int) $pdo->query("select count(*) from {$table}")->fetchColumn();

        if ($count < (int) $minimum) {
            fwrite(STDERR, "{$table} restored count {$count}, expected at least {$minimum}\n");
            exit(1);
        }

        echo "{$table}={$count}\n";
    ' "$database" "$table" "$minimum"
}

run_artisan migrate --force >/dev/null
run_artisan db:seed --class=BaseDataSeeder --force >/dev/null

printf 'S079 restore proof\n' > "$SOURCE_PUBLIC/$PROOF_FILE"

cp "$SOURCE_DB" "$BACKUP_DIR/database.sqlite"
tar -C "$SOURCE_PUBLIC" -czf "$BACKUP_DIR/storage-public.tar.gz" .

php -r '
    [$script, $database] = $argv;
    $pdo = new PDO("sqlite:{$database}");
    $pdo->exec("delete from agencies");
' "$SOURCE_DB"
rm "$SOURCE_PUBLIC/$PROOF_FILE"

cp "$BACKUP_DIR/database.sqlite" "$RESTORED_DB"
tar -C "$RESTORED_PUBLIC" -xzf "$BACKUP_DIR/storage-public.tar.gz"

assert_sqlite_count_at_least "$RESTORED_DB" agencies 2
assert_sqlite_count_at_least "$RESTORED_DB" settings 3

if [[ "$(cat "$RESTORED_PUBLIC/$PROOF_FILE")" != "S079 restore proof" ]]; then
    echo "Restored media proof file did not match." >&2
    exit 1
fi

echo "S079 backup restore smoke test passed."
echo "work_dir=$WORK_DIR"
echo "backup_dir=$BACKUP_DIR"
