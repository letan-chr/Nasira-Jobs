<?php

namespace App\Repositories;

use App\Models\EnvSetting;
use App\Models\Setting;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\MediaCollections\Exceptions\DiskDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

/**
 * Class SettingRepository
 */
class SettingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'key',
        'value',
    ];

    /**
     * {@inheritdoc}
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * {@inheritdoc}
     */
    public function model()
    {
        return Setting::class;
    }

    /**
     * @return mixed
     */
    public function getEnvData()
    {


        // $env = new DotenvEditor();
        // $key = $env->getContent();
        // // $data['mail'] = collect($key)->only([
        // //     'MAIL_MAILER', 'MAIL_HOST', 'MAIL_PORT', 'MAIL_USERNAME', 'MAIL_PASSWORD', 'MAIL_FROM_ADDRESS',
        // // ])->toArray();
        // $data['facebook'] = collect($key)->only([
        //     'FACEBOOK_APP_ID', 'FACEBOOK_APP_SECRET', 'FACEBOOK_REDIRECT',
        // ])->toArray();
        // $data['pusher'] = collect($key)->only([
        //     'PUSHER_APP_ID', 'PUSHER_APP_KEY', 'PUSHER_APP_SECRET', 'PUSHER_APP_CLUSTER',
        // ])->toArray();
        // $data['stripe'] = collect($key)->only([
        //     'STRIPE_KEY', 'STRIPE_SECRET', 'STRIPE_WEBHOOK_SECRET_KEY',
        // ])->toArray();
        // $data['paypal'] = collect($key)->only(['PAYPAL_CLIENT_ID', 'PAYPAL_SECRET'])->toArray();
        // $data['linkedIn'] = collect($key)->only(['LINKEDIN_CLIENT_ID', 'LINKEDIN_CLIENT_SECRET'])->toArray();
        // $data['google'] = collect($key)->only([
        //     'GOOGLE_CLIENT_ID', 'GOOGLE_CLIENT_SECRET', 'GOOGLE_REDIRECT',
        // ])->toArray();
        // $data['cookie'] = collect($key)->only(['COOKIE_CONSENT_ENABLED'])->toArray();

        // return $data;
    }

    /**
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function updateSetting(array $input): bool
    {

        $input['cookie_consent_enabled'] = empty($input['cookie_consent_enabled']) ?  false : true;

        $envSettingInputArray = Arr::only($input, [
            'facebook_app_id', 'facebook_app_secret', 'facebook_redirect','pusher_app_id', 'pusher_app_key','pusher_app_secret', 'pusher_app_cluster', 'stripe_key', 'stripe_secret', 'stripe_webhook_key', 'paypal_client_id', 'paypal_secret','paystack_key','paystack_secret','paystack_payment_url', 'linkedin_client_id', 'linkedin_client_secret', 'google_client_id', 'google_client_secret', 'google_redirect','cookie_consent_enabled'
        ]);



        foreach ($envSettingInputArray as $key => $value) {
            $value = is_null($value) ? '' : $value;
            $envSetting = EnvSetting::where('key', '=', $key)->first();

            if (empty($envSetting)) {
                EnvSetting::create([
                    'key' => $key,
                    'value' => $value,
                ]);

                continue;
            }
            $envSetting->update(['value' => $value]);
        }

        // $env = new DotenvEditor();
        $inputArr = Arr::except($input, ['_token']);

        if ($inputArr['sectionName'] == 'env_setting') {
            // $env->setAutoBackup(true);

            $envSetting = EnvSetting::pluck('value', 'key')->toArray();

            $envData = [
                // 'FACEBOOK_APP_ID' => (empty($envSetting['facebook_app_id'])) ? '' : $envSetting['facebook_app_id'],
                // 'FACEBOOK_APP_SECRET' => (empty($envSetting['facebook_app_secret'])) ? '' : $envSetting['facebook_app_secret'],
                // 'FACEBOOK_REDIRECT' => (empty($envSetting['facebook_redirect'])) ? '' : $envSetting['facebook_redirect'],
                // 'PUSHER_APP_ID' => (empty($envSetting['pusher_app_id'])) ? '' : $envSetting['pusher_app_id'],
                // 'PUSHER_APP_KEY' => (empty($envSetting['pusher_app_key'])) ? '' : $envSetting['pusher_app_key'],
                // 'PUSHER_APP_SECRET' => (empty($envSetting['pusher_app_secret'])) ? '' : $envSetting['pusher_app_secret'],
                // 'PUSHER_APP_CLUSTER' => (empty($envSetting['pusher_app_cluster'])) ? '' : $envSetting['pusher_app_cluster'],
                // 'STRIPE_KEY' => (empty($envSetting['stripe_key'])) ? '' : $envSetting['stripe_key'],
                // 'STRIPE_SECRET' => (empty($envSetting['stripe_secret'])) ? '' : $envSetting['stripe_secret'],
                // 'STRIPE_WEBHOOK_SECRET_KEY' => (empty($envSetting['stripe_webhook_key'])) ? '' : $envSetting['stripe_webhook_key'],
                // 'PAYPAL_CLIENT_ID' => (empty($envSetting['paypal_client_id'])) ? '' : $envSetting['paypal_client_id'],
                // 'PAYPAL_SECRET' => (empty($envSetting['paypal_secret'])) ? '' : $envSetting['paypal_secret'],
                // 'LINKEDIN_CLIENT_ID' => (empty($envSetting['linkedin_client_id'])) ? '' : $envSetting['linkedin_client_id'],
                // 'LINKEDIN_CLIENT_SECRET' => (empty($envSetting['linkedin_client_secret'])) ? '' : $envSetting['linkedin_client_secret'],
                // 'GOOGLE_CLIENT_ID' => (empty($envSetting['google_client_id'])) ? '' : $envSetting['google_client_id'],
                // 'GOOGLE_CLIENT_SECRET' => (empty($envSetting['google_client_secret'])) ? '' : $envSetting['google_client_secret'],
                // 'GOOGLE_REDIRECT' => (empty($envSetting['google_redirect'])) ? '' : $envSetting['google_redirect'],
                // 'COOKIE_CONSENT_ENABLED' => (isset($inputArr['cookie_consent_enabled'])) ? 'true' : 'false',
            ];

            // foreach ($envData as $key => $value) {
            //     $this->createOrUpdateEnv($env, $key, $value);
            // }
        }

        if ($inputArr['sectionName'] == 'social_settings') {
            $inputArr['facebook_url'] = (empty($inputArr['facebook_url'])) ? '' : $inputArr['facebook_url'];
            $inputArr['twitter_url'] = (empty($inputArr['twitter_url'])) ? '' : $inputArr['twitter_url'];
            $inputArr['google_plus_url'] = (empty($inputArr['google_plus_url'])) ? '' : $inputArr['google_plus_url'];
            $inputArr['linkedIn_url'] = (empty($inputArr['linkedIn_url'])) ? '' : $inputArr['linkedIn_url'];
        }
        if ($inputArr['sectionName'] == 'general') {
            $inputArr['enable_google_recaptcha'] = (! isset($inputArr['enable_google_recaptcha'])) ? false : $inputArr['enable_google_recaptcha'];
            $inputArr['job_approved'] = (! isset($inputArr['job_approved'])) ? 0 : 1;
        }

        if ($inputArr['sectionName'] == 'telegram') {
            $inputArr['telegram_enabled'] = (! isset($inputArr['telegram_enabled'])) ? 0 : 1;

            // Keep existing bot token when the password field is left blank.
            if (! filled($inputArr['telegram_bot_token'] ?? null)) {
                unset($inputArr['telegram_bot_token']);
            }

            if (isset($inputArr['telegram_channel_id'])) {
                $inputArr['telegram_channel_id'] = \App\Services\TelegramJobSyncService::normalizeChannelId(
                    (string) $inputArr['telegram_channel_id']
                ) ?? '';
            }
        }
        foreach ($inputArr as $key => $value) {
            /** @var Setting $setting */
            $setting = Setting::where('key', $key)->first();
            if (! $setting) {
                $setting = new Setting(['key' => $key, 'value' => $value]);
                $setting->save();
                continue;
            }

            if (in_array($key, ['logo', 'favicon', 'footer_logo']) && ! empty($value)) {
                $this->fileUpload($setting, $value);

                continue;
            }

            $setting->update(['value' => $value]);
        }

        return true;
    }

    /**
     * @return mixed
     *
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function fileUpload(Setting $setting, $file)
    {
        $setting->clearMediaCollection(Setting::PATH);
        $media = $setting->addMedia($file)->toMediaCollection(Setting::PATH, config('app.media_disc'));
        $setting->update(['value' => $media->getFullUrl()]);

        return $setting;
    }

    public function createOrUpdateEnv($env, $key, $value): bool
    {
        if (! $env->keyExists($key)) {
            $env->addData([
                $key => $value,
            ]);

            return true;
        }
        $env->changeEnv([
            $key => $value,
        ]);

        return true;
    }
}
