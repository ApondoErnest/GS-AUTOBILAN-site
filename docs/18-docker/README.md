# Docker preparation — V1

**Version:** 1.4 · **Steps:** S087–S090 · **S088 completed:** 2026-07-31

## Two Compose stacks

| File | Environment | Build |
|------|-------------|-------|
| [docker-compose.yml](../../docker-compose.yml) | **Local dev (S088)** | `target: dev` — bind mounts, host or container asset build |
| [docker-compose.prod.yml](../../docker-compose.prod.yml) | **Production VPS (S090)** | Multi-stage — `vendor/` + Vite baked into images |

## Dev stack (S088)

| Service | Image / build | Role |
|---------|---------------|------|
| **app** | `docker/php/Dockerfile` (`dev`) | PHP 8.4-FPM · Laravel |
| **nginx** | `nginx:1.27-alpine` | Web server → `app:9000` |
| **mysql** | `mysql:8.4` | Database (volume `mysql_data`) |
| **redis** | `redis:7-alpine` | Cache + queue |
| **worker** | same as app | `queue:work redis` |
| **scheduler** | same as app | `schedule:run` every 60s |

### Dev quick start

```bash
cd /path/to/GS-AUTOBILAN
cp .env.docker.example .env.docker
# Set APP_KEY in .env.docker:
#   docker compose --env-file .env.docker run --rm app php artisan key:generate --show
docker compose --env-file .env.docker up -d --build
docker compose --env-file .env.docker exec app composer install --no-interaction
docker compose --env-file .env.docker exec app php artisan migrate --force
docker compose --env-file .env.docker exec app php artisan db:seed --force
npm ci && npm run build   # on host — dev PHP image has no Node
docker compose --env-file .env.docker up -d --force-recreate app worker scheduler nginx
```

Default URL: **http://127.0.0.1:8080** (`DOCKER_HTTP_PORT` in `.env.docker`)

Host MySQL port **3307** avoids clashing with local Homebrew MySQL on 3306.

### Dev volumes

- `mysql_data`, `redis_data`
- `vendor_data`, `node_modules_data` — Linux deps inside containers
- `storage_app`, `storage_logs` — uploads and logs

## Production stack (S090)

Multi-stage build order: **Composer → Node/Vite → runtime images**.

| Target | Role |
|--------|------|
| `composer-build` | `vendor/` (Filament available for Vite) |
| `frontend-build` | `public/build/` |
| `app-production` | PHP-FPM, worker, scheduler |
| `nginx-production` | Static assets + PHP proxy to `app:9000` |

Production characteristics:

- No bind mount of source code
- MySQL and Redis **not** exposed on host ports
- Docker Nginx listens on **`127.0.0.1:8080` only**
- Host Nginx + Certbot handle domain and HTTPS
- Single `storage_data` volume for uploads and logs

### Production quick start (VPS)

```bash
cd /var/www/gs-autobilan
cp .env.docker.production.example .env.docker
# Set APP_KEY, DB passwords, GS_SUPER_ADMIN_PASSWORD — chmod 600 .env.docker

docker compose -f docker-compose.prod.yml --env-file .env.docker config --quiet
docker compose -f docker-compose.prod.yml --env-file .env.docker build app nginx

docker compose -f docker-compose.prod.yml --env-file .env.docker up -d mysql redis
docker compose -f docker-compose.prod.yml --env-file .env.docker up -d

docker compose -f docker-compose.prod.yml --env-file .env.docker exec app php artisan migrate --force
docker compose -f docker-compose.prod.yml --env-file .env.docker exec app php artisan db:seed --force
docker compose -f docker-compose.prod.yml --env-file .env.docker exec app php artisan optimize
docker compose -f docker-compose.prod.yml --env-file .env.docker restart worker scheduler
```

Install host Nginx from [host-reverse-proxy.conf.example](../../docker/nginx/host-reverse-proxy.conf.example), then Certbot.

Verify baked assets after build:

```bash
docker run --rm --entrypoint sh gs-autobilan-app:latest \
  -c 'test -f vendor/filament/filament/resources/css/theme.css && test -f public/build/manifest.json && echo OK'
```

### Future production deploys

```bash
git pull origin main
docker compose -f docker-compose.prod.yml --env-file .env.docker build app nginx
docker compose -f docker-compose.prod.yml --env-file .env.docker up -d --force-recreate app nginx worker scheduler
docker compose -f docker-compose.prod.yml --env-file .env.docker exec app php artisan migrate --force
docker compose -f docker-compose.prod.yml --env-file .env.docker exec app php artisan optimize
docker compose -f docker-compose.prod.yml --env-file .env.docker restart worker scheduler
```

Never run `docker compose down -v` on production — it deletes MySQL and storage volumes.

## Files

| File | Purpose |
|------|---------|
| [docker-compose.yml](../../docker-compose.yml) | Dev services + bind mounts |
| [docker-compose.prod.yml](../../docker-compose.prod.yml) | Production services |
| [docker/php/Dockerfile](../../docker/php/Dockerfile) | Multi-stage: `dev`, `app-production`, `nginx-production` |
| [docker/php/entrypoint.sh](../../docker/php/entrypoint.sh) | Dev entrypoint |
| [docker/php/entrypoint.prod.sh](../../docker/php/entrypoint.prod.sh) | Production entrypoint (`gosu` for workers, root for FPM) |
| [docker/nginx/default.conf](../../docker/nginx/default.conf) | Dev Nginx config |
| [docker/nginx/default.prod.conf](../../docker/nginx/default.prod.conf) | Production Nginx (`/storage/`, forwarded headers) |
| [docker/nginx/host-reverse-proxy.conf.example](../../docker/nginx/host-reverse-proxy.conf.example) | VPS host Nginx template |
| [.env.docker.example](../../.env.docker.example) | Dev env template |
| [.env.docker.production.example](../../.env.docker.production.example) | Production env template |

## Acceptance

- **S087:** Compose + Docker files exist for all required services ✓
- **S088:** Site and `/admin` work in containers; DB and media persist across restarts ✓
- **S090:** HTTPS on VPS; production images; no public DB/Redis ports
