<?php
/** @var \Illuminate\Support\Collection|\App\Models\Post[] $posts */
?>

@component('layout.app')
    <div class="mx-auto container grid gap-4 mt-4">
        @include('includes.adminMenu')

        <div class="bg-white mx-4 shadow-md max-w-full">
            <div class="px-12 py-4 grid md:grid-cols-3 text-sm">
                <a
                    href="{{ action(\App\Http\Controllers\Posts\AdminPostsController::class, [
                        'show_all' => ! $showAll,
                    ] + request()->query->all()) }}"
                    class="underline hover:no-underline text-center"
                >{{ $showAll ? 'Only Pending' : 'Show All' }}</a>

                <a
                    href="{{ action(\App\Http\Controllers\Posts\AdminPostsController::class, [
                        'only_today' => ! $onlyToday,
                    ] + request()->query->all()) }}"
                    class="underline hover:no-underline text-center"
                >{{ $onlyToday ? 'All time' : 'Only today' }}</a>
            </div>

            <div class="flex">
                <div class="px-4 py-1 grow text-center bg-gray-200">pending</div>
                <div class="px-4 py-1 grow text-center bg-white">published</div>
                <div class="px-4 py-1 grow text-center bg-red-100">denied</div>
            </div>
        </div>

        <div class="bg-white mx-4 shadow-md grid">
            @if($message)
                <div class="px-12 py-4 bg-green-100 font-bold block text-center">
                    {{ $message }}
                </div>
            @endif

            <div>
                @foreach ($posts as $post)
                    <div>
                        <div
                            class="
                        block px-12 p-4
                        {{ $post->isPending() ? 'bg-gray-200' : '' }}
                        {{ $post->isStarred() ? 'bg-yellow-100' : '' }}
                        {{ $post->isDenied() ? 'bg-red-100' : '' }}
                        "
                        >
                            <h1 class="font-bold">
                                {{ $post->title }}
                            </h1>

                            <div class="text-sm font-light text-gray-800">
                                {{ $post->source->name }},

                                @php
                                    $diffInHours = $post->created_at->diffInHours(now())
                                @endphp

                                published

                                @if($diffInHours <= 1)
                                    right now
                                @elseif($diffInHours <= 24)
                                    {{ $diffInHours }} {{ \Illuminate\Support\Str::plural('hour', $diffInHours) }} ago
                                @else
                                    {{ $post->created_at->diffInDays(now()) }} {{ \Illuminate\Support\Str::plural('day', $post->created_at->diffInDays(now())) }}
                                    ago{{ $user ? ',' : '' }}
                                @endif

                                {{ $post->visits }} visits
                            </div>

                            <div class="flex gap-2 text-sm pt-2">
                                <a href="{{ $post->url }}"
                                   class="underline hover:no-underline mr-4 py-2"
                                >
                                    Show
                                </a>

                                @if($post->canPublish())
                                    <a href="{{ action(\App\Http\Controllers\Posts\PublishPostController::class, ['post' => $post, ...request()->query->all()]) }}"
                                       class="underline hover:no-underline text-green-600 mr-4 py-2"
                                    >
                                        Publish
                                    </a>
                                @endif

                                @if($post->canStar())
                                    <a href="{{ action(\App\Http\Controllers\Posts\StarPostController::class, ['post' => $post, ...request()->query->all()]) }}"
                                       class="underline hover:no-underline text-yellow-500 mr-4 py-2"
                                    >
                                        Star
                                    </a>
                                @endif

                                @if($post->canDeny())
                                    <a href="{{ action(\App\Http\Controllers\Posts\DenyPostController::class, ['post' => $post, ...request()->query->all()]) }}"
                                       class="underline hover:no-underline text-red-600 py-2"
                                    >
                                        Deny
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($posts->hasMorePages())
                <a class="px-12 py-4 font-bold block text-center hover:bg-pink-200" href="{{ $posts->nextPageUrl() }}"
                   title="Add your own">
                    more
                </a>
            @endif

            @if($posts->count())
                <a class="px-12 py-4 font-bold block text-center bg-red-100 hover:bg-red-300"
                   href="{{ action(\App\Http\Controllers\Posts\DenyPendingPostsController::class) }}"
                   >
                    Mark all pending as denied
                </a>
            @endif
        </div>
@endcomponent
