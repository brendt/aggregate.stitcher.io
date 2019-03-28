@component('layouts.app', [
    'title' => $title ?? null,
    'fullWidth' => true,
])
    <nav class="bg-grey-lighter p-3 pt-4 flex">
        <active-link
            :href="action([\App\Http\Controllers\AdminAnalyticsController::class, 'index'])"
        >{{ __('Analytics') }}</active-link>

        <active-link
            :href="action([\App\Http\Controllers\AdminSourcesController::class, 'index'])"
            class="ml-2"
        >{{ __('Sources') }}</active-link>

        <active-link
            :href="action([\App\Http\Controllers\AdminTopicsController::class, 'index'])"
            class="ml-2"
        >{{ __('Topics') }}</active-link>

        <active-link
            :href="action([\App\Http\Controllers\AdminTagsController::class, 'index'])"
            class="ml-2"
        >{{ __('Tags') }}</active-link>
    </nav>

    {{ $slot }}
@endcomponent
