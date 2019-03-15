@php
    /** @var \Domain\Source\Models\Source $source */
@endphp

@component('layouts.admin', [
    'title' => $source->getName(),
])
    <heading>
        <a href="http://{{ $source->website }}" target="_blank" rel="noopener noreferrer">
            {{ $source->getName() }}
        </a>
    </heading>

    <form-component
        class="mt-2"
        :action="action([\App\Http\Controllers\AdminSourcesController::class, 'update'], $source)"
    >
        <text-field
            name="url"
            :label="__('RSS url')"
            :initial-value="$url"
        ></text-field>

        <text-field
            name="twitter_handle"
            :label="__('Twitter handle (optional)')"
            :initial-value="$twitterHandle"
        ></text-field>

        <submit-button class="mt-3">
            {{ __('Save') }}
        </submit-button>

        <a class="ml-2" href="{{ action([\App\Http\Controllers\AdminSourcesController::class, 'index']) }}">
            {{ __('Back') }}
        </a>
    </form-component>
@endcomponent
