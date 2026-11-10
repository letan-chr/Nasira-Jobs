@php
    $type = $meta['type'] ?? 'color';
    $label = $meta['label'] ?? $tokenKey;
    $hint = $meta['hint'] ?? null;
    $name = 'tokens['.$tokenKey.']';
@endphp

@if ($type === 'color')
    <div class="appearance-token-row appearance-color-pair" data-preview="{{ ucfirst(explode('-', $tokenKey)[0]) }}">
        <label for="token-{{ $tokenKey }}">{{ $label }}</label>
        <input type="color" value="{{ $value }}" aria-label="{{ $label }} color">
        <input type="text"
               class="form-control form-control-sm hex-input"
               id="token-{{ $tokenKey }}"
               name="{{ $name }}"
               value="{{ $value }}"
               pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
               required>
    </div>
@elseif ($type === 'font')
    <div class="appearance-token-row">
        <label for="token-{{ $tokenKey }}">{{ $label }}</label>
        <select class="form-select form-select-sm" id="token-{{ $tokenKey }}" name="{{ $name }}" required>
            @foreach($fonts as $font)
                <option value="{{ $font['value'] }}" @selected($value === $font['value'])>
                    {{ $font['label'] }}
                </option>
            @endforeach
        </select>
    </div>
@elseif ($type === 'px')
    @php $number = (float) str_replace('px', '', (string) $value); @endphp
    <div class="appearance-token-row">
        <label for="token-{{ $tokenKey }}">{{ $label }}</label>
        <input type="number"
               class="form-control form-control-sm px-input px-number"
               id="token-{{ $tokenKey }}"
               value="{{ $number }}"
               min="{{ $meta['min'] ?? 8 }}"
               max="{{ $meta['max'] ?? 72 }}"
               step="1">
        <input type="hidden" class="px-hidden" name="{{ $name }}" value="{{ $value }}">
        <span class="appearance-hint">px @if($hint)— {{ $hint }}@endif</span>
    </div>
@endif
