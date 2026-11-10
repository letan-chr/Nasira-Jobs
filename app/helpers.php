<?php

use App\Models\City;
use App\Models\Company;
use App\Models\Country;
use App\Models\EnvSetting;
use App\Models\Job;
use App\Models\Language;
use App\Models\Notification;
use App\Models\Plan;
use App\Models\SalaryCurrency;
use App\Models\Setting;
use App\Models\State;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Spatie\SchemaOrg\Schema;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Stripe\StripeClient;

/**
 * @return int
 */
if (! function_exists('getLoggedInUserId')) {
    function getLoggedInUserId()
    {
        return Auth::id();
    }
}

/**
 * @return User
 */
if (! function_exists('getLoggedInUser')) {
    function getLoggedInUser()
    {
        return Auth::user();
    }
}

if (! function_exists('formatNumber')) {
    function formatNumber($number)
    {
        return round(str_replace(',', '', $number), 2);
    }
}

if (! function_exists('dashboardURL')) {
    function dashboardURL()
    {
        if (Auth::user()->hasRole('Admin') || Auth::user()->can('access_admin_panel')) {
            return URL::to(RouteServiceProvider::ADMIN_HOME);
        } else {
            if (Auth::user()->hasRole('Employer')) {
                return URL::to(RouteServiceProvider::EMPLOYER_HOME);
            } elseif (Auth::user()->hasRole('Candidate')) {
                return URL::to(RouteServiceProvider::CANDIDATE_HOME);
            }
        }
    }
}

/**
 * @return string|string[]
 */
if (! function_exists('removeCommaFromNumbers')) {
    function removeCommaFromNumbers($number)
    {
        return (gettype($number) == 'string' && ! empty($number)) ? str_replace(',', '', $number) : $number;
    }
}

if (! function_exists('settings')) {
    function settings()
    {
        return Setting::toBase()->pluck('value', 'key')->toArray();
    }
}

/**
 * @return mixed
 */
if (! function_exists('getSettingValue')) {
    function getSettingValue($key)
    {
        $settingValue = Setting::where('key', $key)->value('value');

        if ($settingValue == 'favicon.ico') {
            return asset($settingValue);
        }

        return $settingValue;
    }
}

/**
 * @return mixed
 */
if (! function_exists('getCountryName')) {
    function getCountryName($country)
    {
        if (empty($country)) {
            return;
        }

        return Country::find($country)->name;
    }
}

/**
 * return avatar url.
 *
 * @return string
 */
if (! function_exists('getAvatarUrl')) {
    function getAvatarUrl()
    {
        return '//ui-avatars.com/api/';
    }
}

/**
 * return avatar full url.
 *
 * @param  int  $userId
 * @param  string  $name
 * @return string
 */
if (! function_exists('getUserImageInitial')) {
    function getUserImageInitial($userId, $name)
    {
        return getAvatarUrl()."?name=$name&size=100&rounded=true&color=fff&background=".getRandomColor($userId);
    }
}

/**
 * return random color.
 *
 * @param  int  $userId
 * @return string
 */
if (! function_exists('getRandomColor')) {
    function getRandomColor($userId)
    {
        $colors = ['329af0', 'fc6369', 'ffaa2e', '42c9af', '7d68f0'];
        $index = $userId % 5;

        return $colors[$index];
    }
}

if (! function_exists('getUniqueCompanyId')) {
    function getUniqueCompanyId()
    {
        $companyUniqueId = Str::random(12);
        while (true) {
            $isExist = Company::whereUniqueId($companyUniqueId)->exists();
            if ($isExist) {
                getUniqueCompanyId();
            }
            break;
        }

        return $companyUniqueId;
    }
}

/**
 * @return mixed
 */
