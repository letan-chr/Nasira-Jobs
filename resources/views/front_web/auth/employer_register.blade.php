@php
    // Kept for backward compatibility — public register is unified with role dropdown.
    $isGoogleReCaptchaEnabled = $isGoogleReCaptchaEnabled ?? false;
    echo view('front_web.auth.candidate_register', compact('isGoogleReCaptchaEnabled'))->render();
@endphp
