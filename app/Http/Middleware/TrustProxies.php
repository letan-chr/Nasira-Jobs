<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * Trust all proxies (Cloudflare / nginx / load balancers).
     * Restrict via TRUSTED_PROXIES env (comma-separated IPs) when possible.
     *
     * @var array<int, string>|string|null
     */
    protected $proxies;

    /**
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;

    public function __construct()
    {
        $configured = env('TRUSTED_PROXIES', '*');

        if ($configured === '*' || $configured === null || $configured === '') {
            $this->proxies = '*';
        } else {
            $this->proxies = array_values(array_filter(array_map('trim', explode(',', $configured))));
        }
    }
}
