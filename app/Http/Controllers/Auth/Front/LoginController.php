<?php

namespace App\Http\Controllers\Auth\Front;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
        $this->middleware('guest')->except('logout');
    }

    /**
     * @return Factory|View
     */
    protected function showAdminLoginForm()
    {
        return view('auth.login');
    }

//    /**
//     * @return Factory|View
//     */
//    protected function showLoginForm()
//    {
//        return view('web.auth.login');
//    }

    /**
     * @return Factory|View
     */
    protected function employeeLogin()
    {
        // Unified public login — role is detected after authentication.
        return view('front_web.auth.candidate_login');
    }

    /**
     * @return Factory|View
     */
    protected function candidateLogin()
    {
        return view('front_web.auth.candidate_login');
    }

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

            return redirect()->back()->withInput()->withErrors([
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
}
