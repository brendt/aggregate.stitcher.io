@php
    $hoverColor = match(true) {
        $post->isStarred() => 'yellow-300',
        $post->isTweet() => 'blue-100',
        default => 'pink-100',
    };

    /** @var \App\Models\Post $post */
@endphp

<div class="overflow-x-hidden border-b border-gray-200 pt-2">
    <div
        class="
            word-break
            block lg:px-12 p-4
        "
    >
        <div class="md:flex items-end">
            <div class="break-words">
                <h1 class="font-bold break-words">
                    {{ $post->getParsedTitle() }}
                    <span class="text-sm font-light">
                        — {{ $post->getShortSourceName() }}
                    </span>
                </h1>

                <div class="flex flex-wrap text-xs mt-1">
                    <a class="bg-gray-100 hover:bg-gray-200 hover:border-gray-300 rounded border py-1 px-2 flex items-center" href="{{ $post->getPublicUrl() }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-500">
                            <path fill-rule="evenodd" d="M4.25 5.5a.75.75 0 00-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 00.75-.75v-4a.75.75 0 011.5 0v4A2.25 2.25 0 0112.75 17h-8.5A2.25 2.25 0 012 14.75v-8.5A2.25 2.25 0 014.25 4h5a.75.75 0 010 1.5h-5z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M6.194 12.753a.75.75 0 001.06.053L16.5 4.44v2.81a.75.75 0 001.5 0v-4.5a.75.75 0 00-.75-.75h-4.5a.75.75 0 000 1.5h2.553l-9.056 8.194a.75.75 0 00-.053 1.06z" clip-rule="evenodd" />
                        </svg>
                        <span class="ml-1 text-gray-800">
                            {{ $post->visits }}
                        </span>
                    </a>

                    <div class="bg-gray-100 ml-2 rounded border py-1 px-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                        </svg>

                        @php
                            $diffInHours = ($post->published_at ?? $post->created_at)->diffInHours(now())
                        @endphp

                        <span class="ml-1 text-gray-800">
                            @if($diffInHours <= 1)
                                right now
                            @elseif($diffInHours <= 24)
                                {{ $diffInHours }} {{ \Illuminate\Support\Str::plural('hour', $diffInHours) }}
                            @else
                                {{ $post->created_at->diffInDays(now()) }} {{ \Illuminate\Support\Str::plural('day', $post->created_at->diffInDays(now())) }}
                            @endif
                        </span>
                    </div>

                    <a  class="bg-gray-100 hover:bg-gray-200 hover:border-gray-300 ml-2 rounded border py-1 px-2 flex items-center" href="{{ action(\App\Http\Controllers\Posts\PostCommentsController::class, $post->uuid) }}">
                        @if($post->comments->isNotEmpty())
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400">
                                <path d="M3.505 2.365A41.369 41.369 0 019 2c1.863 0 3.697.124 5.495.365 1.247.167 2.18 1.108 2.435 2.268a4.45 4.45 0 00-.577-.069 43.141 43.141 0 00-4.706 0C9.229 4.696 7.5 6.727 7.5 8.998v2.24c0 1.413.67 2.735 1.76 3.562l-2.98 2.98A.75.75 0 015 17.25v-3.443c-.501-.048-1-.106-1.495-.172C2.033 13.438 1 12.162 1 10.72V5.28c0-1.441 1.033-2.717 2.505-2.914z" />
                                <path d="M14 6c-.762 0-1.52.02-2.271.062C10.157 6.148 9 7.472 9 8.998v2.24c0 1.519 1.147 2.839 2.71 2.935.214.013.428.024.642.034.2.009.385.09.518.224l2.35 2.35a.75.75 0 001.28-.531v-2.07c1.453-.195 2.5-1.463 2.5-2.915V8.998c0-1.526-1.157-2.85-2.729-2.936A41.645 41.645 0 0014 6z" />
                            </svg>

                            <span class="ml-1 text-gray-800">{{ $post->comments->count() }}</span>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400">
                                <path fill-rule="evenodd" d="M2 10c0-3.967 3.69-7 8-7 4.31 0 8 3.033 8 7s-3.69 7-8 7a9.165 9.165 0 01-1.504-.123 5.976 5.976 0 01-3.935 1.107.75.75 0 01-.584-1.143 3.478 3.478 0 00.522-1.756C2.979 13.825 2 12.025 2 10z" clip-rule="evenodd" />
                            </svg>
                        @endif
                    </a>

                    <div class="ml-2 bg-gray-100 rounded py-1 px-2 flex items-center justify-center" style="color:#fff; background-color:hsl(110 ,{{ $post->getRanking()->getSaturation() }}%, 34%)">
                        {!! $post->getRanking() !!}
                    </div>

                    <div class="ml-2">
                        {!! $post->getSparkLine() !!}
                    </div>
                </div>


                <div class="flex gap-2 text-sm pt-2 flex-wrap items-end">
                    <a href="{{ $post->getPublicUrl() }}"
                       class="underline hover:no-underline"
                    >
                        Show
                    </a>

                    @if($showDeny ?? true)
                        @if($post->canDeny())
                            <a href="{{ action(\App\Http\Controllers\Posts\DenyPostController::class, ['post' => $post, ...request()->query->all()]) }}"
                               class="underline hover:no-underline text-red-600 ml-2"
                            >
                                Deny
                            </a>
                        @endif
                    @endif

                    @if($showHide ?? false)
                        <a href="{{ action(\App\Http\Controllers\Posts\HidePostController::class, $post) }}"
                           class="underline hover:no-underline text-yellow-600 ml-2"
                        >
                            Hide
                        </a>
                        <a href="{{ action(\App\Http\Controllers\Posts\PermanentlyHidePostController::class, $post) }}"
                           class="underline hover:no-underline text-yellow-600 ml-2"
                        >
                            Hide forever
                        </a>
                    @endif

                    <span
                        x-data-url="{{ $post->getTweetMessage() }}"
                        x-data-hide-url="true"
                        class="cursor-pointer underline hover:no-underline link-copy ml-2"
                    >
                        Tweet
                    </span>

                    <span
                        x-data-url="{{ $post->getPublicUrl() }}"
                        x-data-hide-url="true"
                        class="cursor-pointer underline hover:no-underline link-copy ml-2"
                    >
                        Copy
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
