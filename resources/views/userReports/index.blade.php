@php
    /** @var \Domain\Source\Models\Source $source */
@endphp

@component('layouts.user', [
    'title' => __('Report spam'),
])
    <heading>{{ __('Report spam') }}</heading>

    <div class="content">
        <p>
            Please mention in details why this source is a spam.
        </p>

    </div>

    <form-component
            class="mt-8"
            :action="$source->getReportUrl()"
    >
        <textarea-field
                required
                name="report"
        ></textarea-field>


        <div class="flex justify-between">
            <submit-button class="mt-3">
                {{ __('Save') }}
            </submit-button>

        </div>
    </form-component>
@endcomponent
