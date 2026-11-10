<?php

namespace App\Http\Controllers\Auth\Front;

use App\Http\Controllers\AppBaseController;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\SocialAccount;
use App\Providers\RouteServiceProvider;
use App\Providers\SocialAuthProviders\GoogleAuthProvider;
use App\Repositories\SocialAuthRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;

/**
 * Class SocialAuthController
 */
class SocialAuthController extends AppBaseController
{
    /** @var SocialAuthRepository */
    private $socialAuthRepo;

    public const EMPLOYEE_TYPE = 0;

    public function __construct(SocialAuthRepository $socialAuthRepo)
    {
        $this->socialAuthRepo = $socialAuthRepo;
    }

    public function redirect(string $provider, Request $request): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        Cache::put('type', $request->get('type'));

        /** @var GoogleAuthProvider $driver */
        return Socialite::driver($provider)->redirect();
    }

    /**
     * @return RedirectResponse|Redirector
     */
    public function callback(string $provider, Request $request): RedirectResponse
    {
        $socialUser = null;
        switch ($provider) {
            case SocialAccount::GOOGLE_PROVIDER:
                $accessToken = $request->get('code');
                $socialUser = $this->socialAuthRepo->getGoogleUserByToken($accessToken);
                break;

            case SocialAccount::FACEBOOK_PROVIDER:
                $accessToken = $request->get('code');
                $socialUser = $this->socialAuthRepo->getFacebookUserByToken($accessToken);
                break;

            case SocialAccount::LINKEDIN_PROVIDER:
                $accessToken = $request->get('code');
                $socialUser = $this->socialAuthRepo->getLinkedinUserByToken($accessToken);
                $socialUser = $socialUser->attributes;
                break;
        }

        $user = $this->socialAuthRepo->handleSocialUser($provider, $socialUser);
        $type = Cache::get('type', 1);

        Auth::loginUsingId($user->id, true);

        if (Auth::user()->hasRole('Candidate') && $type == Candidate::CANDIDATE_LOGIN_TYPE) {
            return redirect(RouteServiceProvider::CANDIDATE_HOME);
        }
        if (Auth::user()->hasRole('Employer') && $type == Candidate::CANDIDATE_EMP_TYPE) {
            return redirect(RouteServiceProvider::EMPLOYER_HOME);
        }

        Auth::logout();
        $section = ($type == Company::COMPANY_LOGIN_TYPE) ? 'employee-login' : 'candidate-login';

        return Redirect::to('/users/' . $section)
            ->withInput()
            ->withErrors([
                'error' => __('auth.failed'),
            ]);
    }
}
