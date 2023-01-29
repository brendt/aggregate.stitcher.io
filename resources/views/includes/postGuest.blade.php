
@php
    $hoverColor = match(true) {
        $post->isStarred() => 'yellow-300',
        $post->isTweet() => 'blue-100',
        default => 'pink-100',
    };
@endphp

<div class="">
    <a
        href="{{ $post->getPublicUrl() }}"
        class="
                        block lg:px-12 p-4
                        hover:bg-pink-200
                        {{ $post->isPending() ? 'bg-gray-200' : '' }}
                        {{ $post->isStarred() ? 'bg-yellow-100' : '' }}
                        {{ $post->isDenied() ? 'bg-red-100' : '' }}
                        ">

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
            </div>
        </div>
    </a>
</div>
