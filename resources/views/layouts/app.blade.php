<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    @isset($title)
        <title>{{ $title }} — {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endisset

    {{--@include('admin.layouts.partials.favicons')--}}

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    {{--<link rel="stylesheet" href="{{ mix('css/vendor.css') }}" media="none" onload="this.media='all'">--}}
    <link href="https://fonts.googleapis.com/css?family=Hind:400,700|Volkhov:700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">

    {{-- <script defer src="{{ mix('vendor.js') }}"></script> --}}
    <script defer src="{{ mix('js/app.js') }}"></script>

    @livewireAssets
</head>
<body class="bg-black md:p-3 min-h-screen flex flex-col">
    <div class="bg-white flex-1 flex pb-8">
        <div class="w-full {{ $fullWidth ?? null ? '' : 'max-w-lg' }} mx-8 md:mx-16 md:flex pt-4 md:pt-8">

            <nav class="{{ $fullWidth ?? null ? '' : 'md:w-1/3' }} md:pr-12 flex md:flex-col items-start justify-between relative">
                <header class="h-12 mt:py-2 md:mb-8 flex items-center md:sticky pin-t">
                    @isset($header)
                        {{ $header }}
                    @else
                        <a href="{{ url('/') }}" class="font-title text-2xl text-primary font-bold">aggregate</a>
                        <span class="bg-black text-white rounded text-xs ml-2" style="padding: 0.25rem 0.25rem 0.1rem; margin-top: 0.15rem">beta</span>
                    @endisset
                </header>

                <div class="md:sticky md:b-4 mt-4 text-right md:text-left mb-8 md:mb-0">
                    <button class="menu-toggle flex md:hidden ml-auto focus:outline-none">
                        <i class="text-lg fas fa-bars mr-2"></i>
                        <span class="block uppercase text-sm font-bold" style="transform: translateY(3px)">Menu</span>
                    </button>
                    <ul class="menu text-sm text-grey-darker hidden md:block mt-4">
                        <li class="mb-2">
                            <active-link
                                :href="action([\App\Http\Controllers\PostsController::class, 'index'])"
                                :other="[
                                    action([\App\Http\Controllers\PostsController::class, 'all']),
                                    action([\App\Http\Controllers\PostsController::class, 'latest']),
                                    action([\App\Http\Controllers\PostsController::class, 'top']),
                                ]"
                            >
                                {{ __('Feed') }}
                            </active-link>
                        </li>

                        @if(! current_user())
                            <li class="mb-2">
                                <a href="{{ action([\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm']) }}">
                                    {{ __('Submit your feed') }}
                                </a>
                            </li>
                        @elseif(! current_user()->getPrimarySource())
                            <li class="mb-2">
                                <active-link :href="action([\App\Http\Controllers\UserSourcesController::class, 'index'])">
                                    {{ __('Submit your feed') }}
                                </active-link>
                            </li>
                        @endif
                        @if(current_user())
                            <li class="mb-2">
                                <active-link
                                    :href="action([\App\Http\Controllers\UserProfileController::class, 'index'])"
                                    :other="[
                                        action([\App\Http\Controllers\UserMutesController::class, 'index']),
                                        action([\App\Http\Controllers\UserSourcesController::class, 'index']),
                                    ]"
                                >
                                    {{ __('Profile') }}
                                </active-link>
                            </li>
                            <li>
                                <a href="{{ action([\App\Http\Controllers\Auth\LoginController::class, 'logout']) }}">
                                    {{ __('Log out') }}
                                </a>
                            </li>
                            @if(current_user()->isAdmin())
                                <li class="mt-6 mb-2">
                                    <active-link :href="action([\App\Http\Controllers\AdminSourcesController::class, 'index'])">
                                        {{ __('Admin') }}
                                    </active-link>
                                </li>
                                <li>
                                    <active-link href="/horizon" target="_blank" rel="noopener noreferrer">
                                        {{ __('Horizon') }}
                                    </active-link>
                                </li>
                            @endif
                        @else
                            <li class="mb-2">
                                <active-link :href="action([\App\Http\Controllers\Auth\LoginController::class, 'login'])">
                                    {{ __('Log in') }}
                                </active-link>
                            </li>
                            <li class="mb-2">
                                <active-link :href="action([\App\Http\Controllers\Auth\RegisterController::class, 'register'])">
                                    {{ __('Register') }}
                                </active-link>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>

            @if(flash()->message)
                <div class="
                        z-50
                        bg-white
                        {{ flash()->class }}
                        absolute
                        pin-r pin-t
                        mt-4
                        text-black
                        border-red
                        border-2
                        p-2 pt-3
                        cursor-pointer
                    "
                     onclick="this.classList.add('hidden')"
                >
                    {{ flash()->message }}
                </div>
            @endif

            <div class="flex-1">
                {{ $slot ?? null }}
            </div>
        </div>
    </div>

    <footer class="pt-6 md:pt-4 pb-4 md:pb-0 bg-black text-grey-dark text-sm">
        <div class="max-w-lg mx-8 md:mx-16">
            <ul class="flex flex-wrap md:w-2/3 ml-auto">
                <li class="w-full md:w-auto mb-2 md:mb-0 md:mr-6">
                    &copy; {{ now()->format('Y') }}
                    <a href="https://stitcher.io" target="_blank" rel="noopener noreferrer">
                        stitcher.io
                    </a>
                </li>
                <li class="mr-3 md:mr-6">
                    <a href="{{ action(\App\Http\Controllers\PrivacyController::class) }}">
                        Privacy &amp; disclaimer
                    </a>
                </li>
                <li>
                    <a href="https://github.com/brendt/aggregate.stitcher.io/issues" target="_blank" rel="noopener noreferrer">
                        {{ __('Report an issue') }}
                    </a>
                </span>
            </ul>
        </div>
    </footer>

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
