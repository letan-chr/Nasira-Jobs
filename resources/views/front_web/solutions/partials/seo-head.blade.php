@php
    /** @var array<string, mixed> $seo */
@endphp
<meta name="description" content="{{ $seo['description'] }}">
<meta name="keywords" content="{{ $seo['keywords'] }}">
<meta name="robots" content="{{ $seo['robots'] }}">
<link rel="canonical" href="{{ $seo['canonical'] }}">

<meta property="og:type" content="{{ $seo['og_type'] }}">
<meta property="og:site_name" content="{{ getAppName() }}">
<meta property="og:title" content="{{ $seo['og_title'] }}">
<meta property="og:description" content="{{ $seo['og_description'] }}">
<meta property="og:url" content="{{ $seo['og_url'] }}">
<meta property="og:image" content="{{ $seo['og_image'] }}">
<meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">

<meta name="twitter:card" content="{{ $seo['twitter_card'] }}">
<meta name="twitter:title" content="{{ $seo['twitter_title'] }}">
<meta name="twitter:description" content="{{ $seo['twitter_description'] }}">
<meta name="twitter:image" content="{{ $seo['twitter_image'] }}">

<script type="application/ld+json">{!! json_encode($seo['json_ld'], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT) !!}</script>
