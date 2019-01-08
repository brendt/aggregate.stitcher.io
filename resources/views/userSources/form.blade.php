@php
    /** @var \Domain\Source\Models\Source $source */
@endphp

@component('layouts.app', [
    'title' => __('Sources'),
])
    <form-component
        :action="action([\App\Http\Controllers\UserSourcesController::class, 'update'])"
        class="w-2/5"
    >
        <text-field
            name="url"
            :label="__('URL')"
            :initial-value="$url"
        ></text-field>

        <submit-button>
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
