@extends('front_web.layouts.app')
@php
    $engine = $tool['engine'] ?? 'special';
    $slug = $tool['slug'] ?? '';
    $featuredEngines = ['ffmpeg', 'image', 'heic', 'pdf', 'doc', 'ebook', 'archive', 'unit'];
    $isFeaturedTool = in_array($engine, $featuredEngines, true)
        || in_array($slug, ['background-remover', 'png-to-jpg'], true);
    $needsFfmpeg = $engine === 'ffmpeg';
    $needsHeic = $engine === 'heic' || str_starts_with($slug, 'heic-');
    $needsPdf = in_array($engine, ['pdf', 'doc', 'ebook'], true)
        || in_array($slug, ['pdf-to-word', 'pdf-merger', 'pdf-splitter', 'pdf-compressor', 'word-to-pdf', 'txt-to-pdf', 'markdown-to-pdf', 'jpg-to-pdf'], true);
    $needsDocx = in_array($slug, ['pdf-to-word', 'word-to-pdf', 'document-converter'], true) || $engine === 'doc';
    $needsHtml2pdf = in_array($slug, ['word-to-pdf', 'txt-to-pdf', 'markdown-to-pdf', 'cover-letter-helper'], true) || $engine === 'doc';
    $needsQr = $slug === 'qr-code-generator';
    $needsZip = in_array($engine, ['archive', 'pdf'], true)
        || in_array($slug, ['pdf-splitter', 'pdf-to-jpg', 'image-to-gif'], true);
    $needsCropper = in_array($slug, ['image-cropper', 'passport-photo', 'image-resizer'], true);
    $needsBg = $slug === 'background-remover';
    $needsUnits = $engine === 'unit' || $slug === 'unit-converter';
    $needsFileSaver = $needsPdf || $needsZip || $needsDocx || $needsFfmpeg || $needsHeic || $engine === 'image' || $isFeaturedTool;
@endphp
@section('title')
    {{ $tool['name'] }}
@endsection
@section('meta_title')
    {{ $seo['meta_title'] }}
@endsection
@section('seo_head')
    @include('front_web.solutions.partials.seo-head', ['seo' => $seo])
@endsection
@section('page_css')
    @if ($needsCropper)
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css" />
    @endif
