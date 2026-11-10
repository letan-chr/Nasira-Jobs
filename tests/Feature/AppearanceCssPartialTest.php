<?php

namespace Tests\Feature;

use Tests\TestCase;

class AppearanceCssPartialTest extends TestCase
{
    public function test_auth_layout_includes_appearance_partial(): void
    {
        $path = resource_path('views/layouts/auth.blade.php');
        $this->assertFileExists($path);
        $this->assertStringContainsString("partials.appearance-css", file_get_contents($path));
    }

    public function test_front_layout_includes_appearance_partial(): void
    {
        $path = resource_path('views/front_web/layouts/app.blade.php');
        $this->assertFileExists($path);
        $this->assertStringContainsString("partials.appearance-css", file_get_contents($path));
    }
}
