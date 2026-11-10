<?php

namespace App\Http\Middleware;

use Closure;
use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class XSS
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);

        array_walk_recursive($input, function (&$value) use ($purifier) {
            if (is_string($value)) {
                $value = $purifier->purify(html_entity_decode($value));
            }
        });

        $request->merge($input);

        return $next($request);
    }
}
