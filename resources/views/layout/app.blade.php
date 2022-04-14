<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Read</title>
</head>
<body class="bg-gray-100">
{{ $slot }}

<div class="text-sm mb-4 pb-4 text-center text-gray-400">
    @if(!\Illuminate\Support\Facades\Auth::hasUser())
        <a class="underline hover:no-underline" href="{{ action([\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create']) }}">
            login
        </a>
    @else
        <a class="underline hover:no-underline" href="{{ action([\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy']) }}">
            logout
        </a>
    @endif
</div>
</body>
</html>
