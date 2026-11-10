<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleRecaptcha
{
    public static function isEnabled(): bool
    {
        $settingOn = filter_var(getSettingValue('enable_google_recaptcha'), FILTER_VALIDATE_BOOLEAN)
            || getSettingValue('enable_google_recaptcha') === '1'
            || getSettingValue('enable_google_recaptcha') === 1;

        if (! $settingOn) {
            return false;
        }

        $site = trim((string) config('app.google_recaptcha_site_key'));
        $secret = trim((string) config('services.recaptcha.secret', config('app.google_recaptcha_secret')));

        return $site !== '' && $secret !== '';
    }

    public static function verify(?string $token, ?string $ip = null): bool
    {
        if (! self::isEnabled()) {
            return true;
        }

        $token = trim((string) $token);
        if ($token === '') {
            return false;
        }

        $secret = trim((string) config('services.recaptcha.secret', config('app.google_recaptcha_secret')));

        try {
            $response = Http::asForm()
                ->timeout(8)
                ->post('https://www.google.com/recaptcha/api/siteverify', array_filter([
                    'secret' => $secret,
                    'response' => $token,
                    'remoteip' => $ip,
                ]));

            if (! $response->ok()) {
                Log::warning('reCAPTCHA siteverify HTTP failure', ['status' => $response->status()]);

                return false;
            }

            $payload = $response->json();

            return (bool) ($payload['success'] ?? false);
        } catch (\Throwable $e) {
            Log::warning('reCAPTCHA siteverify exception', ['error' => $e->getMessage()]);

            return false;
        }
    }
}
