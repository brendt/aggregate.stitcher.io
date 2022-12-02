<?php
/** @var \Illuminate\Support\Collection|\App\Models\Post[] $posts */
?>

@component('layout.app')
    <div class="mx-auto container grid gap-4 mt-4">
        @if($user)
            @include('includes.adminMenu')
        @endif

        <div class="bg-white mx-4 shadow-md grid">
            @if($message)
                <div class="px-12 py-4 bg-green-100 font-bold block text-center">
                    {{ $message }}
                </div>
            @endif

            <a
                class="hover:bg-pink-200 px-12 py-4 font-bold block text-center add-link"
                href="{{ action(\App\Http\Controllers\Sources\SuggestSourceController::class) }}"
                title="Add your own"
            >
                <span class="add-sign">+</span>
                <span class="add-label">Make a suggestion…</span>
            </a>

            <div class="">
                @foreach ($posts as $post)
                    @php
                    $hoverColor = match(true) {
                        $post->isStarred() => 'yellow-300',
                        $post->isTweet() => 'blue-100',
                        default => 'pink-100',
                    };
                    @endphp

                    <div class="overflow-x-hidden">
                        <a
                            href="{{ $post->getPublicUrl() }}"
                            class="
                        block px-12 p-4
                        {{ $post->isPending() ? 'bg-gray-200' : '' }}
                        {{ $post->isStarred() ? 'bg-yellow-100' : '' }}
                        {{ "hover:bg-{$hoverColor}" }}
                        {{ $post->isDenied() ? 'bg-red-100' : '' }}
                        ">

                            <div class="flex items-end">
                                <div>
                                    <h1 class="font-bold break-words">
                                        {{ $post->getParsedTitle() }}
                                    </h1>

                                    @if($post->body)
                                        {{ $post->body }}
                                    @endif

                                    <div class="text-sm font-light text-gray-800">
                                        {{ $post->getSourceName() }},
                                        @php
                                            $diffInHours = $post->created_at->diffInHours(now())
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

                                @auth
                                    <div class="ml-8">
                                        {!! $post->getVisitsGraph() !!}
                                    </div>
                                @endauth
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            @if($posts->hasMorePages())
                <a class="px-12 py-4 font-bold block text-center hover:bg-pink-200" href="{{ $posts->nextPageUrl() }}"
                   title="Add your own">
                    more
                </a>
            @endif
        </div>
@endcomponent
