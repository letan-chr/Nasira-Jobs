# Persistent queue worker for Nasira Jobs (run under NSSM/Task Scheduler on the server)
# Usage: powershell -ExecutionPolicy Bypass -File .\scripts\queue-worker.ps1

$ErrorActionPreference = "Stop"
Set-Location $PSScriptRoot\..

Write-Host "Starting queue worker (Ctrl+C to stop)..." -ForegroundColor Cyan
php artisan queue:work database --sleep=3 --tries=3 --timeout=120 --memory=256
