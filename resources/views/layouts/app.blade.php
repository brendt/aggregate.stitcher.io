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

    {{-- <script defer src="{{ mix('vendor.js') }}"></script> --}}
    <script defer src="{{ mix('js/app.js') }}"></script>
</head>
<body>

<header>
    <a href="{{ action([\App\Http\Controllers\PostsController::class, 'index']) }}">
        {{ __('Read') }}
    </a>

    @if(current_user())
        <a href="{{ action([\App\Http\Controllers\SourcesController::class, 'edit']) }}">
            {{ __('Sources') }}
        </a>

        <a href="{{ action([\App\Http\Controllers\Auth\LogoutController::class, 'logout']) }}">
            {{ __('Logout') }}
        </a>
    @else
        <a href="{{ action([\App\Http\Controllers\Auth\LoginController::class, 'login']) }}">
            {{ __('Login') }}
        </a>

        <a href="{{ action([\App\Http\Controllers\Auth\RegisterController::class, 'register']) }}">
            {{ __('Register') }}
        </a>
    @endif
</header>

<div id="app">
    {{ $slot ?? null }}
</div>

<script>
    const ajaxButtons = document.querySelectorAll('.ajax-button');

    for (let button of ajaxButtons) {
        button.addEventListener('click', onAjaxButtonClick.bind(button));
    }

    function onAjaxButtonClick(e) {
        e.stopPropagation();
        e.preventDefault();

        const form = this.parentElement;
        const action = form.action;

        const token = form.querySelector('input[name=_token]').value;

        let request = new XMLHttpRequest();

        request.open('POST', action, true);

        request.onload = function () {
            if (request.status < 200 || request.status >= 400) {
                // TODO
                return;
            }

            const data = JSON.parse(request.responseText);

            const callback = eval(this.getAttribute('data-done'));

            callback(data);
        }.bind(this);

        request.onerror = function () {
            // TODO
        }

        request.setRequestHeader('content-type', 'application/json');
        request.setRequestHeader('accept', 'application/json');

        request.send(JSON.stringify({
            '_token': token,
        }));
    }

    function updateVote (data) {
        const uuid = data.post_uuid;

        const voteCounter = document.querySelector(`#vote-count-${uuid}`);

        const addVoteButton = document.querySelector(`#add-vote-${uuid}`);
        const deleteVoteButton = document.querySelector(`#delete-vote-${uuid}`);

        if (data.voted_for) {
            addVoteButton.classList.add('hidden');
            deleteVoteButton.classList.remove('hidden');
        } else {
            addVoteButton.classList.remove('hidden');
            deleteVoteButton.classList.add('hidden');
        }

        voteCounter.innerHTML = data.vote_count;
    }
</script>

{{--<script>--}}
{{--window.locales = {!! json_encode(config('app.available_locales')) !!};--}}
{{--</script>--}}

{{--@include('admin.layouts.partials.bugsnag')--}}
</body>
</html>
