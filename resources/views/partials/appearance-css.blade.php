@php
    try {
        $appearance = app(\App\Services\AppearanceManager::class);
        $fontImport = $appearance->fontImportUrl();
        $inlineCss = $appearance->inlineCss();
    } catch (\Throwable $e) {
        $fontImport = null;
        $inlineCss = null;
    }
@endphp
@if ($fontImport)
    <link rel="stylesheet" href="{{ $fontImport }}">
@endif
@if ($inlineCss)
    <style id="nasira-appearance-vars">{!! $inlineCss !!}</style>
@endif
