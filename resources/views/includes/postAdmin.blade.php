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
                    @include('includes.postButtons')

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
