<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="{{ getAppName() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>404 Not Found | {{ getAppName() }}</title>
    <link href="{{asset('front_web/scss/bootstrap.css')}}" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container con-404 vh-100 d-flex justify-content-center">
    <div class="row justify-content-md-center d-block">
        <div class="col-md-12 mt-5">
            <img src="{{ asset('assets/img/404-error-image.png') }}" class="img-fluid img-404 mx-auto d-block">
        </div>
        <div class="col-md-12 text-center error-page-404">
            <h2>{{ __('messages.something_missing') }}</h2>
            <p class="not-found-subtitle">{{ __('messages.page_not_found') }}.</p>
            <a class="btn btn-primary back-btn mt-3"  href="{{ url()->previous() }}" >{{ __('messages.go_back') }}</a>
        </div>
    </div>
</div>
<script src="{{ asset('front_web/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
