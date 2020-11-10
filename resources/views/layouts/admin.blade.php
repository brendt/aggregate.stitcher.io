@php
    /** @var \Domain\Analytics\PreloadStatus|null $preloadStatus */
@endphp

@component('layouts.app', [
    'title' => $title ?? null,
    'fullWidth' => true,
])
    <nav class="bg-grey-lighter p-3 pt-4 flex justify-between">
        <div class="flex">
            <x-active-link
                :href="action([\App\Admin\Controllers\AdminAnalyticsController::class, 'index'], ['sort' => '-view_count'])"
            >{{ __('Analytics') }}</x-active-link>

            <x-active-link
                class="ml-4"
                :href="action([\App\Admin\Controllers\AdminAnalyticsController::class, 'pageCache'])"
            >{{ __('Analytics: page cache') }}</x-active-link>

            <x-active-link
                :href="action([\App\Admin\Controllers\AdminSourcesController::class, 'index'])"
                class="ml-4"
            >{{ __('Sources') }}</x-active-link>

            <x-active-link
                :href="action([\App\Admin\Controllers\AdminTopicsController::class, 'index'])"
                class="ml-4"
            >{{ __('Topics') }}</x-active-link>

            <x-active-link
                :href="action([\App\Admin\Controllers\AdminTagsController::class, 'index'])"
                class="ml-4"
            >{{ __('Tags') }}</x-active-link>
        </div>

        <div class="flex ">
            <div class="font-mono text-sm ml-4">
                <strong>pagecache</strong>
                @isset($pageCacheEnabled)
                    <span class="text-green">enabled</span>
                @else
                    <span class="text-red">disabled</span>
                @endisset
            </div>

            <div class="font-mono text-sm ml-2">
                <strong>preloading</strong>
                @isset($preloadStatus)
                    <span class="text-green">enabled</span> ({{$preloadStatus->classes_loaded}} classes, {{$preloadStatus->functions_loaded}} functions, {{$preloadStatus->memory_consumption}})
                @else
                    <span class="text-red">disabled</span>
                @endisset
            </div>
        </div>
    </nav>

    {{ $slot }}
@endcomponent