if (! function_exists('getLogoUrl')) {
    function getLogoUrl()
    {
        static $appLogo;

        if (empty($appLogo)) {
            $appLogo = Setting::where('key', '=', 'logo')->first();
        }

        if (empty($appLogo)) {
            return asset('front_web/images/nasira-logo.png');
        }

        return $appLogo->logo_url;
    }
}

if (! function_exists('getAppName')) {
    function getAppName()
    {
        static $appName;

        if (empty($appName)) {
            $appName = Setting::where('key', '=', 'application_name')->first();
        }

        return $appName->value;
    }
}

/**
 * Accessor for Age.
 *
 * @return int
 */
if (! function_exists('getAgeCount')) {
    function getAgeCount($date)
    {
        return Carbon::parse($date)->age;
    }
}

/**
 * @return string
 */
if (! function_exists('getShiftClass')) {
    function getShiftClass($id)
    {
        $class = [
            'btn btn-green btn-small btn-effect',
            'btn btn-purple btn-small btn-effect',
            'btn btn-blue btn-small btn-effect',
            'btn btn-orange btn-small btn-effect',
            'btn btn-red btn-small btn-effect',
            'btn btn-blue-grey btn-small btn-effect',
            'btn btn-green btn-small btn-effect',
        ];
        $index = $id % 7;

        return $class[$index];
    }
}
/**
 * @return array
 */
if (! function_exists('getCountries')) {
    function getCountries()
    {
        return Country::orderBy('name')->pluck('name', 'id')->toArray();
    }
}

if (! function_exists('getDefaultCountryId')) {
    /**
     * Default country for new forms/selects (Ethiopia).
     */
    function getDefaultCountryId(): ?int
    {
        static $countryId;

        if ($countryId !== null) {
            return $countryId ?: null;
        }

        $countryId = (int) (Country::where('name', 'Ethiopia')->value('id') ?? 0);

        return $countryId ?: null;
    }
}

/**
 * @return array
 */
if (! function_exists('getStates')) {
    function getStates($countryId)
    {
        return State::where('country_id', $countryId)->orderBy('name')->toBase()->pluck('name', 'id')->toArray();
    }
}

/**
 * @return array
 */
if (! function_exists('getStateFilter')) {
    function getStateFilter()
    {
            return State::orderBy('name')->toBase()->pluck('name', 'id')->toArray();
    }
}

if (! function_exists('getUserLanguages')) {
    function getUserLanguages(): array
    {
        //    $languages = File::directories(base_path().'/lang');
        $languages = Language::pluck('language', 'iso_code')->toArray();

        return $languages;
        //    $languagesArr = file_get_contents(storage_path('languages.json'));
        //    $languagesArr = json_decode($languagesArr, true);
        //    $allLanguagesArr = [];
        //    foreach ($languages as $language) {
        //        $lanCode = substr($language, -2);
        //        $shorLang = substr($language, -6);
        //        if ($shorLang == 'vendor') {
        //            continue;
        //        }
        //        if (isset($languagesArr[$lanCode])) {
        //            $allLanguagesArr[$lanCode] = $languagesArr[$lanCode]['name'].' ('.$languagesArr[$lanCode]['nativeName'].')' ?? $language;
        //        } else {
        //            $allLanguagesArr[$lanCode] = Str::camel($lanCode);
        //        }
        //    }
        //
        //    return $allLanguagesArr;
    }
}

/**
 * @return string
 */
if (! function_exists('getCompanyLogo')) {
    function getCompanyLogo()
    {
        // get the company logo
        $user = Auth::user();
        if (! empty($user->avatar)) {
            return $user->avatar;
        }

        return asset('assets/img/nasira-placeholder.png');
    }
}

// number formatted code

/**
 * @return string
 */
