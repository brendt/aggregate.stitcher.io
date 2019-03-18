@component('layouts.app', [
    'title' => __('Make a suggestion'),
])
    <h1 class="font-title text-2xl mt-4 mb-8">
        {{ __('Suggest a blog') }}
    </h1>

    <div class="content">
        <p>
            {{ __('
                Do you know of a good blog that definitely should be added on aggregate?
                Leave your suggestion here!
            ') }}
        </p>
    </div>

    <form-component
        :action="action([\App\Http\Controllers\GuestSourcesController::class, 'store'])"
        class="mt-4"
    >
        <text-field
            name="url"
            :label="__('Blog URL')"
            autofocus
        ></text-field>

        <select-field
            name="topic_ids[]"
            :label="__('This blog is about')"
            :options="$topicOptions"
        ></select-field>

        <div class="flex justify-between items-center mt-2">
            <submit-button>
                {{ __('Make suggestion!') }}
            </submit-button>
        </div>
    </form-component>
@endcomponent
