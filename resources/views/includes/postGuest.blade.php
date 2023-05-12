
@php
    $hoverColor = match(true) {
        $post->isStarred() => 'yellow-300',
        $post->isTweet() => 'blue-100',
        default => 'pink-100',
    };
@endphp

<div class="">
    <div
        class="
                        block lg:px-12 p-4
                        hover:bg-pink-200
                        {{ $post->isPending() ? 'bg-gray-200' : '' }}
                        {{ $post->isStarred() ? 'bg-yellow-100' : '' }}
                        {{ $post->isDenied() ? 'bg-red-100' : '' }}
                        ">

        <div class="md:flex items-end">
            <div class="break-words">
                <a href="{{ $post->getPublicUrl() }}">
                    <h1 class="font-bold break-words hover:underline">
                        {{ $post->getParsedTitle() }}
                        <span class="text-sm font-light">
                        — {{ $post->getShortSourceName() }}
                    </span>
                    </h1>
                </a>

                <div class="flex text-xs mt-1">
                    @include('includes.postButtons')
                </div>
            </div>
        </div>
    </div>
</div>
