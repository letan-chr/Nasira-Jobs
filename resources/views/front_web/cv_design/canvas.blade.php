<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $seo['meta_title'] ?? ('Resume Designer — '.$template->name.' | '.getAppName()) }}</title>
    @isset($seo)
        @include('front_web.solutions.partials.seo-head', ['seo' => $seo])
    @endisset
    <link rel="shortcut icon" href="{{ getSettingValue('favicon') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/grapesjs@0.21.7/dist/css/grapes.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('front_web/css/nasira-cv-canvas.css') }}?v=14">
</head>
<body class="canva-body">
<div id="ncvCanvasApp"
     class="canva-app"
     data-save-url="{{ route('front.cv.save') }}"
     data-guest-draft-url="{{ route('front.cv.guest-draft') }}"
     data-upload-url="{{ route('front.cv.upload') }}"
     data-template-id="{{ $template->id }}"
     data-design-id="{{ $design->id ?? '' }}"
     data-can-save="{{ auth()->check() && auth()->user()->hasRole('Candidate') ? '1' : '0' }}"
     data-login-url="{{ route('front.candidate.login') }}"
     data-templates-url="{{ route('front.cv.design') }}"
     data-html='@json($html)'
     data-css='@json($css)'
     data-project='@json($projectJson)'>

    <header class="canva-topbar">
        <div class="canva-top-left">
            <a class="canva-home" href="{{ route('front.cv.design') }}" title="All templates">
                <span class="canva-logo">N</span>
            </a>
            <div class="canva-file">
                <input type="text" id="ncvCvTitle" value="{{ $design->title ?? ($template->name.' Resume') }}" spellcheck="false">
                <div class="canva-file-meta">
                    <span id="ncvStatus">Editing</span>
                    <span>·</span>
                    <span>{{ $template->name }}</span>
                </div>
            </div>
        </div>

        <div class="canva-top-center">
            <button type="button" class="canva-icon-btn" id="ncvUndo" title="Undo (Ctrl+Z)">↶</button>
            <button type="button" class="canva-icon-btn" id="ncvRedo" title="Redo">↷</button>
            <span class="canva-sep"></span>
            <button type="button" class="canva-chip" id="ncvDragFree" title="Drag anywhere">Position</button>
            <button type="button" class="canva-chip is-active" id="ncvDragFlow" title="Document flow">Flow</button>
            <span class="canva-sep"></span>
            <button type="button" class="canva-icon-btn" id="ncvDuplicate" title="Duplicate">⧉</button>
            <button type="button" class="canva-icon-btn danger" id="ncvDelete" title="Delete">⌫</button>
        </div>

        <div class="canva-top-right">
            <span class="canva-paper-tag" title="ISO A4">A4 · 210×297mm</span>
            <button type="button" class="canva-btn ghost" id="ncvPreviewPdf">Download PDF</button>
            <button type="button" class="canva-btn primary" id="ncvSaveCanvas">
                {{ auth()->check() && auth()->user()->hasRole('Candidate') ? 'Save resume' : 'Save draft' }}
            </button>
        </div>
    </header>

    <div class="canva-workspace">
        <nav class="canva-rail" aria-label="Designer tools">
            <button type="button" class="canva-rail-btn is-active" data-panel="elements" title="Elements">
                <span class="ico">▣</span><span>Elements</span>
            </button>
            <button type="button" class="canva-rail-btn" data-panel="text" title="Text">
                <span class="ico">T</span><span>Text</span>
            </button>
            <button type="button" class="canva-rail-btn" data-panel="templates" title="Templates">
                <span class="ico">▦</span><span>Templates</span>
            </button>
            <button type="button" class="canva-rail-btn" data-panel="layers" title="Layers">
                <span class="ico">☰</span><span>Layers</span>
            </button>
            <button type="button" class="canva-rail-btn" data-panel="uploads" title="Uploads">
                <span class="ico">⬆</span><span>Uploads</span>
            </button>
            <button type="button" class="canva-rail-btn" data-panel="brand" title="Brand">
                <span class="ico">◐</span><span>Brand</span>
            </button>
        </nav>

        <aside class="canva-panel">
            <div class="canva-panel-view is-active" data-panel-view="elements">
                <h2>Elements</h2>
                <p class="canva-help">Drag onto the page. Double-click any text to edit inline.</p>
                <div id="ncvBlocksElements" class="canva-blocks"></div>
            </div>
            <div class="canva-panel-view" data-panel-view="text">
                <h2>Text</h2>
                <p class="canva-help">Click a style to add it — then edit and style on the right.</p>
                <div class="canva-text-tiles" id="ncvTextTiles">
                    <button type="button" class="canva-text-tile" data-text="heading">
                        <span class="preview heading">Add a heading</span>
                        <small>Name / section title</small>
                    </button>
                    <button type="button" class="canva-text-tile" data-text="subheading">
                        <span class="preview sub">Add a subheading</span>
                        <small>Job title / company</small>
                    </button>
                    <button type="button" class="canva-text-tile" data-text="body">
                        <span class="preview body">Add a little bit of body text</span>
                        <small>Paragraphs &amp; bullets</small>
                    </button>
                    <button type="button" class="canva-text-tile" data-text="label">
                        <span class="preview label">Section label</span>
                        <small>EXPERIENCE · SKILLS</small>
                    </button>
                </div>
                <div id="ncvBlocksText" class="canva-blocks"></div>
            </div>
            <div class="canva-panel-view" data-panel-view="templates">
                <h2>Templates</h2>
                <p class="canva-help">Switch layout anytime. Saved resumes stay in your list below.</p>
                <label class="canva-select-label">Quick switch
                    <select id="ncvTemplateSwitch">
                        @foreach (($templateOptions ?? $templates) as $tpl)
                            <option value="{{ $tpl->slug }}" @selected($tpl->slug === $template->slug)>{{ $tpl->name }}</option>
                        @endforeach
                    </select>
                </label>
                <div class="canva-tpl-grid">
                    @foreach ($templates as $tpl)
                        @php
                            $mini = '<!DOCTYPE html><html><head><meta charset="utf-8"><style>html,body{margin:0;background:#fff;overflow:hidden;}'.($tpl->css ?? '').'</style></head><body>'.($tpl->html ?? '').'</body></html>';
                        @endphp
                        <a class="canva-tpl {{ $tpl->id === $template->id ? 'is-active' : '' }}"
                           href="{{ route('front.cv.editor', $tpl->slug) }}">
                            <span class="canva-tpl-preview">
                                <iframe title="{{ $tpl->name }}" loading="lazy" tabindex="-1" sandbox="" srcdoc="{{ $mini }}"></iframe>
                            </span>
                            <span class="canva-tpl-name">{{ $tpl->name }}</span>
                        </a>
                    @endforeach
                </div>
                @if ($savedDesigns->count())
                    <h3 class="canva-subhead">Saved</h3>
                    <div class="canva-saved-list">
                        @foreach ($savedDesigns as $saved)
                            <a href="{{ route('front.cv.editor', $saved->template->slug) }}?design={{ $saved->id }}">
                                {{ $saved->title }}
                                <small>{{ $saved->template->name }}</small>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="canva-panel-view" data-panel-view="layers">
                <h2>Layers</h2>
                <p class="canva-help">Select any layer to move, restyle, or reorder it.</p>
                <div id="ncvLayers"></div>
            </div>
            <div class="canva-panel-view" data-panel-view="uploads">
                <h2>Photo</h2>
                <p class="canva-help">Choose a photo once — it replaces the CV profile image automatically.</p>
                <label class="canva-upload-box" for="ncvPhotoInput">
                    <strong>Choose profile photo</strong>
                    <span>JPG, PNG, WEBP · max 5MB</span>
                    <input type="file" id="ncvPhotoInput" accept="image/jpeg,image/png,image/webp,image/gif" hidden>
                </label>
                <div class="canva-upload-preview" id="ncvUploadPreview" hidden>
                    <img alt="Uploaded preview" id="ncvUploadPreviewImg">
                </div>
                <p class="canva-help" id="ncvUploadStatus">No photo yet.</p>
            </div>
            <div class="canva-panel-view" data-panel-view="brand">
                <h2>Brand kit</h2>
                <p class="canva-help">1) Select Page / Sidebar / Main. 2) Choose <strong>Background</strong> or <strong>Text</strong>. 3) Tap a color. Colors stay inside the CV page.</p>
                <div class="canva-color-mode" id="ncvColorMode">
                    <button type="button" class="is-active" data-mode="background">Background</button>
                    <button type="button" data-mode="text">Text</button>
                </div>
                <label class="canva-check">
                    <input type="checkbox" id="ncvAutoContrast" checked>
                    Auto-fix text contrast when changing background
                </label>
                <div class="canva-swatches" id="ncvBrandSwatches">
                    <button type="button" data-color="#006837" style="background:#006837" title="Nasira green"></button>
                    <button type="button" data-color="#F37021" style="background:#F37021" title="Nasira orange"></button>
                    <button type="button" data-color="#0f766e" style="background:#0f766e" title="Teal"></button>
                    <button type="button" data-color="#1e3a5f" style="background:#1e3a5f" title="Navy"></button>
                    <button type="button" data-color="#9f1239" style="background:#9f1239" title="Rose"></button>
                    <button type="button" data-color="#7c3aed" style="background:#7c3aed" title="Violet"></button>
                    <button type="button" data-color="#111827" style="background:#111827" title="Ink"></button>
                    <button type="button" data-color="#f3f4f6" style="background:#f3f4f6;border:1px solid #ddd" title="Light gray"></button>
                    <button type="button" data-color="#ffffff" style="background:#fff;border:1px solid #ddd" title="White"></button>
                    <button type="button" data-color="#ecfdf5" style="background:#ecfdf5;border:1px solid #ddd" title="Mint"></button>
                    <button type="button" data-color="#fff7ed" style="background:#fff7ed;border:1px solid #ddd" title="Cream"></button>
                    <button type="button" data-color="#eff6ff" style="background:#eff6ff;border:1px solid #ddd" title="Sky"></button>
                </div>
                <label class="canva-select-label">Custom color
                    <input type="color" id="ncvCustomColor" value="#006837">
                </label>
                <div class="canva-brand-actions">
                    <button type="button" class="canva-btn ghost full" id="ncvPageBg">Apply to whole CV page</button>
                    <button type="button" class="canva-btn ghost full" id="ncvClear">Reset page</button>
                </div>
            </div>
        </aside>

        <main class="canva-desk">
            <div class="canva-formatbar" id="ncvFormatBar">
                <button type="button" data-cmd="bold" title="Bold"><b>B</b></button>
                <button type="button" data-cmd="italic" title="Italic"><i>I</i></button>
                <button type="button" data-cmd="underline" title="Underline"><u>U</u></button>
                <span class="sep"></span>
                <button type="button" data-cmd="left" title="Align left">☰</button>
                <button type="button" data-cmd="center" title="Align center">≡</button>
                <button type="button" data-cmd="right" title="Align right">☰</button>
            </div>
            <div class="canva-desk-scroll">
                <div id="ncvGjs"></div>
            </div>
            <div class="canva-zoombar">
                <button type="button" id="ncvZoomOut">−</button>
                <span id="ncvZoomLabel">70%</span>
                <button type="button" id="ncvZoomIn">+</button>
                <button type="button" id="ncvZoomFit" class="fit">Fit</button>
            </div>
        </main>

        <aside class="canva-inspector">
            <div class="canva-inspector-tabs">
                <button type="button" class="is-active" data-inspect="style">Style</button>
                <button type="button" data-inspect="position">Position</button>
            </div>
            <div class="canva-inspector-pane is-active" data-inspect-view="style">
                <div class="canva-section-pick" id="ncvSectionPick">
                    <p class="canva-help" style="margin-bottom:0.45rem;">Select a CV section first:</p>
                    <div class="canva-section-btns">
                        <button type="button" data-section="CV Page">Page</button>
                        <button type="button" data-section="Sidebar">Sidebar</button>
                        <button type="button" data-section="Main">Main</button>
                        <button type="button" data-section="Header">Header</button>
                        <button type="button" data-section="card">Card</button>
                    </div>
                </div>
                <div class="canva-quick-colors" id="ncvQuickColors">
                    <p class="canva-help">
                        <span id="ncvSelectedLabel">Nothing selected</span>
                        <br>Change fill or text:
                    </p>
                    <label class="canva-quick-row"><span>Background</span>
                        <input type="color" id="ncvFillColor" value="#ffffff" title="Background color">
                    </label>
                    <label class="canva-quick-row"><span>Text color</span>
                        <input type="color" id="ncvTextColor" value="#111827" title="Text color">
                    </label>
                </div>
                <div id="ncvStyles"></div>
                <div id="ncvTraits"></div>
            </div>
            <div class="canva-inspector-pane" data-inspect-view="position">
                <p class="canva-help"><strong>Position</strong> mode lets you drag elements anywhere on the page, like Canva. Use Flow for classic document layout.</p>
                <div class="canva-pos-actions">
                    <button type="button" class="canva-btn ghost full" id="ncvBringFront">Bring to front</button>
                    <button type="button" class="canva-btn ghost full" id="ncvSendBack">Send to back</button>
                </div>
            </div>
        </aside>
    </div>
</div>

<script src="https://unpkg.com/grapesjs@0.21.7"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="{{ asset('front_web/js/nasira-cv-canvas.js') }}?v=14"></script>
</body>
</html>
