@php
    /** @var \Domain\Post\Models\Topic|null $topic */
@endphp

@component('layouts.admin', [
    'title' => $topic ? $topic->name : 'New topic',
])
    <x-heading>
        {{ __('Topic') }}: {{ $topic ? $topic->name : 'New topic' }}
    </x-heading>

    <form-component
        class="mt-2"
        :action="$storeUrl"
    >
        <x-text-field
            name="name"
            :label="__('Name')"
            :initial-value="$name"
        ></x-text-field>

        <x-submit-button class="mt-3">
            {{ __('Save') }}
        </x-submit-button>

        <a class="ml-2" href="{{ action([\App\Admin\Controllers\AdminTopicsController::class, 'index']) }}">
            {{ __('Back') }}
        </a>
    </form-component>
@endcomponent