if (! function_exists('formatCurrency')) {
    function formatCurrency($currencyValue)
    {
        $amountValue = $currencyValue;
        $currencySuffix = ''; //thousand,lac, crore
        $numberOfDigits = countDigit($amountValue); //this is call :)
        if ($numberOfDigits > 3) {
            if ($numberOfDigits % 2 != 0) {
                $divider = divider($numberOfDigits - 1);
            } else {
                $divider = divider($numberOfDigits);
            }
        } else {
            $divider = 1;
        }

        $formattedAmount = $amountValue / $divider;
        $formattedAmount = number_format($formattedAmount, 2);
        if ($numberOfDigits == 4 || $numberOfDigits == 5) {
            $currencySuffix = 'k';
        }
        if ($numberOfDigits == 6 || $numberOfDigits == 7) {
            $currencySuffix = 'Lac';
        }
        if ($numberOfDigits == 8 || $numberOfDigits == 9) {
            $currencySuffix = 'Cr';
        }

        return $formattedAmount.' '.$currencySuffix;
    }
}

/**
 * @return int
 */
if (! function_exists('countDigit')) {
    function countDigit($number)
    {
        return strlen($number);
    }
}

/**
 * @return int|string
 */
if (! function_exists('divider')) {
    function divider($numberOfDigits)
    {
        $tens = '1';
        if ($numberOfDigits > 8) {
            return 10000000;
        }

        while (($numberOfDigits - 1) > 0) {
            $tens .= '0';
            $numberOfDigits--;
        }

        return $tens;
    }
}

if (! function_exists('setStripeApiKey')) {
    function setStripeApiKey()
    {
        $envSetting = getEnvSetting();
        if (! empty($envSetting['stripe_secret'])) {
            return Stripe::setApiKey($envSetting['stripe_secret']);
        }
        Stripe::setApiKey(config('services.stripe.secret_key'));
    }
}

if (! function_exists('setPayStackApiKey')) {
    function setPayStackApiKey()
    {
        Stripe::setApiKey(config('services.paystack.secret_key'));
    }
}

/**
 * @param  array  $input
 * @param  string  $key
 * @return string|null
 */
if (! function_exists('preparePhoneNumber')) {
    function preparePhoneNumber($phone, $regionCode)
    {
        return (! empty($phone)) ? '+'.$regionCode.$phone : null;
    }
}

/**
 * @return string[]
 */
if (! function_exists('getLanguages')) {
    function getLanguages()
    {
        return User::LANGUAGES;
    }
}

/**
 * @return mixed|null
 */
if (! function_exists('checkLanguageSession')) {
    function checkLanguageSession()
    {

        if (Auth::user()) {
            $language = Language::whereIsoCode(Auth::user()->language)->first();
            if ($language) {
                return $language['iso_code'];
            }
        }
        elseif (Session::has('languageName')) {
            $language = Language::whereIsoCode(Session::get('languageName'))->first();

            if ($language) {
                return $language['iso_code'];
            }
        }
        else{
            $default = Setting::where('key', '=', 'default_language')->first();
            $language = $default->value;

            if ($language) {
                return $language;
            }
        }
    }
}

/**
 * @return mixed|null
 */
if (! function_exists('getCurrentLanguageName')) {
function getCurrentLanguageName()
{
     if (Session::has('languageName')) {
        $language = Language::whereIsoCode(Session::get('languageName'))->first();
        if ($language) {
            return $language['language'];
        }

    }elseif (Auth::user()) {
        $language = Language::whereIsoCode(Auth::user()->language)->first();
        if ($language) {
            return $language['language'];
        }
    }else{
        $default = Setting::where('key', '=', 'default_language')->first();
        $language = Language::whereIsoCode($default->value)->first();

            if ($language) {
                return $language['language'];
            }
        }
    }
}

/**
 * @return mixed
 */
