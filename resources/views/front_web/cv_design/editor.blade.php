@extends('front_web.layouts.app')
@section('title')
    CV Editor — {{ $template->name }}
@endsection
@section('page_css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('front_web/css/nasira-cv-design.css') }}?v=2">
@endsection
@section('content')
    <div class="ncv-editor" id="ncvEditor"
        data-save-url="{{ route('front.cv.save') }}"
        data-design-id="{{ $design->id ?? '' }}"
        data-template-id="{{ $template->id }}"
        data-can-save="{{ auth()->check() && auth()->user()->hasRole('Candidate') ? '1' : '0' }}"
        data-login-url="{{ route('front.candidate.login') }}">

        <div class="ncv-editor-top">
            <div class="container ncv-editor-top-inner">
                <div class="ncv-editor-brand">
                    <a href="{{ route('front.cv.design') }}" class="ncv-back">All templates</a>
                    <div>
                        <h1>CV Designer</h1>
                        <p class="ncv-muted">
                            <span class="ncv-template-pill" style="--ncv-accent: {{ $template->accent_color }}">{{ $template->name }}</span>
                            Live A4 preview
                        </p>
                    </div>
                </div>
                <div class="ncv-editor-actions">
                    <button type="button" class="ncv-btn ncv-btn-ghost" id="ncvDownloadBtn">Download PDF</button>
                    <button type="button" class="ncv-btn ncv-btn-primary" id="ncvSaveBtn">Save design</button>
                </div>
            </div>
        </div>

        <div class="ncv-editor-shell">
            <aside class="ncv-panel">
                <div class="ncv-tabs" role="tablist">
                    <button type="button" class="is-active" data-tab="content">Content</button>
                    <button type="button" data-tab="design">Design</button>
                    <button type="button" data-tab="templates">Templates</button>
                </div>

                <div class="ncv-tab-pane is-active" data-pane="content">
                    <div class="ncv-panel-block">
                        <h3>Personal</h3>
                        <label class="ncv-label">Full name<input type="text" data-bind="full_name"></label>
                        <label class="ncv-label">Job title<input type="text" data-bind="title"></label>
                        <div class="ncv-two">
                            <label class="ncv-label">Email<input type="email" data-bind="email"></label>
                            <label class="ncv-label">Phone<input type="text" data-bind="phone"></label>
                        </div>
                        <label class="ncv-label">Location<input type="text" data-bind="location"></label>
                        <label class="ncv-label">Professional summary<textarea data-bind="summary" rows="5"></textarea></label>
                    </div>

                    <div class="ncv-panel-block">
                        <h3>Skills <small>comma separated</small></h3>
                        <textarea id="ncvSkills" rows="3" placeholder="Leadership, Excel, Negotiation"></textarea>
                    </div>

                    <div class="ncv-panel-block">
                        <h3>Languages <small>comma separated</small></h3>
                        <textarea id="ncvLanguages" rows="2" placeholder="English, Amharic"></textarea>
                    </div>

                    <div class="ncv-panel-block">
                        <div class="ncv-panel-head">
                            <h3>Experience</h3>
                            <button type="button" class="ncv-btn ncv-btn-sm" id="ncvAddExp">Add</button>
                        </div>
                        <div id="ncvExpList"></div>
                    </div>

                    <div class="ncv-panel-block">
                        <div class="ncv-panel-head">
                            <h3>Education</h3>
                            <button type="button" class="ncv-btn ncv-btn-sm" id="ncvAddEdu">Add</button>
                        </div>
                        <div id="ncvEduList"></div>
                    </div>

                    <div class="ncv-panel-block">
                        <h3>Links <small>one per line</small></h3>
                        <textarea id="ncvLinks" rows="3" placeholder="https://linkedin.com/in/you"></textarea>
                    </div>
                </div>

                <div class="ncv-tab-pane" data-pane="design">
                    <div class="ncv-panel-block">
                        <h3>Document</h3>
                        <label class="ncv-label">Design name
                            <input type="text" id="ncvDesignTitle" value="{{ $design->title ?? 'My Professional CV' }}">
                        </label>
                        <label class="ncv-label">Accent color
                            <input type="color" id="ncvAccent" value="{{ $settings['accent_color'] ?? $template->accent_color }}">
                        </label>
                        <label class="ncv-check">
                            <input type="checkbox" id="ncvShowPhoto" {{ ($settings['show_photo'] ?? true) ? 'checked' : '' }}>
                            Show photo / initials
                        </label>
                    </div>

                    @if ($savedDesigns->count())
                        <div class="ncv-panel-block">
                            <h3>Saved designs</h3>
                            <ul class="ncv-saved">
                                @foreach ($savedDesigns as $saved)
                                    <li>
                                        <a href="{{ route('front.cv.editor', $saved->template->slug) }}?design={{ $saved->id }}">
                                            {{ $saved->title }}
                                        </a>
                                        <span>{{ $saved->template->name }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="ncv-tab-pane" data-pane="templates">
                    <div class="ncv-panel-block">
                        <h3>Switch template</h3>
                        <p class="ncv-hint">Your content stays — only the layout changes.</p>
                        <div class="ncv-template-rail">
                            @foreach ($templates as $tpl)
                                <a href="{{ route('front.cv.editor', $tpl->slug) }}{{ !empty($design) ? '?design='.$design->id : '' }}"
                                    class="ncv-tpl-thumb layout-{{ $tpl->layout }} {{ $tpl->id === $template->id ? 'is-active' : '' }}"
                                    style="--ncv-accent: {{ $tpl->accent_color }}; --ncv-secondary: {{ $tpl->secondary_color ?? $tpl->accent_color }};"
                                    title="{{ $tpl->name }}">
                                    <span class="ncv-tpl-preview" aria-hidden="true"></span>
                                    <span class="ncv-tpl-name">{{ $tpl->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </aside>

            <div class="ncv-preview-wrap">
                <div class="ncv-preview-label">A4 preview</div>
                <div class="ncv-preview-stage">
                    @include('front_web.cv_design.partials.paper')
                </div>
            </div>
        </div>
    </div>

    <script type="application/json" id="ncvInitialContent">{!! json_encode($content) !!}</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="{{ asset('front_web/js/nasira-cv-editor.js') }}?v=2"></script>
@endsection
