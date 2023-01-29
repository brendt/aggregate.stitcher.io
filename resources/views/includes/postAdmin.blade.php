@php
    $hoverColor = match(true) {
        $post->isStarred() => 'yellow-300',
        $post->isTweet() => 'blue-100',
        default => 'pink-100',
    };
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
                </h1>

                @if($post->body)
                    {{ $post->body }}
                @endif

                <div class="text-sm font-light text-gray-800">
                    {{ $post->getSourceName() }},

                    <span class="md:hidden">
                        <br>
                    </span>

                    @php
                        $diffInHours = ($post->published_at ?? $post->created_at)->diffInHours(now())
                    @endphp

                    @if($post->isTweet())
                        tweeted
                    @else
                        published
                    @endif

                    @if($diffInHours <= 1)
                        right now,
                    @elseif($diffInHours <= 24)
                        {{ $diffInHours }} {{ \Illuminate\Support\Str::plural('hour', $diffInHours) }} ago,
                    @else
                        {{ $post->created_at->diffInDays(now()) }} {{ \Illuminate\Support\Str::plural('day', $post->created_at->diffInDays(now())) }}
                        ago,
                    @endif

                    {{ $post->visits }} {{ \Illuminate\Support\Str::plural('visit', $post->visits) }}
                </div>

                <div class="flex gap-2 text-sm pt-2 flex-wrap items-end">
                    <a href="{{ $post->getPublicUrl() }}"
                       class="underline hover:no-underline"
                    >
                        Show
                    </a>

                    @if($post->canDeny())
                        <a href="{{ action(\App\Http\Controllers\Posts\DenyPostController::class, ['post' => $post, ...request()->query->all()]) }}"
                           class="underline hover:no-underline text-red-600 ml-2"
                        >
                            Deny
                        </a>
                    @endif

                    @if($post->tweet_id)
                        <a
                            class="underline hover:no-underline text-blue-400 ml-2"
                            href="https://twitter.com/brendt_gd/status/{{ $post->tweet_id }}"
                        >
                            Show tweet
                        </a>
                    @else
                        <a
                            class="underline hover:no-underline text-blue-400 ml-2"
                            href="{{ action(\App\Http\Controllers\Tweets\TweetPostController::class, $post) }}"
                        >
                            Tweet
                        </a>
                    @endif

                    <div class="mt-2 ml-0 lg:ml-8 lg:mt-0 ">
                        {!! $post->getSparkLine() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
