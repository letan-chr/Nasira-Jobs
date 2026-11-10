<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Redirect;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ADMIN_HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['guest', 'setLanguage'])->except('logout');
    }

    /**
     * @return Factory|View
     */
    protected function showAdminLoginForm()
    {
        // return view('auth.login');
        return view('front_web.auth.admin_login');
    }

//    /**
//     * @return Factory|View
//     */
//    protected function showLoginForm()
//    {
//        return view('web.auth.login');
//    }

    /**
     * Send the response after the user was authenticated.
     */
    protected function sendLoginResponse(Request $request): RedirectResponse
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if (Auth::user()->hasRole('Admin') || Auth::user()->can('access_admin_panel')) {
            $this->redirectTo = RouteServiceProvider::ADMIN_HOME;
        } elseif (Auth::user()->hasRole('Employer')) {
            $this->redirectTo = RouteServiceProvider::EMPLOYER_HOME;
        } elseif (Auth::user()->hasRole('Candidate')) {
            $this->redirectTo = RouteServiceProvider::CANDIDATE_HOME;
        } else {
            Auth::logout();

            return Redirect::to('/admin/login')
                ->withInput()
                ->withErrors([
                    'email' => __('auth.failed'),
                ]);
        }

        // Laravel's remember token handles session persistence.
        // Never store credentials in cookies — clear any legacy password cookies.
        $response = $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());

        return $response
            ->withCookie(\Cookie::forget('password'))
            ->withCookie(\Cookie::forget('remember'))
            ->withCookie(
                isset($request->remember)
                    ? \Cookie::make('email', $request->email, 60 * 24 * 30)
                    : \Cookie::forget('email')
            );
    }

    protected function showResetEmailPage()
    {
        return view('auth.passwords.email');
    }

    protected function showResetPassword(Request $request)
    {
        return view('auth.passwords.reset', ['request' => $request]);
    }
}
