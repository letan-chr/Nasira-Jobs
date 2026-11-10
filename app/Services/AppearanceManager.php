<?php

namespace App\Services;

use App\Models\AppearanceSetting;
use Illuminate\Support\Facades\Cache;

class AppearanceManager
{
    public const CACHE_KEY = 'appearance.tokens';

    /**
     * @return array<string, string>
     */
    public function defaults(): array
    {
        return config('appearance.defaults', []);
    }

    /**
     * @return array<string, string>
     */
    public function tokens(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            $stored = AppearanceSetting::query()->latest('id')->value('tokens') ?? [];

            return array_merge($this->defaults(), is_array($stored) ? $stored : []);
        });
    }

    /**
     * @param  array<string, mixed>  $tokens
     * @return array<string, string>
     */
    public function update(array $tokens): array
    {
        $allowed = array_keys($this->defaults());
        $cleaned = [];

        foreach ($allowed as $key) {
            if (! array_key_exists($key, $tokens)) {
                continue;
            }

            $value = $tokens[$key];

            if (! is_string($value) || trim($value) === '') {
                continue;
            }

            $cleaned[$key] = trim($value);
        }

        $merged = array_merge($this->defaults(), $cleaned);

        $setting = AppearanceSetting::query()->latest('id')->first();

        if ($setting) {
            $setting->update(['tokens' => $merged]);
        } else {
            AppearanceSetting::query()->create(['tokens' => $merged]);
        }

        Cache::forget(self::CACHE_KEY);

        return $this->tokens();
    }

    /**
     * @return array<string, string>
     */
    public function reset(): array
    {
        AppearanceSetting::query()->delete();
        Cache::forget(self::CACHE_KEY);

        return $this->tokens();
    }

    /**
     * CSS variables ready to inject (maps font key → family stack).
     *
     * @return array<string, string>
     */
    public function cssVariables(): array
    {
        $tokens = $this->tokens();
        $fonts = config('appearance.fonts', []);
        $css = [];

        foreach ($tokens as $key => $value) {
            if ($key === 'font-sans') {
                $css['font-sans'] = $fonts[$value]['family']
                    ?? $fonts['Plus Jakarta Sans']['family']
                    ?? $value;
                $css['font-heading'] = $css['font-sans'];

                continue;
            }

            $css[$key] = $value;
        }

        // Map appearance tokens onto Nasira + Bootstrap CSS variables.
        $primary = $css['primary'] ?? '#006837';
        $css['nasira-green'] = $primary;
        $css['nasira-orange'] = $css['accent'] ?? '#f37021';
        $css['nasira-orange-hover'] = $this->darkenHex($css['nasira-orange'], 0.12);
        $css['nasira-text'] = $css['foreground'] ?? '#1e2b24';
        $css['nasira-muted'] = $css['muted-foreground'] ?? '#5f6e66';
        $css['nasira-nav'] = $css['foreground'] ?? '#2a3831';
        $css['nasira-font'] = $css['font-sans'];
        $css['bs-primary'] = $primary;
        $css['bs-primary-rgb'] = $this->hexToRgb($primary);

        return $css;
    }

    public function fontImportUrl(): ?string
    {
        $fontKey = $this->tokens()['font-sans'] ?? 'Plus Jakarta Sans';
        $fonts = config('appearance.fonts', []);

        return $fonts[$fontKey]['import'] ?? null;
    }

    /**
     * Schema for the Appearance admin form.
     *
     * @return array{groups: array<string, mixed>, fonts: array<int, array<string, mixed>>, token_meta: array<string, mixed>}
     */
    public function schema(): array
    {
        return [
            'groups' => config('appearance.groups', []),
            'fonts' => collect(config('appearance.fonts', []))
                ->map(fn (array $font, string $key) => [
                    'value' => $key,
                    'label' => $font['label'],
                    'family' => $font['family'],
                    'import' => $font['import'] ?? null,
                ])
                ->values()
                ->all(),
            'token_meta' => config('appearance.token_meta', []),
        ];
    }

    /**
     * Inline <style> block for Blade layouts (variables + real UI bindings).
     */
    public function inlineCss(): string
    {
        $vars = $this->cssVariables();
        $lines = [];

        foreach ($vars as $key => $value) {
            $lines[] = '--'.str_replace('_', '-', $key).': '.$value.';';
        }

        $root = ":root {\n  ".implode("\n  ", $lines)."\n}";

        $apply = <<<'CSS'
/* Base */
body {
  font-family: var(--font-sans) !important;
  color: var(--foreground);
  background-color: var(--background);
}

/* Brand / Bootstrap primary */
.text-primary,
a.text-primary { color: var(--primary) !important; }
.bg-primary { background-color: var(--primary) !important; }
.btn-primary,
.btn-primary:focus,
.btn-primary:active {
  background-color: var(--primary) !important;
  border-color: var(--primary) !important;
  color: var(--primary-foreground) !important;
}
.btn-primary:hover {
  background-color: var(--accent) !important;
  border-color: var(--accent) !important;
  color: var(--accent-foreground) !important;
}
.form-check-input:checked {
  background-color: var(--primary) !important;
  border-color: var(--primary) !important;
}
.nav-link.active, .nav-pills .nav-link.active {
  color: var(--primary) !important;
}

/* Admin sidebar */
.aside-menu-container {
  background-color: var(--sidebar) !important;
  border-color: var(--sidebar-border) !important;
  color: var(--sidebar-foreground) !important;
}
.aside-menu-container__aside-logo,
.aside-menu-container__aside-search .form-control {
  background-color: var(--sidebar) !important;
  color: var(--sidebar-foreground) !important;
  border-color: var(--sidebar-border) !important;
}
.aside-menu-container .navbar-brand-name,
.aside-menu-container .aside-menu-title,
.aside-menu-container .aside-menu-icon,
.aside-menu-container__aside-menubar,
.aside-menu-container__search-icon {
  color: var(--sidebar-foreground) !important;
}
.aside-menu-container__aside-menu .nav-item .nav-link {
  color: var(--sidebar-foreground) !important;
}
.aside-menu-container__aside-menu .nav-item:hover {
  background-color: var(--sidebar-accent) !important;
}
.aside-menu-container__aside-menu .nav-item:hover .nav-link,
.aside-menu-container__aside-menu .nav-item:hover .aside-menu-title,
.aside-menu-container__aside-menu .nav-item:hover .aside-menu-icon {
  color: var(--sidebar-accent-foreground) !important;
}
.aside-menu-container__aside-menu .nav-item.active {
  background-color: var(--sidebar-active) !important;
}
.aside-menu-container__aside-menu .nav-item.active .nav-link,
.aside-menu-container__aside-menu .nav-item.active .aside-menu-title,
.aside-menu-container__aside-menu .nav-item.active .aside-menu-icon {
  color: var(--sidebar-active-foreground) !important;
}

/* Admin top bar */
header.header,
.top-navbar,
#nav-header {
  background-color: var(--topbar) !important;
  color: var(--topbar-foreground) !important;
  border-color: var(--topbar-border) !important;
}
header.header .nav-link,
header.header .navbar-nav .nav-link,
.top-navbar .nav-link,
header.header .fa-solid,
header.header .fa-bell,
header.header .fa-moon,
header.header .fa-sun {
  color: var(--topbar-foreground) !important;
}
header.header .nav-link.active,
.top-navbar .nav-link.active,
header.header .nav-link:hover {
  color: var(--primary) !important;
}
.horizontal-submenu,
.dropdown-menu {
  border-color: var(--border) !important;
}

