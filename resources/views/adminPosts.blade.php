<?php
/** @var \Illuminate\Support\Collection|\App\Models\Post[] $posts */
?>

@component('layout.app')
    @include('includes.drag')

    <div class="mx-auto container grid gap-4 mt-4">
        @include('includes.adminMenu')
        <div class="bg-white mx-4 shadow-md grid">
            @if($message)
                <div class="px-12 py-4 bg-green-100 font-bold block text-center">
                    {{ $message }}
                </div>
            @endif

            <div>

                <a
                    class="hover:bg-pink-200 px-12 py-4 font-bold block text-center"
                    href="{{ action(\App\Http\Controllers\Posts\CreatePostController::class) }}"
                    title="Add new post"
                >
                    Add Post
                </a>

                @foreach ($posts as $post)
                    <div class="drag-container">
                        <div
                            class="
                                border-b border-gray-200
                                drag bg-gray-200
                                word-break
                                block px-12 p-4
                                {{ $post->isPending() ? 'bg-gray-200' : '' }}
                                {{ $post->isStarred() ? 'bg-yellow-100' : '' }}
                                {{ $post->isDenied() ? 'bg-red-100' : '' }}
                            "
                            x-deny-url="{{ action(\App\Http\Controllers\Posts\DenyPostController::class, $post->id) }}"
                            x-save-url="{{ action(\App\Http\Controllers\Posts\PublishPostController::class, $post->id) }}"
                            x-counter-id="post-count"
                        >
                            <h1 class="font-bold">
                                {{ $post->title }}
                            </h1>

                            <div class="text-sm font-light text-gray-800">
                                {{ $post->getSourceName() }},

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
