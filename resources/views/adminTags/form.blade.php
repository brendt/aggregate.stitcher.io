@php
    /** @var \Domain\Post\Models\Tag|null $tag */
@endphp

@component('layouts.admin', [
    'title' => $tag ? $tag->name : 'New tag',
])
    <x-heading>
        {{ __('Tag') }}: {{ $tag ? $tag->name : 'New tag' }}
    </x-heading>

    <x-form-component
            class="mt-2"
            :action="$storeUrl"
    >
        <x-text-field
                name="name"
                :label="__('Name')"
                :initial-value="$name"
        ></x-text-field>

        <x-select-field
                name="topic_id"
                :label="__('Topic')"
                :initial-value="$tag ? $tag->topic_id : null"
                :options="$topicOptions"
        ></x-select-field>

        <x-text-field
                name="color"
                :label="__('Color')"
                :initial-value="$color"
        ></x-text-field>

        <x-textarea-field
                name="keywords"
                :label="__('Keywords')"
                :initial-value="$keywords"
        ></x-textarea-field>

        <x-submit-button class="mt-3">
            {{ __('Save') }}
        </x-submit-button>

        <a class="ml-2" href="{{ action([\App\Admin\Controllers\AdminTagsController::class, 'index']) }}">
            {{ __('Back') }}
        </a>
    </x-form-component>
@endcomponent