if (! function_exists('getCurrentLanguageImage')) {
    function getCurrentLanguageImage()
    {
        $languageImages = User::LANGUAGES_IMAGE;
        if (Session::has('languageName')) {

            $language = Session::get('languageName');
            if ($language && array_key_exists($language, $languageImages)) {
                return asset($languageImages[$language]);
            }

        }elseif (Auth::check()) {
            $user = Auth::user();
            $language = $user->language;

                if ($language && array_key_exists($language, $languageImages)) {
                    return asset($languageImages[$language]);
                }
        }else{
            $default = Setting::where('key', '=', 'default_language')->first();
            $language = $default->value;

            return asset('assets/img/united-states.svg');
        }
    }
}


/**
 * @return mixed
 */
if (! function_exists('getCurrentLanguageCode')) {
    function getCurrentLanguageCode()
    {
        return Auth::user()->language;
    }
}

/**
 * @return string
 */
if (! function_exists('getFileName')) {
    function getFileName($fileName, $attachment)
    {
        $fileNameExtension = $attachment->getClientOriginalExtension();
        $newName = $fileName.'-'.time();

        return $newName.'.'.$fileNameExtension;
    }
}

/**
 * @param  array  $models
 * @param  string  $columnName
 * @param  int  $id
 * @return bool
 */
if (! function_exists('canDelete')) {
    function canDelete($models, $columnName, $id)
    {
        foreach ($models as $model) {
            $result = $model::where($columnName, $id)->exists();
            if ($result) {
                return true;
            }
        }

        return false;
    }
}

/**
 * @return string
 */
if (! function_exists('getBadgeColor')) {
    function getBadgeColor($index)
    {
        $colors = [
            'primary',
            'secondary',
            'success',
            'warning',
            'danger',
            'info',
            'dark',
        ];
        $index = $index % 7;

        return $colors[$index];
    }
}

/**
 * @return string
 */
if (! function_exists('getJobOtherColor')) {
    function getJobOtherColor($index)
    {
        $colors = [
            'success',
            'dark',
            'primary',
        ];
        $index = $index % 3;

        return $colors[$index];
    }
}

/**
 * @param  array  $data
 */
if (! function_exists('addNotification')) {
    function addNotification($data)
    {
        $notificationRecord = [
            'type' => $data[0],
            'user_id' => $data[1],
            'notification_for' => $data[2],
            'title' => $data[3],
        ];

        Notification::create($notificationRecord);
    }
}

/**
 * @return Builder[]|Collection|Notification[]
 */
if (! function_exists('getNotification')) {
    function getNotification($role)
    {
        return Notification::whereNotificationFor($role)->where('read_at', null)->where(
            'user_id',
            getLoggedInUserId()
        )->orderByDesc('created_at')->get();
    }
}

/**
 * @return string
 */
if (! function_exists('getNotificationIcon')) {
    function getNotificationIcon($notificationFor)
    {
        switch ($notificationFor) {
            case 1:
                return 'fa fa-envelope';
            case 2:
                return 'fas fa-briefcase';
            case 3:
                return 'fa fa-building';
            case 4:
                return 'fas fa-user-check';
            case 5:
                return 'fa fa-user-times';
            case 6:
                return 'fa fa-check-square';
            case 7:
                return 'fas fa-user-tie';
            case 8:
                return 'fas fa-users';
            case 9:
                return 'fa fa-shopping-cart';
            case 10:
            case 11:
                return 'fa fa-bell';
            case 12:
                return 'fa fa-paper-plane';
            default:
                return 'fa fa-inbox';
        }
    }
}

/**
 * @param  Plan  $plan
 * @return bool
 *
 * @throws ApiErrorException
 */
