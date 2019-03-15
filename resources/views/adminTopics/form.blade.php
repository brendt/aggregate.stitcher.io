@php
    /** @var \Domain\Post\Models\Topic|null $topic */
@endphp

@component('layouts.admin', [
    'title' => $topic ? $topic->name : 'New topic',
])
    <heading>
        {{ __('Topic') }}: {{ $topic ? $topic->name : 'New topic' }}
    </heading>

    <form-component
        class="mt-2"
        :action="$storeUrl"
    >
        <text-field
            name="name"
            :label="__('Name')"
            :initial-value="$name"
        ></text-field>

        <submit-button class="mt-3">
            {{ __('Save') }}
        </submit-button>

        <a class="ml-2" href="{{ action([\App\Http\Controllers\AdminTopicsController::class, 'index']) }}">
            {{ __('Back') }}
        </a>
    </form-component>
@endcomponent
