<?php
/**
 * @var string|null $title The webpage's title
 */

use function Tempest\get;
use function Tempest\Http\csrf_token;
use Tempest\Core\AppConfig;
$isProduction = get(AppConfig::class)->environment->isProduction();
?>

<!doctype html>
<html lang="en" class="h-dvh flex flex-col scroll-smooth md:p-4" :class="$isProduction ? 'bg-slate-700' : 'bg-green-800'">
<head>
    <title>{{ $title ?? 'Aggregate' }}</title>

    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <meta name="title" content="aggregate.stitcher.io">
    <meta name="description" content="My community-driven RSS feed">

    <x-slot name="head"/>
    <x-vite-tags />
</head>
<body class="flex flex-col h-full antialiased">

<main class="bg-gray-100 w-full min-h-full p-3 md:p-4 md:rounded-sm shadow-md overflow-auto relative">
    <x-slot/>
</main>
<x-slot name="scripts"/>

<script>
    document.body.addEventListener('htmx:configRequest', function (evt) {
        evt.detail.headers['x-xsrf-token'] = '{{ csrf_token() }}';
    });

    document.body.addEventListener('htmx:beforeOnLoad', function (evt) {
        if (evt.detail.xhr.status === 500) {
            document.querySelector('#htmx-error').innerHTML = evt.detail.xhr.statusText;
            document.querySelector('#htmx-error').classList.remove('hidden');
        }
    });
</script>

</body>
</html>