if (! function_exists('createStripePlan')) {
    function createStripePlan($plan)
    {
        $envSetting = getEnvSetting();
        if (! empty($envSetting['stripe_secret'])) {
            $stripe = new StripeClient(
                $envSetting['stripe_secret']
            );
        } else {
            $stripe = new StripeClient(
                config('services.stripe.secret_key')
            );
        }
        $product = $stripe->products->create([
            'name' => $plan->name,
            'type' => 'service',
        ]);

        $planAmount = null;
        if ($plan->salaryCurrency != null && in_array($plan->salaryCurrency->currency_code, zeroDecimalCurrencies())) {
            $planAmount = (int) $plan->amount;
        } else {
            $planAmount = $plan->amount * 100;
        }

        $stripePlan = $stripe->plans->create([
            'amount' => $planAmount,
            'currency' => $plan->salaryCurrency != null ? $plan->salaryCurrency->currency_code : 'usd',
            'interval' => 'month',
            'product' => $product->id,
        ]);

        $plan->update([
            'stripe_plan_id' => $stripePlan->id,
        ]);

        return true;
    }
}

/**
 * @return array
 */
if (! function_exists('zeroDecimalCurrencies')) {
    function zeroDecimalCurrencies()
    {
        return [
            'BIF', 'CLP', 'DJF', 'GNF', 'JPY', 'KMF', 'KRW', 'MGA', 'PYG', 'RWF', 'UGX', 'VND', 'VUV', 'XAF', 'XOF', 'XPF',
        ];
    }
}

/**
 * @return array
 */
if (! function_exists('getPayPalSupportedCurrencies')) {
    function getPayPalSupportedCurrencies()
    {
        return [
            'AUD', 'BRL', 'CAD', 'CZK', 'DKK', 'EUR', 'HKD', 'HUF', 'ILS', 'JPY', 'MYR', 'MXN', 'TWD', 'NZD', 'NOK',
            'PHP', 'PLN', 'GBP', 'RUB', 'SGD', 'SEK', 'CHF', 'THB', 'USD',
        ];
    }
}

if (! function_exists('getPaystackSupportedCurrencies')) {
    function getPaystackSupportedCurrencies()
    {
        return [
            'NGN', 'USD', 'GHS', 'ZAR', 'KES',
        ];
    }
}

if (! function_exists('getCurrentVersion')) {
    function getCurrentVersion()
    {
        if (! filter_var(config('app.is_version'), FILTER_VALIDATE_BOOLEAN)) {
            return '';
        }

        try {
            $composerPath = base_path('composer.json');
            if (! is_file($composerPath)) {
                return '';
            }

            $composerData = json_decode((string) file_get_contents($composerPath), true);
            $currentVersion = $composerData['version'] ?? null;

            return $currentVersion ? 'v'.$currentVersion : '';
        } catch (Throwable) {
            return '';
        }
    }
}

if (! function_exists('addLinkHttpUrl')) {
    function addLinkHttpUrl($linkUrl)
    {
        if (! preg_match('~^(?:f|ht)tps?://~i', $linkUrl)) {
            $linkUrl = 'http://'.$linkUrl;
        }

        return $linkUrl;
    }
}

if (! function_exists('numberFormatShort')) {
    function numberFormatShort($n, int $precision = 2): string
    {
        if ($n < 900) {
            // 0 - 900
            $numberFormat = number_format($n, $precision);
            $suffix = '';
        } else {
            if ($n < 900000) {
                // 0.9k-850k
                $numberFormat = number_format($n / 1000, $precision);
                $suffix = 'K';
            } else {
                if ($n < 900000000) {
                    // 0.9m-850m
                    $numberFormat = number_format($n / 1000000, $precision);
                    $suffix = 'M';
                } else {
                    if ($n < 900000000000) {
                        // 0.9b-850b
                        $numberFormat = number_format($n / 1000000000, $precision);
                        $suffix = 'B';
                    } else {
                        // 0.9t+
                        $numberFormat = number_format($n / 1000000000000, $precision);
                        $suffix = 'T';
                    }
                }
            }
        }

        if ($precision > 0) {
            $dotZero = '.'.str_repeat('0', $precision);
            $numberFormat = str_replace($dotZero, '', $numberFormat);
        }

        return $numberFormat.$suffix;
    }
}

/**
 * @return mixed
 */
