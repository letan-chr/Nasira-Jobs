@extends('front_web.layouts.app')
@section('title')
    Convert & Compress — Free Solutions
@endsection
@section('meta_title')
    {{ $seo['meta_title'] }}
@endsection
@section('seo_head')
    @include('front_web.solutions.partials.seo-head', ['seo' => $seo])
@endsection
@section('content')
    <div class="nasira-solutions-page">
        <section class="nasira-sol-hero">
            <div class="container">
                <p class="nasira-sol-kicker">Nasira Jobs · FreeConvert-style tools</p>
                <h1>Convert & compress files online</h1>
                <p class="nasira-sol-lead">
                    {{ $total }} free browser tools for video, audio, images, PDF, GIF and more — private by design, no signup required.
                </p>
                <div class="nasira-sol-hero-actions">
                    <a href="#section-Convert" class="nasira-sol-cta">Browse Convert</a>
                    <a href="#section-Tools" class="nasira-sol-cta nasira-sol-cta--ghost">Browse Tools</a>
                    <a href="#section-Compress" class="nasira-sol-cta nasira-sol-cta--ghost">Browse Compress</a>
                </div>
            </div>
        </section>

        <section class="nasira-sol-catalog py-5">
            <div class="container">
                @php
                    $sections = [];
                    foreach ($groups as $groupKey => $group) {
                        $sec = $group['section'] ?? 'More';
                        $sections[$sec][$groupKey] = $group;
                    }
                @endphp

                @foreach ($sections as $sectionName => $sectionGroups)
                    <div class="nasira-sol-section" id="section-{{ $sectionName }}">
                        <div class="nasira-sol-section-head">
                            <h2>{{ $sectionName }}</h2>
                            <p>
                                @if ($sectionName === 'Convert')
                                    Like <a href="https://www.freeconvert.com/" target="_blank" rel="noopener">FreeConvert</a> — upload, convert, download.
                                @elseif ($sectionName === 'Compress')
                                    Shrink video, audio, images, GIF and PDF for faster sharing.
                                @elseif ($sectionName === 'Tools')
                                    Background remover, color picker, resizer, QR codes, and other everyday utilities.
                                @else
                                    Career and productivity helpers for job seekers.
                                @endif
                            </p>
                        </div>

                        @foreach ($sectionGroups as $groupKey => $group)
                            <div class="nasira-sol-group" id="group-{{ $groupKey }}">
                                <div class="nasira-sol-group-head">
                                    <h3>{{ $group['title'] }}</h3>
                                    <p>{{ $group['blurb'] }}</p>
                                </div>
                                <div class="nasira-sol-grid">
                                    @foreach ($group['items'] as $item)
                                        <a class="nasira-sol-card"
                                            href="{{ !empty($item['route']) ? route($item['route']) : route('front.solutions.show', $item['slug']) }}">
                                            <span class="nasira-sol-card-icon"><i class="fa-solid {{ $item['icon'] }}"></i></span>
                                            <span class="nasira-sol-card-body">
                                                <strong>{{ $item['name'] }}</strong>
                                                <small>{{ $item['desc'] }}</small>
                                            </span>
                                            <i class="fa-solid fa-chevron-right nasira-sol-card-go"></i>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach

                <section class="nasira-seo-block" aria-labelledby="solutions-faq-heading">
                    <h2 id="solutions-faq-heading">Solutions FAQ</h2>
                    <div class="nasira-seo-faq">
                        @foreach ($seo['faqs'] as $faq)
                            <details class="nasira-seo-faq-item">
                                <summary>{{ $faq['q'] }}</summary>
                                <p>{{ $faq['a'] }}</p>
                            </details>
                        @endforeach
                    </div>
                    <p class="nasira-seo-sitemap-note">
                        <a href="{{ route('front.solutions.sitemap') }}">Solutions sitemap</a> for search engines.
                    </p>
                </section>
            </div>
        </section>
    </div>
@endsection
