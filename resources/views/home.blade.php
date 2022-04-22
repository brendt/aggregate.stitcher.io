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
                class="hover:bg-pink-200 px-12 py-4 font-bold block text-center"
                href="{{ action(\App\Http\Controllers\Sources\SuggestSourceController::class) }}"
                title="Add your own"
            >
                +
            </a>

            <div class="">
                @foreach ($posts as $post)
                    <div class="overflow-x-hidden">
                        <a
                            href="{{ $post->getPublicUrl() }}"
                            class="
                        block px-12 p-4
                        {{ $post->isPending() ? 'bg-gray-200' : '' }}
                        {{ $post->isStarred() ? 'bg-yellow-100' : '' }}
                        {{ $post->isStarred() ? 'hover:bg-yellow-300' : 'hover:bg-pink-100' }}
                        {{ $post->isDenied() ? 'bg-red-100' : '' }}
                        "
                        >
                            <h1 class="font-bold break-all">
                                {{ $post->title }}
                            </h1>

                            <div class="text-sm font-light text-gray-800">
                                {{ $post->getSourceName() }},
                                @php
                                    $diffInHours = $post->created_at->diffInHours(now())
                                @endphp

                                published

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