// function currencyFormat($currencyValue, string $code = 'INR')
// {
//     if (!in_array($code, availableCurrency())) {
//         $icon = SalaryCurrency::whereCurrencyCode($code)->first()->currency_icon;

//         return Currency::currency('INR')->setSymbol($icon)->format($currencyValue);
//     }

//     return Currency::currency($code)->format($currencyValue);
// }
if (! function_exists('currencyFormat')) {
    function currencyFormat($currencyValue, string $code = 'INR')
    {
        // Define custom icons for specific currencies
        $customIcons = [
            'USD' => '$',
            'EUR' => '€',
            'HKD' => 'HK$',
            'INR' => '₹',
            'AUD' => 'A$',
            'JMD' => 'J$',
            'CAD' => 'CA$',
            'AED' => 'د.إ',
            'AFN' => '؋',
            'ALL' => 'Lek',
            'AMD' => '֏',
            'ANG' => 'ƒ',
            'AOA' => 'Kz',
            'ARS' => '$',
            'AWG' => 'ƒ',
            'AZN' => '₼',
            'BAM' => 'KM',
            'BBD' => '$',
            'BDT' => '৳',
            'BGN' => 'лв',
            'BMD' => '$',
            'BND' => '$',
            'BOB' => '$b',
            'BRL' => 'R$',
            'BSD' => '$',
            'BWP' => 'P',
            'BZD' => 'BZ$',
            'CDF' => 'FC',
            'CHF' => 'CHF',
            'CNY' => '¥',
            'COP' => '$',
            'CRC' => '₡',
            'CVE' => '$',
            'CZK' => 'Kč',
            'DKK' => 'kr',
            'DOP' => 'RD$',
            'DZD' => 'دج',
            'EGP' => '£',
            'ETB' => 'ብር',
            'FJD' => '$',
            'FKP' => '£',
            'GBP' => '£',
            'GEL' => '₾',
            'GIP' => '£',
            'GMD' => 'D',
            'GTQ' => 'Q',
            'GYD' => '$',
            'HNL' => 'L',
            'HRK' => 'kn',
            'HTG' => 'G',
            'HUF' => 'Ft',
            'IDR' => 'Rp',
            'ILS' => '₪',
            'ISK' => 'kr',
            'KES' => '/=',
            'KGS' => 'лв',
            'KHR' => '៛',
            'KYD' => '$',
            'KZT' => 'лв',
            'LAK' => '₭',
            'LBP' => '£',
            'LKR' => '₨',
            'LRD' => '$',
            'LSL' => 'L',
            'MAD' => 'MAD',
            'MDL' => 'L',
            'MKD' => 'ден',
            'MMK' => 'K',
            'MNT' => '₮',
            'MOP' => 'MOP$',
            'MRO' => 'MRU',
            'MUR' => '₨',
            'MVR' => '.ރ',
            'MWK' => 'MK',
            'MXN' => '$',
            'MYR' => 'RM',
            'MZN' => 'MT',
            'NAD' => '$',
            'NGN' => '₦',
            'NIO' => 'C$',
            'NOK' => 'kr',
            'NPR' => '₨',
            'NZD' => '$',
            'PAB' => 'B/.',
            'PEN' => 'S/.',
            'PGK' => 'K',
            'PHP' => '₱',
            'PKR' => '₨',
            'PLN' => 'zł',
            'QAR' => '﷼',
            'RON' => 'lei',
            'RSD' => 'Дин.',
            'RUB' => '₽',
            'SAR' => '﷼',
            'SBD' => '$',
            'SCR' => '₨',
            'SEK' => 'kr',
            'SGD' => '$',
            'SHP' => '£',
            'SLL' => 'Le',
            'SOS' => 'S',
            'SRD' => '$',
            'STD' => 'Db',
            'SZL' => 'L',
            'THB' => '฿',
            'TJS' => 'ЅM',
            'TOP' => 'T$',
            'TRY' => '₺',
            'TTD' => 'TT$',
            'TWD' => 'NT$',
            'TZS' => 'TSh',
            'UAH' => '₴',
            'UYU' => '$U',
            'UZS' => 'лв',
            'WST' => 'WS$',
            'XCD' => '$',
            'YER' => '﷼',
            'ZAR' => 'R',
            'ZMW' => 'ZK',
            'BIF' => 'FBu',
            'CLP' => '$',
            'XPF' => '₣',
            'JPY' => '¥',
            'DJF' => '',
        ];

        if (isset($customIcons[$code])) {
            $icon = $customIcons[$code];
            $formattedValue = number_format($currencyValue, 2, '.', ',');

            return $icon.$formattedValue;
        }
    }
}

