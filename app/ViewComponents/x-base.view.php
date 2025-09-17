<?php
/**
 * @var string|null $title The webpage's title
 */
use function Tempest\Http\csrf_token;
?>

<!doctype html>
<html lang="en" class="h-dvh flex flex-col scroll-smooth bg-gray-800 md:p-4">
<head>
    <title>{{ $title ?? 'Aggregate' }}</title>

    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

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