/* Public website header */
header.nasira-header {
  background-color: var(--topbar) !important;
  border-bottom-color: var(--topbar-border) !important;
  color: var(--topbar-foreground) !important;
}
header.nasira-header .nav-link,
header.nasira-header .nasira-nav-link {
  color: var(--topbar-foreground) !important;
}
header.nasira-header .nav-link:hover,
header.nasira-header .nav-link.active,
header.nasira-header .nasira-nav-link:hover,
header.nasira-header .nasira-nav-link.active {
  color: var(--primary) !important;
}
CSS;

        return $root."\n".$apply;
    }

    private function darkenHex(string $hex, float $amount): string
    {
        $hex = ltrim($hex, '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        if (strlen($hex) !== 6 || ! ctype_xdigit($hex)) {
            return '#e06215';
        }

        $r = max(0, (int) round(hexdec(substr($hex, 0, 2)) * (1 - $amount)));
        $g = max(0, (int) round(hexdec(substr($hex, 2, 2)) * (1 - $amount)));
        $b = max(0, (int) round(hexdec(substr($hex, 4, 2)) * (1 - $amount)));

        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }

    private function hexToRgb(string $hex): string
    {
        $hex = ltrim($hex, '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        if (strlen($hex) !== 6 || ! ctype_xdigit($hex)) {
            return '0, 104, 55';
        }

        return hexdec(substr($hex, 0, 2)).', '.hexdec(substr($hex, 2, 2)).', '.hexdec(substr($hex, 4, 2));
    }
}
