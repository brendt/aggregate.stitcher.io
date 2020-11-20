@php
    /** @var \Domain\Source\Models\Source $source */
@endphp

@component('layouts.user', [
    'title' => __('Report spam'),
])
    <x-heading>{{ __('Report spam') }}</x-heading>

    <div class="content">
        <p>
            Please mention in details why this source is a spam.
        </p>

    </div>

    <x-form-component
            class="mt-8"
            :action="$source->getReportUrl()"
    >
        <x-textarea-field
                required
                name="report"
        ></x-textarea-field>


        <div class="flex justify-between">
            <x-submit-button class="mt-3">
                {{ __('Save') }}
            </x-submit-button>

        </div>
    </x-form-component>
@endcomponent
