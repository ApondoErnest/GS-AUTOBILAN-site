# Docker preparation — V1

**Version:** 1.3 · **Steps:** S087–S088 · **S088 completed:** 2026-07-31

## Stack (Compose)

| Service | Image / build | Role |
|---------|---------------|------|
| **app** | `docker/php/Dockerfile` | PHP 8.4-FPM · Laravel |
| **nginx** | `nginx:1.27-alpine` | Web server → `app:9000` |
| **mysql** | `mysql:8.4` | Database (volume `mysql_data`) |
| **redis** | `redis:7-alpine` | Cache + queue |
| **worker** | same as app | `queue:work redis` |
| **scheduler** | same as app | `schedule:run` every 60s |

Optional later (dev): Adminer / phpMyAdmin

## Files

| File | Purpose |
|------|---------|
| [../../docker-compose.yml](../../docker-compose.yml) | Service definitions + volumes |
| [../../docker/php/Dockerfile](../../docker/php/Dockerfile) | PHP extensions (MySQL, Redis, GD, …) |
| [../../docker/php/entrypoint.sh](../../docker/php/entrypoint.sh) | Composer install if needed · `storage:link` · storage permissions |
| [../../docker/nginx/default.conf](../../docker/nginx/default.conf) | Nginx → `public/` |
| [../../.env.docker.example](../../.env.docker.example) | Container env template |

## Persisted volumes

- `mysql_data` — database
- `redis_data` — Redis AOF
- `storage_app` — uploads / media under `storage/app`
- `storage_logs` — application logs
- `vendor_data` / `node_modules_data` — Linux deps inside containers (not host Mac vendor)

## Quick start (S088 verification)

```bash
cd /Users/admin/GS-AUTOBILAN
cp .env.docker.example .env.docker
# Set APP_KEY in .env.docker (must be in this file — not only .env):
#   docker compose --env-file .env.docker run --rm app php artisan key:generate --show
# Add GS_SUPER_ADMIN_PASSWORD=... for db:seed
docker compose --env-file .env.docker up -d --build
docker compose --env-file .env.docker exec app composer install --no-interaction
docker compose --env-file .env.docker exec app php artisan migrate --force
docker compose --env-file .env.docker exec app php artisan db:seed --force
npm ci && npm run build   # on host — PHP image has no Node
docker compose --env-file .env.docker up -d --force-recreate app worker scheduler nginx
```

`.env.docker` overrides `.env.docker.example` in Compose (later file wins). After changing `APP_KEY`, recreate app containers so env reloads.

Default URL: **http://127.0.0.1:8080** (`DOCKER_HTTP_PORT` in `.env.docker`)

Host MySQL port **3307** avoids clashing with local Homebrew MySQL on 3306.

## Environments

Separate configs: **docker-dev** (this stack) · staging · production — see [../03-local-environment/02-environments.md](../03-local-environment/02-environments.md)

## Acceptance

- **S087:** Compose + Docker files exist for all required services ✓
- **S088:** Site and `/admin` work in containers; DB and media persist across restarts ✓

Project runs containerized without changing core application logic.
