<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserIsVerified
{
         /**
          * Handle an incoming request.
          */
         public function handle(Request $request, Closure $next): Response
         {
                  $response = $next($request);
                  $user = Auth::user();
                  if (Auth::check() && !$user->is_active) {
                           Auth::logout();
                           return redirect()->back()->withErrors(__('messages.flash.account_not_active'));
                  } elseif (Auth::check() && !$user->email_verified_at) {
                           Auth::logout();
                           return redirect()->back()->withErrors(__('messages.flash.verify_email'));
                  }

                  return $response;
         }
}
