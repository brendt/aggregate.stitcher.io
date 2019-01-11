@php
    /** @var \Domain\Source\Models\Source $source */
@endphp

@component('layouts.app', [
    'title' => __('My content'),
])
    <heading>{{ __('My content') }}</heading>

    <div class="w-5/6">
        <p class="mt-4 mb-2">
            {{ __("
                Here you can add your own RSS feed.
                New blog posts will automatically be shown on the aggregated overview.")
            }}
        </p>

        <p class="mt-2 mb-4">
            {{ __("
                Note that your source will have to be approved before content will show up here.
                You'll get notified via e-mail when it is approved.
            ") }}
        </p>
    </div>

    <form-component
        :action="action([\App\Http\Controllers\UserSourcesController::class, 'update'])"
    >
        <text-field
            name="url"
            :label="__('RSS url')"
            :initial-value="$url"
        ></text-field>

        @if($source && $source->isInactive())
            <p class="mt-3 text-red">
                {{ __("Your source is inactive at the moment. You'll recieve an email when it's activated.") }}
            </p>
        @endif

        <submit-button class="mt-3">
            {{ __('Save') }}
        </submit-button>
    </form-component>

    @if($source)
        <post-button
            :action="action([\App\Http\Controllers\UserSourcesController::class, 'delete'])"
            class="
                mt-2
                button
                bg-red text-white
                hover:bg-white hover:text-red
            "
        >
            {{ __('Delete source') }}
        </post-button>
    @endif
@endcomponent
