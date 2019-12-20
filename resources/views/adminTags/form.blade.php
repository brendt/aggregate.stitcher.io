@php
    /** @var \Domain\Post\Models\Tag|null $tag */
@endphp

@component('layouts.admin', [
    'title' => $tag ? $tag->name : 'New tag',
])
    <heading>
        {{ __('Tag') }}: {{ $tag ? $tag->name : 'New tag' }}
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

        <select-field
            name="topic_id"
            :label="__('Topic')"
            :initial-value="$tag ? $tag->topic_id : null"
            :options="$topicOptions"
        ></select-field>

        <text-field
            name="color"
            :label="__('Color')"
            :initial-value="$color"
        ></text-field>

        <textarea-field
            name="keywords"
            :label="__('Keywords')"
            :initial-value="$keywords"
        ></textarea-field>

        <submit-button class="mt-3">
            {{ __('Save') }}
        </submit-button>

        <a class="ml-2" href="{{ action([\App\Admin\Controllers\AdminTagsController::class, 'index']) }}">
            {{ __('Back') }}
        </a>
    </form-component>
@endcomponent
