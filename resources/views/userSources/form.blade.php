@php
    /** @var \Domain\Source\Models\Source $source */
@endphp

@component('layouts.app', [
    'title' => __('Sources'),
])
    <h2 class="text-xl mt-4">My content</h2>

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
        class="w-2/5"
    >
        <text-field
            name="url"
            :label="__('RSS url')"
            :initial-value="$url"
        ></text-field>

        <submit-button class="mt-3">
            {{ __('Save') }}
        </submit-button>
    </form-component>

    <form-component
        :action="action([\App\Http\Controllers\UserSourcesController::class, 'delete'])"
        class="w-2/5 mt-2"
    >
        <submit-button class="
            bg-red text-white
            hover:bg-white hover:text-red
        ">
            {{ __('Delete source') }}
        </submit-button>
    </form-component>
@endcomponent
