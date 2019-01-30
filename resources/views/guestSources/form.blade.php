@component('layouts.app', [
    'title' => __('Make a suggestion'),
])
    <h1 class="font-title text-2xl mt-4 mb-8">
        {{ __('Suggest a blog') }}
    </h1>

    <p>
        {{ __('
            Do you know a good blog that definitely should be added on aggregate?
            Leave your suggestion here!
        ') }}
    </p>

    <form-component
        :action="action([\App\Http\Controllers\GuestSourcesController::class, 'store'])"
        class="mt-4"
    >
        <text-field
            name="url"
            :label="__('RSS feed URL')"
            autofocus
        ></text-field>

        <div class="flex justify-between items-center mt-2">
            <submit-button>
                {{ __('Make suggestion!') }}
            </submit-button>
        </div>
    </form-component>
@endcomponent
