<?php

namespace App\Providers;

use App\Providers\SocialAuthProviders\FacebookAuthProvider;
use App\Providers\SocialAuthProviders\GoogleAuthProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Socialite;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Socialite::extend('google', function ($app) {
            $config = $this->app['config']['services.google'];
            $clientId =  !empty(getEnvSetting()['google_client_id']) ? getEnvSetting()['google_client_id'] : config('services.google.client_id');
            $clientSecret =  !empty(getEnvSetting()['google_client_secret']) ? getEnvSetting()['google_client_secret'] : config('services.google.client_secret');
            $redirect =  !empty(getEnvSetting()['google_redirect']) ? getEnvSetting()['google_redirect'] : config('services.google.redirect');

            return new GoogleAuthProvider(
                $app['request'],
                $clientId ,
                $clientSecret,
                $redirect,
            );
        });

        Socialite::extend('facebook', function ($app) {
            $config = $this->app['config']['services.facebook'];
            $clientId =  !empty(getEnvSetting()['facebook_app_id']) ? getEnvSetting()['facebook_app_id'] : config('services.facebook.client_id');
            $clientSecret =  !empty(getEnvSetting()['facebook_app_secret']) ? getEnvSetting()['facebook_app_secret'] : config('services.facebook.client_secret');
            $redirect =  !empty(getEnvSetting()['facebook_redirect']) ? getEnvSetting()['facebook_redirect'] : config('services.facebook.redirect');

            return new FacebookAuthProvider(
                $app['request'],
                $clientId ,
                $clientSecret,
                $redirect,
            );
        });
    }
}
