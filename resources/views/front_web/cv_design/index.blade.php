@extends('front_web.layouts.app')
@section('title')
    CV Designer
@endsection
@section('meta_title')
    {{ $seo['meta_title'] }}
@endsection
@section('seo_head')
    @include('front_web.solutions.partials.seo-head', ['seo' => $seo])
@endsection
@section('page_css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('front_web/css/nasira-cv-design.css') }}?v=5">
    <link href="{{ asset('front_web/css/nasira-solutions.css') }}?v=13" rel="stylesheet" type="text/css">
@endsection
@section('content')
    <section class="ncv-hero">
        <div class="container ncv-hero-inner">
            <div class="ncv-hero-copy">
                <p class="ncv-kicker">Nasira CV Studio</p>
                <h1>Canva-style resume designer</h1>
                <p class="ncv-lead">
                    Pick a polished A4 template, open the visual studio, then drag, edit, and brand every
                    block until it looks interview-ready.
                </p>
                <div class="ncv-hero-cta">
                    <a href="{{ route('front.cv.editor', 'nasira-modern') }}" class="ncv-btn ncv-btn-primary">
                        Open designer
                    </a>
                    <a href="#ncvTemplates" class="ncv-btn ncv-btn-ghost">Browse {{ $templateTotal ?? $templates->total() }} templates</a>
                </div>
                <ul class="ncv-hero-points">
                    <li>True visual previews</li>
                    <li>Drag &amp; drop editing</li>
                    <li>PDF export</li>
                </ul>
            </div>
            <div class="ncv-hero-visual" aria-hidden="true">
                @php
                    $heroTpl = $templates->firstWhere('slug', 'nasira-modern') ?? $templates->first();
                    $heroDoc = $heroTpl
                        ? '<!DOCTYPE html><html><head><meta charset="utf-8"><base target="_blank"><style>html,body{margin:0;background:#fff;}'.$heroTpl->css.'</style></head><body>'.$heroTpl->html.'</body></html>'
                        : '';
                @endphp
                @if ($heroTpl)
                    <div class="ncv-hero-frame">
                        <iframe title="Sample CV" loading="lazy" sandbox="" srcdoc="{{ $heroDoc }}"></iframe>
                    </div>
                @endif
            </div>
        </div>
    </section>

    @if(isset($savedDesigns) && $savedDesigns->count())
        <section class="ncv-gallery" id="ncvMyCvs">
            <div class="container">
                <div class="ncv-gallery-head">
                    <div>
                        <h2>My saved CVs <span class="ncv-count">{{ $savedDesigns->count() }}</span></h2>
                        <p>Open any saved resume anytime — your final designs stay in your account.</p>
                    </div>
                </div>
                <div class="ncv-grid ncv-grid-pro">
                    @foreach ($savedDesigns as $saved)
                        <article class="ncv-card ncv-card-pro">
                            <div class="ncv-card-meta" style="padding-top:1.1rem;">
                                <div>
                                    <span class="ncv-card-cat">Saved</span>
                                    <h3>{{ $saved->title }}</h3>
                                    <p>{{ $saved->template->name ?? 'Template' }} · updated {{ $saved->updated_at?->diffForHumans() }}</p>
                                </div>
                                <a href="{{ route('front.cv.editor', $saved->template->slug ?? 'nasira-modern') }}?design={{ $saved->id }}"
                                   class="ncv-btn ncv-btn-sm">Open CV</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="ncv-gallery" id="ncvTemplates">
        <div class="container">
            <div class="ncv-gallery-head">
                <div>
                    <h2>Template gallery <span class="ncv-count">{{ $templateTotal ?? $templates->total() }}</span></h2>
                    <p>100+ professional A4 layouts — click any card to open it in the designer.</p>
                </div>
                <div class="ncv-filters">
                    <a href="{{ route('front.cv.design') }}"
                        class="ncv-filter {{ empty($category) ? 'is-active' : '' }}">All</a>
                    @foreach ($categories as $cat)
                        <a href="{{ route('front.cv.design', ['category' => $cat]) }}"
                            class="ncv-filter {{ $category === $cat ? 'is-active' : '' }}">{{ ucfirst($cat) }}</a>
                    @endforeach
                </div>
            </div>

            <div class="ncv-grid ncv-grid-pro">
                @forelse ($templates as $template)
                    @php
                        $doc = '<!DOCTYPE html><html><head><meta charset="utf-8"><base target="_blank"><style>html,body{margin:0;background:#fff;overflow:hidden;}'.$template->css.'</style></head><body>'.$template->html.'</body></html>';
                    @endphp
                    <article class="ncv-card ncv-card-pro">
                        <a href="{{ route('front.cv.editor', $template->slug) }}" class="ncv-card-preview-real">
                            <div class="ncv-thumb">
                                <iframe title="{{ $template->name }} preview"
                                    loading="lazy"
                                    tabindex="-1"
                                    sandbox=""
                                    srcdoc="{{ $doc }}"></iframe>
                            </div>
                            <span class="ncv-card-hover">Open in designer</span>
                        </a>
                        <div class="ncv-card-meta">
                            <div>
                                <span class="ncv-card-cat">{{ ucfirst($template->category) }}</span>
                                <h3>{{ $template->name }}</h3>
                                <p>{{ $template->description }}</p>
                            </div>
                            <a href="{{ route('front.cv.editor', $template->slug) }}" class="ncv-btn ncv-btn-sm">
                                Design this CV
                            </a>
                        </div>
                    </article>
                @empty
                    <p class="text-muted">No templates yet. Run <code>php artisan db:seed --class=CvTemplateSeeder</code>.</p>
                @endforelse
            </div>

            @if(method_exists($templates, 'links'))
                <div class="ncv-pagination" style="margin-top:1.5rem;">
                    {{ $templates->links() }}
                </div>
            @endif

            <section class="nasira-seo-block" aria-labelledby="cv-seo-heading">
                <h2 id="cv-seo-heading">{{ !empty($category) ? ucfirst($category).' CV templates' : 'Online CV Designer' }}</h2>
                <p class="nasira-seo-intro">{{ $seo['intro'] }}</p>
                <ul class="nasira-seo-benefits">
                    @foreach ($seo['benefits'] as $benefit)
                        <li>{{ $benefit }}</li>
                    @endforeach
                </ul>

                <h2>How to design your resume</h2>
                <ol class="nasira-seo-steps">
                    @foreach ($seo['howto_steps'] as $step)
                        <li>
                            <strong>{{ $step['name'] }}</strong>
                            <span>{{ $step['text'] }}</span>
                        </li>
                    @endforeach
                </ol>

                <h2>CV Designer FAQ</h2>
                <div class="nasira-seo-faq">
                    @foreach ($seo['faqs'] as $faq)
                        <details class="nasira-seo-faq-item">
                            <summary>{{ $faq['q'] }}</summary>
                            <p>{{ $faq['a'] }}</p>
                        </details>
                    @endforeach
                </div>
                <p class="nasira-seo-sitemap-note">
                    <a href="{{ route('front.cv.sitemap') }}">CV Design sitemap</a> for search engines.
                </p>
            </section>
        </div>
    </section>
@endsection
