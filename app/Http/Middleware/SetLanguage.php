<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class SetLanguage
{
    /**
     * use Illuminate\Support\Facades\Session;
     */
    public function handle(Request $request, Closure $next): Response
    {
        $localeLanguage = Session::get('languageName');
        $default = Setting::where('key', '=', 'default_language')->first();

        if (! isset($localeLanguage)) {

            if (Auth::user()) {
                App::setLocale(Auth::user()->language);
            }else{
                App::setLocale($default->value);
            }

        } else {
            if (Auth::user()) {
                if(isset($localeLanguage)){
                    // dump(56456);
                    App::setLocale($localeLanguage);
                }else{
                    App::setLocale(Auth::user()->language);
                }
            }else{
                App::setLocale($localeLanguage);
            }
        }

        return $next($request);
    }
}
