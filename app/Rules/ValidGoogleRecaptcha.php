<?php

namespace App\Rules;

use App\Support\GoogleRecaptcha;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidGoogleRecaptcha implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! GoogleRecaptcha::isEnabled()) {
            return;
        }

        if (! GoogleRecaptcha::verify(is_string($value) ? $value : null, request()->ip())) {
            $fail(__('messages.verify_captcha'));
        }
    }
}
