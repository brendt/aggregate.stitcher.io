@php
    /** @var \Domain\User\Models\User $user */
    /** @var \Domain\Source\Models\Source[]|\Illuminate\Pagination\LengthAwarePaginator $sources */
@endphp

@component('layouts.app', [
    'title' => __('Delete source'),
    'fullWidth' => true,
])
    <heading>{{ __("Delete source {$source->website}?") }}</heading>

    <div class="mt-4">
        <form-component
            :action="action([\App\Http\Controllers\AdminSourcesController::class, 'delete'], $source)"
            class="flex items-baseline"
        >
            <submit-button class="ml-4 button-small bg-red-dark">
                {{ __('Yes, delete') }}
            </submit-button>

            <a
                href="{{ action([\App\Http\Controllers\AdminSourcesController::class, 'index']) }}"
                class="ml-3"
            >
                {{ __('Cancel') }}
            </a>
        </form-component>
    </div>
@endcomponent
