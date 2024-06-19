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

                            <x-tags class="mt-1">
                                @include('includes.postButtons')

                                @if($post->canPublish())
                                    <x-tag
                                        :x-url="action(\App\Http\Controllers\Posts\PublishPostController::class, ['post' => $post, ...request()->query->all()])"
                                        class="sendAsync"
                                        style="cursor:pointer;"
                                        color="green"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-500">
                                            <path d="M1 8.25a1.25 1.25 0 112.5 0v7.5a1.25 1.25 0 11-2.5 0v-7.5zM11 3V1.7c0-.268.14-.526.395-.607A2 2 0 0114 3c0 .995-.182 1.948-.514 2.826-.204.54.166 1.174.744 1.174h2.52c1.243 0 2.261 1.01 2.146 2.247a23.864 23.864 0 01-1.341 5.974C17.153 16.323 16.072 17 14.9 17h-3.192a3 3 0 01-1.341-.317l-2.734-1.366A3 3 0 006.292 15H5V8h.963c.685 0 1.258-.483 1.612-1.068a4.011 4.011 0 012.166-1.73c.432-.143.853-.386 1.011-.814.16-.432.248-.9.248-1.388z" />
                                        </svg>

                                        <span class="ml-1 text-gray-800">
                                            Publish
                                        </span>
                                    </x-tag>
                                @endif

                                @if($post->canDeny())
                                    <x-tag
                                        :x-url="action(\App\Http\Controllers\Posts\DenyPostController::class, ['post' => $post, ...request()->query->all()])"
                                        color="red"
                                        style="cursor:pointer;"
                                        class="sendAsync"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-500">
                                            <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd"/>
                                        </svg>

                                        <span class="ml-1 text-gray-800">
                                            Deny
                                        </span>
                                    </x-tag>
                                @endif
                            </x-tags>
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

        <script>
            const elements = document.querySelectorAll('.sendAsync');

            elements.forEach(function (element) {
                element.addEventListener('click', function (event) {
                    element.closest('.drag-container').remove();

                    fetch(element.getAttribute("x-url"), {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                        }
                    });

                    event.preventDefault();
                    event.stopPropagation();
                });
            })
        </script>
@endcomponent
