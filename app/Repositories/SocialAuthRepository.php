<?php

namespace App\Repositories;

use App;
use App\Models\SocialAccount;
use App\Models\User;
use App\Providers\SocialAuthProviders\FacebookAuthProvider;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Cache;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class SocialAuthRepository
 */
class SocialAuthRepository
{
    /** @var webRegisterRepository */
    private $webRegisterRepository;

    public function __construct()
    {
        $this->webRegisterRepository = App::make(WebRegisterRepository::class);
    }

    public function handleSocialUser(string $provider, array $socialUser): User
    {
        $userData = [];

        try {
            switch (strtolower($provider)) {
                case SocialAccount::GOOGLE_PROVIDER:
                    $userData = $this->prepareGoogleUserData($socialUser);
                    break;

                case SocialAccount::FACEBOOK_PROVIDER:
                    $userData = $this->prepareFacebookUserData($socialUser);
                    break;

                case SocialAccount::LINKEDIN_PROVIDER:
                    $userData = $this->prepareLinkedinUserData($socialUser);
                    break;
            }
            $user = User::whereRaw('lower(email) = ?', strtolower($userData['email']))->first();
            $existingProfile = null;
            if (! empty($user)) {
                /** @var SocialAccount $existingProfile */
                $existingProfile = SocialAccount::whereUserId($user->id)->first();
            }

            if (empty($user)) {
                $userData['first_name'] = $provider == 'linkedin-openid' ? $userData['first_name'] : $userData['name'];
                $userData['email_verified_at'] = Carbon::now();
                $userData['password'] = uniqid();
                $userData['is_active'] = true;
                $userData['type'] = Cache::get('type');
                $this->webRegisterRepository->store($userData);
                $user = User::whereRaw('lower(email) = ?', strtolower($userData['email']))->first();
            }

            if (empty($existingProfile)) {
                $socialAccount = new SocialAccount();
                $socialAccount->user_id = $user->id;
                $socialAccount->provider = $provider;
                $socialAccount->provider_id = $userData['provider_id'];
                $socialAccount->save();
            }

            return $user;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @return array|mixed
     */
    public function getGoogleUserByToken(string $token)
    {
        /** @var App\Providers\SocialAuthProviders\GoogleAuthProvider $driver */
        $driver = Socialite::driver('google');
        $driver->setHttpClient(new \GuzzleHttp\Client(['verify' => true]));
        $token = $driver->getAccessTokenResponse($token);
        $user = $driver->getUserByToken($token['access_token']);

        return $user;
    }

    public function prepareGoogleUserData(array $user): array
    {
        return [
            'name' => $user['name'],
            'email' => $user['email'],
            'provider_id' => $user['sub'],
            // extra details into $user picture (photo) ,email_verified (is email verified),name (full name)
        ];
    }

    /**
     * @return array|mixed
     */
    public function getFacebookUserByToken(string $token)
    {
        /** @var FacebookAuthProvider $driver */
        $driver = Socialite::driver('facebook');
        $driver = $driver->fields(SocialAccount::facebookFields());

        $token = $driver->getAccessTokenResponse($token);

        $user = $driver->getUserByToken($token['access_token']);

        return $user;
    }

    public function prepareFacebookUserData($user): array
    {
        return [
            'name' => $user['name'],
            'email' => $user['email'],
            'provider_id' => $user['id'],
        ];
    }

    /**
     * @return array|mixed
     */
    public function getLinkedinUserByToken($token)
    {

        /** @var FacebookAuthProvider $driver */
        $driver = Socialite::driver('linkedin-openid');

        $token = $driver->getAccessTokenResponse($token);

        return $driver->userFromToken($token['access_token']);
    }

    public function prepareLinkedinUserData($user): array
    {
        // dd($user['first_name']);
        return [
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => isset($user['email']) ? $user['email'] : '',
            'provider_id' => $user['last_name'],
        ];
    }
}
