<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Aggregate</title>

    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <meta name="title" content="aggregate.stitcher.io">
    <meta name="description" content="My community-driven RSS feed">
</head>
<body class="bg-gray-100">

{{ $slot }}

<div class="text-sm my-4 pb-4 text-center text-gray-400 flex justify-center">
    <a href="/rss" class="underline hover:no-underline mr-4">
        RSS
    </a>
    
    <a href="https://github.com/brendt/aggregate.stitcher.io/projects/2" class="underline hover:no-underline mr-4">
        GitHub
    </a>

    @if(!\Illuminate\Support\Facades\Auth::hasUser())
        <a class="underline hover:no-underline"
           href="{{ action([\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create']) }}">
            login
        </a>
    @else
        <a class="underline hover:no-underline"
           href="{{ action([\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy']) }}">
            logout
        </a>
    @endif
</div>
</body>
</html>
