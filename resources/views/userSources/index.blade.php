@php
    /** @var \Domain\Source\Models\Source $source */
@endphp

@component('layouts.user', [
    'title' => __('My feed'),
])
    <heading>{{ __('My feed') }}</heading>

    <div class="content">
        <p>
            Content creators can use aggregate to reach a wider audience.
            Before adding a feed, there's a few things you should know.
        </p>

        <content-disclaimer></content-disclaimer>
    </div>

    <form-component
        class="mt-8"
        :action="action([\App\Http\Controllers\UserSourcesController::class, 'update'])"
    >
        <text-field
            name="url"
            :label="__('URL')"
            :initial-value="$url"
        ></text-field>

        <small>
            Don't worry about finding the correct RSS url,
            we'll find it for you as long as you provide an existing URL to a blog.
        </small>

        <text-field
            class="mt-2"
            name="twitter_handle"
            :label="__('Twitter handle (optional)')"
            :initial-value="$twitterHandle"
        ></text-field>

        <select-field
            class="mt-2"
            name="topic_ids[]"
            :label="__('This blog is about')"
            :options="$topicOptions"
            :initial-value="$primaryTopicId"
        ></select-field>

        <select-field
            class="mt-2"
            name="language"
            :label="__('Language (optional)')"
            :options="$languageOptions"
            :initial-value="$language"
        ></select-field>

        @if($source && $source->isInactive())
            <p class="mt-3 text-green">
                {{ __("Your source is inactive at the moment. You'll receive an email when it's activated.") }}
            </p>
        @endif


        <div class="flex justify-between">
            <submit-button class="mt-3">
                {{ __('Save') }}
            </submit-button>

            @if($source)
                <a href="{{ action([\App\User\Controllers\UserSourcesController::class, 'confirmDelete']) }}"
                   class="
                mt-2 p-2
                leading-normal
                text-red-dark font-bold
            "
                >
                    {{ __('Delete feed') }}
                </a>
            @endif
        </div>
    </form-component>
@endcomponent
