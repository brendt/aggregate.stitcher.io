@component('layouts.app', [
    'title' => __('Make a suggestion'),
])
    <h1 class="font-title text-2xl mt-4 mb-8">
        {{ __('Suggest a feed') }}
    </h1>

    <div class="content">
        <p>
            Are you a content creator yourself?
            Here's a few things you should know before adding your feed on aggregate:
        </p>

        <x-content-disclaimer></x-content-disclaimer>

        <p>
            If you'd like to make full use of the platform,
            it's recommended to <a href="{{ action([\App\User\Controllers\RegisterController::class, 'register']) }}">register
                an account</a> before adding your feed.
            If you want to suggest a blog anonymously, you can use the form below.
        </p>
    </div>

    <x-form-component
            :action="action([\App\User\Controllers\GuestSourcesController::class, 'store'])"
            class="mt-4"
    >
        <x-text-field
                name="url"
                :label="__('URL')"
                autofocus
        ></x-text-field>

        <small>
            Don't worry about finding the correct RSS url,
            we'll find it for you as long as you provide an existing URL to a blog.
        </small>

        <x-select-field
                class="mt-2"
                name="topic_ids[]"
                :label="__('This blog is about')"
                :options="$topicOptions"
        ></x-select-field>

        <x-select-field
                class="mt-2"
                name="language"
                :label="__('Language (optional)')"
                :options="$languageOptions"
        ></x-select-field>

        <div class="flex justify-between items-center mt-2">
            <x-submit-button>
                {{ __('Submit') }}
            </x-submit-button>
        </div>
    </x-form-component>
@endcomponent
