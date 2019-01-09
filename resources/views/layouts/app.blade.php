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
                <ul class="flex">
                    <li class="mr-4">
                        <a href="{{ action([\App\Http\Controllers\PostsController::class, 'index']) }}">
                            {{ __('All') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ action([\App\Http\Controllers\PostsController::class, 'latest']) }}">
                            {{ __('Latest') }}
                        </a>
                    </li>
                </ul>
                <ul class="flex">
                    @if(current_user())
                        <li class="mr-4">
                            <a href="{{ action([\App\Http\Controllers\UserSourcesController::class, 'edit']) }}">
                                {{ __('My content') }}
                            </a>
                        </li>
                        <li class="mr-4">
                            <a href="{{ action([\App\Http\Controllers\UserMutesController::class, 'index']) }}">
                                {{ __('Mutes') }}
                            </a>
                        </li>
                        <li>
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
                        <li>
                            <a href="{{ action([\App\Http\Controllers\Auth\RegisterController::class, 'register']) }}">
                                {{ __('Register') }}
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
            <div class="flex-1">
                {{ $slot ?? null }}
            </div>
        </div>
    </body>
</html>