/**
 * @return string[]
 */
if (! function_exists('availableCurrency')) {
    function availableCurrency(): array
    {
        return [
            'AED', 'AFN', 'ALL', 'AMD', 'ANG', 'AOA', 'ARS', 'AUD', 'AWG', 'AZN', 'BAM', 'BBD', 'BDT', 'BGN', 'BHD', 'BIF', 'BMD', 'BND', 'BOB', 'BRL', 'BSD', 'BTC', 'BTN', 'BWP', 'BYR', 'BYN', 'BZD', 'CAD', 'CDF', 'CHF', 'CLP', 'CNY', 'COP', 'CRC', 'CUC', 'CUP', 'CVE', 'CZK', 'DJF', 'DKK', 'DOP', 'DZD', 'EGP', 'ERN', 'ETB', 'EUR', 'FJD', 'FKP', 'GBP', 'GEL', 'GHS', 'GIP', 'GMD', 'GNF', 'GTQ', 'GYD', 'HKD', 'HNL', 'HRK', 'HTG', 'HUF', 'IDR', 'ILS', 'INR', 'IQD', 'IRR', 'ISK', 'JMD', 'JOD', 'JPY', 'KES', 'KGS', 'KHR', 'KMF', 'KPW', 'KRW', 'KWD', 'KYD', 'KZT', 'LAK', 'LBP', 'LKR', 'LRD', 'LSL', 'LYD', 'MAD', 'MDL', 'MGA', 'MKD', 'MMK', 'MNT', 'MOP', 'MRO', 'MTL', 'MUR', 'MVR', 'MWK', 'MXN', 'MYR', 'MZN', 'NAD', 'NGN', 'NIO', 'NOK', 'NPR', 'NZD', 'OMR', 'PAB', 'PEN', 'PGK', 'PHP', 'PKR', 'PLN', 'PYG', 'QAR', 'RON', 'RSD', 'RUB', 'RWF', 'SAR', 'SBD', 'SCR', 'SDD', 'SDG', 'SEK', 'SGD', 'SHP', 'SLL', 'SOS', 'SRD', 'STD', 'SVC', 'SYP', 'SZL', 'THB', 'TJS', 'TMT', 'TND', 'TOP', 'TRY', 'TTD', 'TVD', 'TWD', 'TZS', 'UAH', 'UGX', 'USD', 'UYU', 'UZS', 'VEB', 'VEF', 'VND', 'VUV', 'WST', 'XAF', 'XCD', 'XBT', 'XOF', 'XPF', 'YER', 'ZAR', 'ZMW', 'ZWL', 'WON',
        ];
    }
}

if (! function_exists('processingPlan')) {
    function processingPlan($id)
    {
        $user = Auth::user();

        $plan = \App\Models\Subscription::with('owner')->where('user_id', $user->id)->where(
            'plan_id',
            $id
        )->where('stripe_status', \App\Models\Subscription::PENDING)->first();

        return $plan;
    }
}

/**
 * @return array
 */