@endsection
@section('content')
    <div class="nasira-solutions-page nasira-tool-page {{ $isFeaturedTool ? 'nasira-tool-page--featured' : '' }}"
        data-tool="{{ $slug }}"
        data-group="{{ $tool['group'] }}"
        data-engine="{{ $engine }}">
        <section class="nasira-sol-hero nasira-sol-hero--compact">
            <div class="container">
                <nav class="nasira-sol-crumb" aria-label="breadcrumb">
                    <a href="{{ route('front.home') }}">Home</a>
                    <span>/</span>
                    <a href="{{ route('front.solutions') }}">Solutions</a>
                    @if (!empty($tool['section']))
                        <span>/</span>
                        <a href="{{ route('front.solutions') }}#section-{{ $tool['section'] }}">{{ $tool['section'] }}</a>
                    @endif
                    <span>/</span>
                    <span>{{ $tool['name'] }}</span>
                </nav>
                @unless ($isFeaturedTool)
                    <h1>{{ $tool['name'] }}</h1>
                    <p class="nasira-sol-lead">{{ $tool['desc'] }}</p>
                    @if (!empty($tool['note']))
                        <p class="nasira-sol-note text-muted small mb-0">
                            <i class="fa-solid fa-circle-info"></i> {{ $tool['note'] }}
                        </p>
                    @endif
                @else
                    <h1 class="visually-hidden">{{ $tool['name'] }}</h1>
                @endunless
            </div>
        </section>

        <section class="py-5 {{ $isFeaturedTool ? 'pt-3' : '' }}">
            <div class="container">
                @if ($isFeaturedTool)
                    <div class="nasira-tool-layout-main">
                        <div class="nasira-tool-panel" id="nasira-tool-root">
                            <div class="nasira-tool-loading">
                                <div class="nasira-spinner"></div>
                                <p>Preparing {{ $tool['name'] }}…</p>
                            </div>
                        </div>
                        @if (!empty($tool['note']))
                            <p class="nasira-sol-note text-muted small text-center mt-2 mb-0">
                                <i class="fa-solid fa-circle-info"></i> {{ $tool['note'] }}
                            </p>
                        @endif
                        <p class="nasira-tool-privacy mt-3 text-center">
                            <i class="fa-solid fa-shield-halved"></i>
                            Private by design: conversion runs in your browser. Files are not uploaded to Nasira servers.
                            Max {{ number_format(40) }} MB per file.
                        </p>
                    </div>
                @else
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="nasira-tool-panel" id="nasira-tool-root">
                                <div class="nasira-tool-loading">
                                    <div class="nasira-spinner"></div>
                                    <p>Preparing tool…</p>
                                </div>
                            </div>
                            <p class="nasira-tool-privacy mt-3">
                                <i class="fa-solid fa-shield-halved"></i>
                                Private by design: files are processed in your browser. Max 40 MB per file.
                            </p>
                        </div>
                        <div class="col-lg-4">
                            <aside class="nasira-tool-aside">
                                <h3>Related in {{ $tool['group_title'] }}</h3>
                                <ul>
                                    @foreach ($related as $item)
                                        <li>
                                            <a href="{{ !empty($item['route']) ? route($item['route']) : route('front.solutions.show', $item['slug']) }}">
                                                <i class="fa-solid {{ $item['icon'] }}"></i> {{ $item['name'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <a href="{{ route('front.solutions') }}" class="nasira-sol-all-link">All solutions →</a>
                            </aside>
                        </div>
                    </div>
                @endif

                <section class="nasira-seo-block" aria-labelledby="tool-seo-heading">
                    <h2 id="tool-seo-heading">About {{ $tool['name'] }}</h2>
                    <p class="nasira-seo-intro">{{ $seo['intro'] }}</p>
                    <ul class="nasira-seo-benefits">
                        @foreach ($seo['benefits'] as $benefit)
                            <li>{{ $benefit }}</li>
                        @endforeach
                    </ul>

                    <h2>How to use {{ $tool['name'] }}</h2>
                    <ol class="nasira-seo-steps">
                        @foreach ($seo['howto_steps'] as $step)
                            <li>
                                <strong>{{ $step['name'] }}</strong>
                                <span>{{ $step['text'] }}</span>
                            </li>
                        @endforeach
                    </ol>

                    <h2>{{ $tool['name'] }} FAQ</h2>
                    <div class="nasira-seo-faq">
                        @foreach ($seo['faqs'] as $faq)
                            <details class="nasira-seo-faq-item">
                                <summary>{{ $faq['q'] }}</summary>
                                <p>{{ $faq['a'] }}</p>
                            </details>
                        @endforeach
                    </div>
                </section>
            </div>
        </section>
    </div>
@endsection
@section('page_scripts')
    <script>
        window.NasiraToolMeta = @json($tool);
        window.NasiraSolutionsLimits = { maxBytes: 40 * 1024 * 1024 };
    </script>
    @if ($needsPdf)
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
    @endif
    @if ($needsHtml2pdf)
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    @endif
    @if ($needsQr)
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    @endif
    @if ($needsZip)
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    @endif
    @if ($needsFileSaver)
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    @endif
    @if ($needsDocx)
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.8.0/mammoth.browser.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/docx@8.5.0/build/index.umd.js"></script>
    @endif
    @if ($needsCropper)
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
    @endif
    @if ($needsHeic)
        <script defer src="https://cdn.jsdelivr.net/npm/heic2any@0.0.4/dist/heic2any.min.js"></script>
    @endif
    @if ($needsFfmpeg)
        <script type="module">
            try {
                const [{ FFmpeg }, util] = await Promise.all([
                    import('https://cdn.jsdelivr.net/npm/@ffmpeg/ffmpeg@0.12.10/dist/esm/index.js'),
                    import('https://cdn.jsdelivr.net/npm/@ffmpeg/util@0.12.1/dist/esm/index.js'),
                ]);
                window.FFmpegWASM = { FFmpeg };
                window.FFmpegUtil = { fetchFile: util.fetchFile, toBlobURL: util.toBlobURL };
                window.dispatchEvent(new Event('nasira-ffmpeg-ready'));
            } catch (err) {
                console.error('FFmpeg load failed', err);
                window.NasiraFfmpegLoadError = err;
                window.dispatchEvent(new Event('nasira-ffmpeg-ready'));
            }
        </script>
    @endif
    @if ($needsUnits)
        <script defer src="{{ asset('front_web/js/nasira-units.js') }}?v=1"></script>
    @endif
    <script defer src="{{ asset('front_web/js/nasira-freeconvert.js') }}?v=4"></script>
    <script defer src="{{ asset('front_web/js/nasira-solutions.js') }}?v=13"></script>
    @if ($needsBg)
        <script type="module">
            // Models/WASM live on IMG.LY's data CDN — NOT the jsDelivr package dist.
            const PUBLIC_PATH = 'https://staticimgly.com/@imgly/background-removal-data/1.5.5/dist/';
            const MODEL = 'isnet_fp16'; // medium-quality model (~80MB)
            try {
                const mod = await import('https://cdn.jsdelivr.net/npm/@imgly/background-removal@1.5.5/+esm');
                const removeBackground = mod.removeBackground || mod.default;
                const preload = mod.preload;
                if (typeof removeBackground !== 'function') {
                    throw new Error('removeBackground export missing');
                }
                window.NasiraBgRemove = {
                    removeBackground,
                    preload,
                    configDefaults: {
                        publicPath: PUBLIC_PATH,
                        model: MODEL,
                        proxyToWorker: true,
                        debug: false,
                    },
                };
                window.dispatchEvent(new Event('nasira-bg-ready'));
                if (typeof preload === 'function') {
                    preload({ publicPath: PUBLIC_PATH, model: MODEL, proxyToWorker: true }).catch((e) => {
                        console.warn('BG model preload warning', e);
                    });
                }
            } catch (err) {
                console.warn('Background removal AI failed to load', err);
                window.NasiraBgRemove = null;
                window.NasiraBgRemoveError = err;
                window.dispatchEvent(new Event('nasira-bg-ready'));
            }
        </script>
    @endif
@endsection
