<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                /** @var User $user */
                $user = Auth::user();
                if ($user->hasRole('Admin') || $user->can('access_admin_panel')) {
                    return \Redirect::to(RouteServiceProvider::ADMIN_HOME);
                }

                if ($user->hasRole('Employer')) {
                    return \Redirect::to(RouteServiceProvider::EMPLOYER_HOME);
                }

                if ($user->hasRole('Candidate')) {
                    return \Redirect::to(RouteServiceProvider::CANDIDATE_HOME);
                }

                return $next($request);
            }
        }

        return $next($request);
    }
}
