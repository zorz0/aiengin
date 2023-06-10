<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" href="/favicon.png" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <link rel="apple-touch-icon" href="/logo192.png" />
    <link rel="manifest" href="/manifest.json" />
    <title>{{ MetaTag::get('title') }}</title>
    <meta name="description" property="description" content="{!! MetaTag::get('description') !!}">
    <meta name="keywords" property="keywords" content="{!! MetaTag::get('keywords') !!}">
    <meta name="image" property="image" content="{!! MetaTag::get('image') ? MetaTag::get('image') : url('/logo512.png') !!}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ MetaTag::get('title') }}">
    <meta property="og:description" content="{!! MetaTag::get('description') !!}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{!! MetaTag::get('image') ? MetaTag::get('image') : url('/logo512.png') !!}">
    <meta property="og:site_name" content="{{ MetaTag::get('title') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css?v={{ env('APP_VERSION') }}">
    <link rel="stylesheet" href="/assets/css/style-dark.css?v={{ env('APP_VERSION') }}">
    <link rel="stylesheet" href="/assets/css/custom.css?v={{ env('APP_VERSION') }}">
    <script>
        window.API_URL = "/api", window.EXTENAL_HTML = "{{ config('settings.external_html', false) }}", window.DEFAULT_DARKMODE = "{{ config('settings.dark_mode') }}", window.FACEBOOK_LOGIN = "{{ config('settings.facebook_login') }}", window.TWITTER_LOGIN = "{{ config('settings.twitter_login') }}", window.APPLE_LOGIN = "{{ config('settings.apple_login') }}", window.CURRENCY_SYMBOL = "{{ __('symbol.' . config('settings.currency', 'USD')) }}"
    </script>
    <script defer="defer" src="/static/js/main.98bdd019.js"></script>
</head>

<body class="dark-theme"><noscript>You need to enable JavaScript to run this app.</noscript>
<div id="root"></div>
</body>

</html>
