# Nasira Jobs — production deploy helper (run from dist/jobs)
# Usage: powershell -ExecutionPolicy Bypass -File .\scripts\deploy-production.ps1

$ErrorActionPreference = "Stop"
Set-Location $PSScriptRoot\..

Write-Host "==> Checking APP_KEY / env..." -ForegroundColor Cyan
if (-not (Test-Path .env)) { throw ".env missing. Copy .env.example and fill secrets first." }

Write-Host "==> Composer install (no-dev)..." -ForegroundColor Cyan
composer install --no-dev --optimize-autoloader --no-interaction

Write-Host "==> Migrate..." -ForegroundColor Cyan
php artisan migrate --force

Write-Host "==> Storage link..." -ForegroundColor Cyan
php artisan storage:link

Write-Host "==> Verify Redis..." -ForegroundColor Cyan
php artisan tinker --execute="Illuminate\Support\Facades\Redis::connection()->ping();"
if ($LASTEXITCODE -ne 0) { throw "Redis ping failed. Install/start Redis (CACHE_DRIVER/SESSION_DRIVER=redis)." }

Write-Host "==> Cache config / routes / views..." -ForegroundColor Cyan
php artisan config:cache
php artisan route:cache
php artisan view:cache

Write-Host "==> Done." -ForegroundColor Green
Write-Host ""
Write-Host "Domain: https://nasirajobs.com" -ForegroundColor Yellow
Write-Host "Keep these running (Supervisor/NSSM/systemd):" -ForegroundColor Yellow
Write-Host "  php artisan queue:work database --sleep=3 --tries=3 --timeout=120"
Write-Host "  Cron every minute: php artisan schedule:run"
Write-Host "  php artisan telegram:backfill --limit=50"
Write-Host "Fill MAIL_USERNAME/MAIL_PASSWORD and GOOGLE_RECAPTCHA_* before enabling captcha."
