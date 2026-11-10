@extends('layouts.app')
@section('title')
    Appearance
@endsection
@section('content')
    <style>
        .appearance-tabs .nav-link { cursor: pointer; }
        .appearance-token-row { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
        .appearance-token-row label { min-width: 180px; margin: 0; font-weight: 500; }
        .appearance-token-row input[type="color"] {
            width: 48px; height: 36px; padding: 2px; border: 1px solid #d9e3dd; border-radius: 6px; background: #fff;
        }
        .appearance-token-row .hex-input,
        .appearance-token-row .px-input,
        .appearance-token-row select {
            max-width: 220px;
        }
        .appearance-section-title {
            font-size: 13px; text-transform: uppercase; letter-spacing: .04em;
            color: #5f6e66; margin: 18px 0 10px;
        }
        .appearance-preview-swatch {
            display: inline-flex; gap: 8px; flex-wrap: wrap; margin-bottom: 16px;
        }
        .appearance-preview-swatch span {
            width: 36px; height: 36px; border-radius: 8px; border: 1px solid #d9e3dd;
        }
        .appearance-hint { font-size: 12px; color: #5f6e66; }
    </style>
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            @include('layouts.errors')

            <div class="d-flex flex-wrap justify-content-between align-items-center mb-5 gap-3">
                <div>
                    <h1 class="mb-1">Appearance</h1>
                    <p class="text-muted mb-0">Theme colors and typography for the public site (same system as Eaglopia Front).</p>
                </div>
                <form action="{{ route('appearance.reset') }}" method="POST" onsubmit="return confirm('Reset appearance to Nasira defaults?');">
                    @csrf
                    <button type="submit" class="btn btn-light-danger">Reset to defaults</button>
                </form>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="appearance-preview-swatch" id="appearancePreview">
                        <span title="Primary" style="background: {{ $tokens['primary'] }}"></span>
                        <span title="Accent" style="background: {{ $tokens['accent'] }}"></span>
                        <span title="Secondary" style="background: {{ $tokens['secondary'] }}"></span>
                        <span title="Muted" style="background: {{ $tokens['muted'] }}"></span>
                        <span title="Border" style="background: {{ $tokens['border'] }}"></span>
                    </div>

                    <ul class="nav nav-tabs appearance-tabs mb-4" role="tablist">
                        @foreach($schema['groups'] as $groupKey => $group)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                        id="tab-{{ $groupKey }}"
                                        data-bs-toggle="tab"
                                        data-bs-target="#pane-{{ $groupKey }}"
                                        type="button"
                                        role="tab">
                                    {{ $group['label'] }}
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    <form action="{{ route('appearance.update') }}" method="POST" id="appearanceForm">
                        @csrf
                        <div class="tab-content">
                            @foreach($schema['groups'] as $groupKey => $group)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                     id="pane-{{ $groupKey }}"
                                     role="tabpanel">
                                    <p class="text-muted mb-4">{{ $group['description'] ?? '' }}</p>

                                    @if(!empty($group['sections']))
                                        @foreach($group['sections'] as $section)
                                            <div class="appearance-section-title">{{ $section['label'] }}</div>
                                            @foreach($section['tokens'] as $tokenKey)
                                                @include('appearance.token-field', [
                                                    'tokenKey' => $tokenKey,
                                                    'meta' => $schema['token_meta'][$tokenKey] ?? ['label' => $tokenKey, 'type' => 'color'],
                                                    'value' => $tokens[$tokenKey] ?? ($defaults[$tokenKey] ?? ''),
                                                    'fonts' => $schema['fonts'],
                                                ])
                                            @endforeach
                                        @endforeach
                                    @elseif(!empty($group['tokens']))
                                        @foreach($group['tokens'] as $tokenKey)
                                            @include('appearance.token-field', [
                                                'tokenKey' => $tokenKey,
                                                'meta' => $schema['token_meta'][$tokenKey] ?? ['label' => $tokenKey, 'type' => 'color'],
                                                'value' => $tokens[$tokenKey] ?? ($defaults[$tokenKey] ?? ''),
                                                'fonts' => $schema['fonts'],
                                            ])
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-5 d-flex gap-3">
                            <button type="submit" class="btn btn-primary">Save appearance</button>
                            <a href="{{ url('/') }}" target="_blank" class="btn btn-light">Preview site</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page_scripts')
<script>
    document.querySelectorAll('.appearance-color-pair').forEach(function (row) {
        var color = row.querySelector('input[type="color"]');
        var hex = row.querySelector('.hex-input');
        if (!color || !hex) return;
        color.addEventListener('input', function () {
            hex.value = color.value;
            var preview = document.querySelector('#appearancePreview span[title="' + (row.dataset.preview || '') + '"]');
            if (preview) preview.style.background = color.value;
        });
        hex.addEventListener('input', function () {
            if (/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/.test(hex.value)) {
                color.value = hex.value.length === 4
                    ? '#' + hex.value[1] + hex.value[1] + hex.value[2] + hex.value[2] + hex.value[3] + hex.value[3]
                    : hex.value;
            }
        });
    });

    document.querySelectorAll('.px-number').forEach(function (input) {
        var hidden = input.parentElement.querySelector('.px-hidden');
        input.addEventListener('input', function () {
            hidden.value = input.value + 'px';
        });
    });

    var appearanceForm = document.getElementById('appearanceForm');
    if (appearanceForm) {
        appearanceForm.addEventListener('submit', function () {
            document.querySelectorAll('.appearance-color-pair').forEach(function (row) {
                var color = row.querySelector('input[type="color"]');
                var hex = row.querySelector('.hex-input');
                if (color && hex) hex.value = color.value;
            });
            document.querySelectorAll('.px-number').forEach(function (input) {
                var hidden = input.parentElement.querySelector('.px-hidden');
                if (hidden) hidden.value = input.value + 'px';
            });
        });
    }
</script>
@endsection
