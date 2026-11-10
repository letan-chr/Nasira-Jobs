#!/usr/bin/env bash
# Nasira Jobs — production deploy helper (run from dist/jobs)
set -euo pipefail
cd "$(dirname "$0")/.."

echo "==> Checking .env..."
test -f .env || { echo ".env missing. Copy .env.example first."; exit 1; }

echo "==> Composer install (no-dev)..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "==> Migrate..."
php artisan migrate --force

echo "==> Storage link..."
php artisan storage:link || true

echo "==> Cache config / routes / views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Verify Redis..."
php artisan tinker --execute="Illuminate\\Support\\Facades\\Redis::connection()->ping();" >/dev/null \
  && echo "Redis OK" \
  || { echo "Redis ping failed — install/start Redis before go-live (CACHE/SESSION use redis)."; exit 1; }

echo "==> Done."
echo
echo "Domain: https://nasirajobs.com"
echo "Keep these running in production (Supervisor/systemd):"
echo "  php artisan queue:work database --sleep=3 --tries=3 --timeout=120"
echo "  Cron every minute: * * * * * php $(pwd)/artisan schedule:run"
echo "  php artisan telegram:backfill --limit=50"
echo "Fill MAIL_USERNAME/MAIL_PASSWORD and GOOGLE_RECAPTCHA_* before enabling captcha."
