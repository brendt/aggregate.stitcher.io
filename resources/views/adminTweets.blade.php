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

            <div class="">
                @foreach ($tweets as $tweet)
                    <div class="overflow-x-hidden">
                        <div
                            class="block px-12 p-4 bg-gray-200 "
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

                            <div class="flex gap-2 text-sm pt-2">
                                <a href="{{ $tweet->getPublicUrl() }}"
                                   class="underline hover:no-underline mr-4 py-2"
                                >
                                    Show
                                </a>

                                @if($tweet->canPublish())
                                    <a href="{{ action(\App\Http\Controllers\Tweets\PublishTweetController::class, ['tweet' => $tweet, ...request()->query->all()]) }}"
                                       class="underline hover:no-underline text-green-600 mr-4 py-2"
                                    >
                                        Publish
                                    </a>
                                @endif

                                @if($tweet->canDeny())
                                    <a href="{{ action(\App\Http\Controllers\Tweets\DenyTweetController::class, ['tweet' => $tweet, ...request()->query->all()]) }}"
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

            @if($tweets->count())
                <a class="px-12 py-4 font-bold block text-center bg-red-100 hover:bg-red-300"
                   href="{{ action(\App\Http\Controllers\Tweets\DenyPendingTweetsController::class) }}"
                >
                    Mark all pending as denied
                </a>
            @endif
        </div>
@endcomponent