if (! function_exists('googleJobSchema')) {
    function googleJobSchema()
    {
        $latestJobs = Job::whereStatus(Job::STATUS_OPEN)
            ->whereDate('job_expiry_date', '>=', Carbon::now()->toDateString())
            ->where('is_suspended', '=', Job::NOT_SUSPENDED)
            ->with(['company', 'jobCategory', 'jobsSkill'])
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $featureJobs = Job::has('activeFeatured')
            ->whereStatus(Job::STATUS_OPEN)
            ->whereDate('job_expiry_date', '>=', Carbon::now()->toDateString())
            ->where('is_suspended', '=', Job::NOT_SUSPENDED)
            ->with(['company', 'jobCategory', 'jobsSkill', 'activeFeatured'])
            ->orderBy('created_at', 'desc')
            ->get();

        $latestFeatureJobs = $latestJobs->merge($featureJobs);

        $localJobs = [];
        foreach ($latestFeatureJobs as $job) {
            $jobsSchema = Schema::jobPosting()
                ->title($job->job_title)
                ->description($job->description)
                ->datePosted($job->created_at)
                ->validThrough($job->job_expiry_date)
                    //            ->employmentType($job->job_category_id)
                ->hiringOrganization([
                    '@type' => 'Organization',
                    'name' => $job->company->user->full_name,
                    'sameAs' => 'http://www.google.com',
                    'logo' => $job->company->user->avatar,
                ])
                ->jobLocation([
                    '@type' => 'Place',
                    'address' => [
                        '@type' => 'PostalAddress',
                        'streetAddress' => $job->company->location ?? $job->company->location,
                        'addressLocality' => $job->company->location2 ?? $job->company->location2,
                        'addressRegion' => $job->city->name ?? $job->city->name,
                        'addressCountry' => $job->country->name ?? $job->country->name,
                    ],
                ])
                ->baseSalary([
                    '@type' => 'MonetaryAmount',
                    'currency' => $job->currency->currency_name,
                    'value' => [
                        '@type' => 'QuantitativeValue',
                        'value' => $job->salary_from,
                        'unitText' => 'HOUR',
                    ],
                ])
                ->applicationContact(Schema::contactPoint()->areaServed('Worldwide'));

            $localJobs[] = $jobsSchema->toScript();
        }

        return $localJobs;
    }
}

/**
 * @return mixed
 */
if (! function_exists('getSuperAdmin')) {
    function getSuperAdmin()
    {
        $adminRole = \Spatie\Permission\Models\Role::where('name', 'Admin')->first();

        return $adminRole->users->first();
    }
}

if (! function_exists('getEnvSetting')) {
    function getEnvSetting()
    {
        return EnvSetting::pluck('value', 'key')->toArray();
    }
}

if (! function_exists('getCity')) {
    function getCity()
    {
            return City::orderBy('name')->pluck('name', 'id')->toArray();
    }
}

if (! function_exists('getCities')) {
    function getCities($stateId)
    {
        return City::where('state_id', $stateId)->orderBy('name')->pluck('name', 'id')->toArray();
    }
}
function getFrontSelectLanguage()
{
    // $langIdLanguage = empty(Session::get('languageName'));

    // if ($langIdLanguage) {
    //     $langId = settings()['default_language'];
    // } else {
    //     $langId = Session::get('languageName');
    // }

    // return $langId;
    if (Auth::user()) {
        $language = Language::whereIsoCode(Auth::user()->language)->first();
        if ($language) {
            return $language['iso_code'];
        }
    }
    elseif (Session::has('languageName')) {
        $language = Language::whereIsoCode(Session::get('languageName'))->first();

        if ($language) {
            return $language['iso_code'];
        }
    }
    else{
        $default = Setting::where('key', '=', 'default_language')->first();
        $language = $default->value;

        if ($language) {
            return $language;
        }
    }
}


if(!function_exists('getTranslatedData')) {
    function getTranslatedData($data)
    {
        $translatedDataArr = collect($data)->map(function ($value) {
            return __('messages.' . strtolower($value));
        });

        return $translatedDataArr;
    }
}
