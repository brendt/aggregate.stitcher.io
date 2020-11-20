@php
    /** @var \Domain\Source\Models\Source $source */
@endphp

@component('layouts.admin', [
    'title' => $source->getName(),
])
    <x-heading>
        {{ $source->getName() }}
    </x-heading>

    <div class="mt-2">
        <a
                class="link text-grey-darker"
                href="http://{{ $source->website }}"
        >
            {{ __('Website') }}</a>&nbsp;–
        <a
                class="link text-grey-darker"
                href="{{ $source->url }}"
        >
            {{ __('RSS') }}</a>&nbsp;–
        <a
                class="link text-grey-darker"
                href="{{ action([\App\Feed\Controllers\PostsController::class, 'source'], $source->website) }}"
        >
            {{ __('Filtered') }}
        </a>
    </div>

    @if($viewsPerDay->isNotEmpty())
        <div class="mt-2 lg-max:hidden">
            <x-source-chart :views-per-day="$viewsPerDay" :votes-per-day="$votesPerDay"></x-source-chart>
        </div>
    @endif

    <x-form-component
            class="mt-8"
            :action="action([\App\Admin\Controllers\AdminSourcesController::class, 'update'], $source)"
    >
        <div class="w-3/5">
            <x-text-field
                    name="url"
                    :label="__('RSS url')"
                    :initial-value="$url"
            ></x-text-field>

            <x-text-field
                    name="twitter_handle"
                    :label="__('Twitter handle (optional)')"
                    :initial-value="$twitterHandle"
            ></x-text-field>

            <x-select-field
                    name="language"
                    :label="__('Language')"
                    :initial-value="$language"
                    :options="$languageOptions"
            ></x-select-field>

            <x-checkboxes-field
                    class="mt-2"
                    name="topic_ids[]"
                    :label="__('Topics')"
                    :options="$topicOptions"
                    :initial-values="$topics"
            ></x-checkboxes-field>

            <x-checkbox-field
                    name="is_active"
                    :label="__('Is active')"
                    :initial-value="$isActive"
            ></x-checkbox-field>

            <x-checkbox-field
                    name="is_validated"
                    :label="__('Is validated')"
                    :initial-value="$isValidated"
            ></x-checkbox-field>
        </div>

        <div class="flex justify-between items-center mt-4">
            <div>
                <x-submit-button class="mt-3">
                    {{ __('Save') }}
                </x-submit-button>

                <a class="ml-2" href="{{ action([\App\Admin\Controllers\AdminSourcesController::class, 'index']) }}">
                    {{ __('Back') }}
                </a>
            </div>
        </div>
    </x-form-component>

    <div class="md:flex md:justify-end">
        @if(!$source->is_active)
            <x-post-button
                    class="text-green font-bold py-4 md:px-3"
                    :action="action([\App\Admin\Controllers\AdminSourcesController::class, 'activate'], $source->uuid)"
            >
                {{ __('Activate') }}
            </x-post-button>
        @else
            <x-post-button
                    class="font-bold py-4 md:px-3"
                    :action="action([\App\Admin\Controllers\AdminSourcesController::class, 'sync'], $source->uuid)"
            >
                {{ __('Sync now') }}
            </x-post-button>
        @endif

        <a
                href="{{ action([\App\Admin\Controllers\AdminSourcesController::class, 'confirmDelete'], $source) }}"
                class="md:ml-2 text-red font-bold py-4 md:px-3"
        >
            {{ __('Delete') }}
        </a>
    </div>
@endcomponent
