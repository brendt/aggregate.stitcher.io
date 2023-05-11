<?php
/** @var \Illuminate\Support\Collection|\App\Models\Source[] $sources */
?>

@component('layout.app')
    <div class="mx-auto container grid gap-4 mt-4">
        @include('includes.adminMenu')
        <div class="bg-white mx-4 shadow-md max-w-full">
            <a
                class="hover:bg-pink-200 px-12 py-4 font-bold block text-center"
                href="{{ action(\App\Http\Controllers\Sources\SuggestSourceController::class) }}"
                title="Add new source"
            >
                Add Source
            </a>

            @foreach ($sources as $source)
                <div class="word-break border-b border-gray-200">
                    <div
                        class="
                                pt-6
                                block px-12 p-4
                                {{ $source->hasRecentError() ? 'bg-red-50' : '' }}
                                {{ $source->isPublishing() ? 'bg-blue-100' : '' }}
                                {{ $source->isPending() ? 'bg-gray-200' : '' }}
                                {{ $source->isDenied() ? 'bg-red-100' : '' }}
                                {{ $source->isInvalid() ? 'bg-red-300' : '' }}
                                {{ $source->isDuplicate() ? 'bg-orange-100' : '' }}
                            "
                    >
                        <h1 class="font-bold">
                            {{ $source->name }}
                            <span class="text-sm font-normal">— {{ $source->url }}</span>
                        </h1>

                        <div class="flex gap-2 text-sm pt-2">

                            @if($source->last_error_at)
                                <span class="font-bold text-red-400 py-2 mr-4">
                                    Last error at: {{ $source->last_error_at }}
                                </span>
                            @endif

                            @if($source->isPublished())
                                <a href="{{ action(\App\Http\Controllers\Sources\AdminSourceDetailController::class, $source) }}"
                                   class="underline hover:no-underline mr-4 py-2"
                                >
                                    Detail
                                </a>
                            @endif

                            <a href="{{ $source->getBaseUrl() }}"
                               class="underline hover:no-underline mr-4 py-2"
                            >
                                Show
                            </a>

                            @if($source->canPublish())
                                <a href="{{ action(\App\Http\Controllers\Sources\PublishSourceController::class, $source) }}"
                                   class="underline hover:no-underline text-green-600 mr-4 py-2"
                                >
                                    Publish
                                </a>
                            @endif

                            @if($source->canDeny())
                                <a href="{{ action(\App\Http\Controllers\Sources\DenySourceController::class, $source) }}"
                                   class="underline hover:no-underline text-red-600 py-2"
                                >
                                    Deny
                                </a>
                            @endif

                            @if($source->canDelete())
                                <a href="{{ action(\App\Http\Controllers\Sources\DeleteSourceController::class, $source) }}"
                                   class="underline hover:no-underline text-red-600 py-2"
                                >
                                    Delete
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
@endcomponent
