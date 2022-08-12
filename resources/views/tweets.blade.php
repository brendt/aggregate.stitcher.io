<?php
/** @var \Illuminate\Support\Collection|\App\Models\Tweet[] $tweets */
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

{{--            <a--}}
{{--                class="hover:bg-pink-200 px-12 py-4 font-bold block text-center add-link"--}}
{{--                href="{{ action(\App\Http\Controllers\Sources\SuggestSourceController::class) }}"--}}
{{--                title="Add your own"--}}
{{--            >--}}
{{--                <span class="add-sign">+</span>--}}
{{--                <span class="add-label">Suggest a twitter account</span>--}}
{{--            </a>--}}

            <div class="">
                @foreach ($tweets as $tweet)
                    <div class="overflow-x-hidden">
                        <a
                            href="{{ $tweet->getPublicUrl() }}"
                            class="
                        block px-12 p-4
{{--                        {{ $post->isPending() ? 'bg-gray-200' : '' }}--}}
                        hover:bg-blue-100
{{--                        {{ $post->isDenied() ? 'bg-red-100' : '' }}--}}
                        "
                        >
                            <h1 class="font-bold">
                                &#64;{{ $tweet->user_name }}
                            </h1>

                            <div class="mt-2">
                                {!! nl2br($tweet->text)  !!}
                            </div>

                            <div class="text-sm font-light text-gray-800 mt-2">
                                @php
                                    $diffInHours = $tweet->created_at->diffInHours(now())
                                @endphp

                                Tweeted

                                @if($diffInHours <= 1)
                                    right now
                                @elseif($diffInHours <= 24)
                                    {{ $diffInHours }} {{ \Illuminate\Support\Str::plural('hour', $diffInHours) }} ago
                                @else
                                    {{ $tweet->created_at->diffInDays(now()) }} {{ \Illuminate\Support\Str::plural('day', $tweet->created_at->diffInDays(now())) }}
                                    ago
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            @if($tweets->hasMorePages())
                <a class="px-12 py-4 font-bold block text-center hover:bg-pink-200" href="{{ $tweets->nextPageUrl() }}"
                   title="Add your own">
                    more
                </a>
            @endif
        </div>
@endcomponent
