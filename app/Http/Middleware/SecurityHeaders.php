<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        $isLocalHost = in_array(strtolower((string) $request->getHost()), ['127.0.0.1', 'localhost', '::1'], true);

        // Never send HSTS/CSP on local artisan serve — browsers lock onto HTTPS and blank admin Livewire tables.
        if ($isLocalHost) {
            return $response;
        }

        if (config('app.env') === 'production' && config('app.csp_enabled', true)) {
            $csp = implode('; ', [
                "default-src 'self'",
                "base-uri 'self'",
                "form-action 'self'",
                "frame-ancestors 'self'",
                "img-src 'self' data: blob: https:",
                "font-src 'self' data: https://fonts.gstatic.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net",
                "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net",
                "script-src 'self' 'unsafe-inline' 'unsafe-eval' 'wasm-unsafe-eval' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://staticimgly.com https://www.google.com https://www.gstatic.com",
                "connect-src 'self' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://staticimgly.com https://www.google.com blob: data:",
                "worker-src 'self' blob:",
                "child-src 'self' blob:",
                "media-src 'self' blob: data:",
                "frame-src 'self' https://www.google.com https://www.gstatic.com",
            ]);
            $response->headers->set('Content-Security-Policy', $csp);
        }

        if ($request->isSecure() || filter_var(config('app.force_https'), FILTER_VALIDATE_BOOLEAN)) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
