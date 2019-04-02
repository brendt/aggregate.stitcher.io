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

        <content-disclaimer></content-disclaimer>

        <p>
            If you'd like to make full use of the platform,
            it's recommended to <a href="{{ action([\App\Http\Controllers\Auth\RegisterController::class, 'register']) }}">register an account</a> before adding your feed.
            If you want to suggest a blog anonymously, you can use the form below.
        </p>
    </div>

    <form-component
        :action="action([\App\Http\Controllers\GuestSourcesController::class, 'store'])"
        class="mt-4"
    >
        <text-field
            name="url"
            :label="__('URL')"
            autofocus
        ></text-field>

        <small>
            Don't worry about finding the correct RSS url,
            we'll find it for you as long as you provide an existing URL to a blog.
        </small>

        <select-field
            class="mt-2"
            name="topic_ids[]"
            :label="__('This blog is about')"
            :options="$topicOptions"
        ></select-field>

        <div class="flex justify-between items-center mt-2">
            <submit-button>
                {{ __('Submit') }}
            </submit-button>
        </div>
    </form-component>
@endcomponent
