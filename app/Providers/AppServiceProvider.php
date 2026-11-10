<?php

namespace App\Providers;

use App\Models\Job;
use App\Observers\JobObserver;
use App\Support\FrontSeo;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Mariuzzo\LaravelJsLocalization\Commands\LangJsCommand;
use Mariuzzo\LaravelJsLocalization\Generators\LangJsGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Prevent hard 500s when Redis/Predis is misconfigured on a host.
        $cacheDriver = env('CACHE_DRIVER');
        $sessionDriver = env('SESSION_DRIVER');
        if (($cacheDriver === 'redis' || $sessionDriver === 'redis') && ! class_exists(\Predis\Client::class) && ! extension_loaded('redis')) {
            config([
                'cache.default' => 'file',
                'session.driver' => 'file',
            ]);
        }

        $this->app->singleton('localization.js', function ($app) {
            $app = $this->app;
            $laravelMajorVersion = (int) $app::VERSION;

            $files = $app['files'];

            if ($laravelMajorVersion === 4) {
                $langs = $app['path.base'].'/app/lang';
            } elseif ($laravelMajorVersion >= 5 && $laravelMajorVersion < 9) {
                $langs = $app['path.base'].'/resources/lang';
            } elseif ($laravelMajorVersion >= 9) {
                $langs = app()->langPath();
            }
            $messages = $app['config']->get('localization-js.messages');
            $generator = new LangJsGenerator($files, $langs, $messages);

            return new LangJsCommand($generator);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Pagination\Paginator::useBootstrap();
        Schema::defaultStringLength(191);
        app()->useLangPath(base_path('lang'));
        Job::observe(JobObserver::class);

        if ($this->isLocalHostRequest()) {
            // Local artisan serve is HTTP-only — never force HTTPS or secure cookies here.
            // Also pin the app root to the current local host so Livewire/DataTables
            // do not call https://nasirajobs.com and leave admin lists blank.
            config([
                'session.secure' => false,
                'app.force_https' => false,
            ]);
            URL::forceScheme('http');
            try {
                URL::forceRootUrl(request()->getSchemeAndHttpHost());
            } catch (\Throwable) {
                // Ignore during early boot edge cases.
            }
        } elseif ($this->shouldForceHttps()) {
            URL::forceScheme('https');
        }

        View::composer('front_web.layouts.app', function ($view) {
            $data = $view->getData();
            if (! empty($data['seo']) && is_array($data['seo'])) {
                return;
            }

            try {
                $view->with('seo', FrontSeo::forCurrentRoute());
            } catch (\Throwable) {
                // Keep pages rendering even if SEO helpers fail.
            }
        });
    }

    private function shouldForceHttps(): bool
    {
        if ($this->isLocalHostRequest()) {
            return false;
        }

        if (filter_var(config('app.force_https'), FILTER_VALIDATE_BOOLEAN)) {
            return true;
        }

        $url = (string) config('app.url');

        return app()->environment('production') && str_starts_with($url, 'https://');
    }

    private function isLocalHostRequest(): bool
    {
        if (app()->runningInConsole() && ! app()->runningUnitTests()) {
            return false;
        }

        try {
            $host = strtolower((string) request()->getHost());
        } catch (\Throwable) {
            return false;
        }

        return in_array($host, ['127.0.0.1', 'localhost', '::1'], true);
    }
}
