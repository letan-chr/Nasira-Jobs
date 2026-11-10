<?php

namespace Tests\Unit;

use App\Support\GoogleRecaptcha;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GoogleRecaptchaTest extends TestCase
{
    public function test_disabled_when_keys_missing(): void
    {
        config([
            'app.google_recaptcha_site_key' => '',
            'app.google_recaptcha_secret' => '',
            'services.recaptcha.secret' => '',
        ]);

        $this->assertFalse(GoogleRecaptcha::isEnabled());
        $this->assertTrue(GoogleRecaptcha::verify('anything'));
    }

    public function test_siteverify_success_and_failure(): void
    {
        config([
            'app.google_recaptcha_site_key' => 'site',
            'app.google_recaptcha_secret' => 'secret',
            'services.recaptcha.secret' => 'secret',
        ]);

        // Setting may still be off in DB — force enabled path via Http only when isEnabled.
        // Simulate enabled by stubbing setting through a temporary key if present.
        \App\Models\Setting::query()->updateOrCreate(
            ['key' => 'enable_google_recaptcha'],
            ['value' => '1']
        );

        $this->assertTrue(GoogleRecaptcha::isEnabled());

        Http::fake([
            'www.google.com/recaptcha/api/siteverify' => Http::sequence()
                ->push(['success' => true], 200)
                ->push(['success' => false], 200),
        ]);

        $this->assertTrue(GoogleRecaptcha::verify('token-ok'));
        $this->assertFalse(GoogleRecaptcha::verify('token-bad'));
    }
}
