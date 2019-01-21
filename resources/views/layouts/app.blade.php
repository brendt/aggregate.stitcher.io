<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @isset($title)
        <title>{{ $title }} — {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endisset

    {{--@include('admin.layouts.partials.favicons')--}}

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    {{--<link rel="stylesheet" href="{{ mix('css/vendor.css') }}" media="none" onload="this.media='all'">--}}
    <link href="https://fonts.googleapis.com/css?family=Hind:400,700" rel="stylesheet">

    {{-- <script defer src="{{ mix('vendor.js') }}"></script> --}}
    <script defer src="{{ mix('js/app.js') }}"></script>
</head>
<body>
<div class="max-w-lg mx-auto px-8">
    <nav class="bg-grey-lightest rounded mt-4 mb-2 -mx-2 p-3 pb-2 text-sm text-grey-dark flex justify-between">
        <ul class="flex items-center">
            <li class="mr-4">
                <a href="{{ action([\App\Http\Controllers\PostsController::class, 'index']) }}">
                    {{ __('All') }}
                </a>
            </li>
            <li class="mr-4">
                <a href="{{ action([\App\Http\Controllers\PostsController::class, 'latest']) }}">
                    {{ __('Latest') }}
                </a>
            </li>
            {{--<li>--}}
            {{--<a href="{{ action([\App\Http\Controllers\TopicsController::class, 'index']) }}">--}}
            {{--{{ __('Topics') }}--}}
            {{--</a>--}}
            {{--</li>--}}
        </ul>
        <ul class="flex items-center">
            @if(current_user())
                <li class="mr-4">
                    <a href="{{ action([\App\Http\Controllers\UserSourcesController::class, 'index']) }}">
                        {{ __('My content') }}
                    </a>
                </li>
                <li class="mr-4">
                    <a href="{{ action([\App\Http\Controllers\UserMutesController::class, 'index']) }}">
                        {{ __('Mutes') }}
                    </a>
                </li>
                @if(current_user()->isAdmin())
                    <li class="mr-4">
                        <a href="{{ action([\App\Http\Controllers\AdminSourcesController::class, 'index']) }}">
                            {{ __('Admin') }}
                        </a>
                    </li>
                @endif
                <li class="mr-4">
                    <a href="{{ action([\App\Http\Controllers\Auth\LogoutController::class, 'logout']) }}">
                        {{ __('Log out') }}
                    </a>
                </li>
            @else
                <li class="mr-4">
                    <a href="{{ action([\App\Http\Controllers\Auth\LoginController::class, 'login']) }}">
                        {{ __('Log in') }}
                    </a>
                </li>
                <li class="mr-4">
                    <a href="{{ action([\App\Http\Controllers\Auth\RegisterController::class, 'register']) }}">
                        {{ __('Register') }}
                    </a>
                </li>
            @endif

            <li class="mr-4 text-red-dark">
                <a href="https://github.com/brendt/aggregate-roadmap/issues" target="_blank" rel="noopener noreferrer">
                    {{ __('Report an issue') }}
                </a>
            </li>

            @if(! current_user())
                <li class="button button-small button-green">
                    <a href="{{ action([\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm']) }}">
                        {{ __('Submit your blog') }}
                    </a>
                </li>
            @elseif(! current_user()->getPrimarySource())
                <li class="button button-small button-green">
                    <a href="{{ action([\App\Http\Controllers\UserSourcesController::class, 'index']) }}">
                        {{ __('Submit your blog') }}
                    </a>
                </li>
            @endif
        </ul>
    </nav>

    @include('flash::message')

    <div class="flex-1">
        {{ $slot ?? null }}
    </div>
</div>

<div class="mt-6 p-8 bg-grey-darker text-grey-light">
    <div class="max-w-lg mx-auto px-8">
        <span>&copy; {{ now()->format('Y') }} <a href="https://stitcher.io" target="_blank" rel="noopener noreferrer">stitcher.io</a></span>
        <span class="ml-4"><a href="{{ action(\App\Http\Controllers\PrivacyController::class) }}">privacy &amp; disclaimer</a></span>
    </div>
</div>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ config('app.analytics_id') }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', '{{ config('app.analytics_id') }}');
</script>
</body>
</html>
