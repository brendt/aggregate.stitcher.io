<?php
/** @var \Illuminate\Support\Collection|\App\Models\Tweet[] $tweets */
?>

@component('layout.app')
    @include('includes.drag')
    
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
                href="{{ action(\App\Http\Controllers\Tweets\CreateMuteController::class) }}"
                title="Add mute"
            >
                Add mute
            </a>

            <div class="">
                @foreach ($tweets as $tweet)
                    <div class="drag-container">
                        <div
                            class="drag bg-gray-200"
                            x-deny-url="{{ action(\App\Http\Controllers\Tweets\DenyTweetController::class, $tweet->id) }}"
                            x-save-url="{{ action(\App\Http\Controllers\Tweets\SaveTweetController::class, $tweet->id) }}"
                        >
                            <div
                                class="block px-12 p-4 word-break"
                            >
                                <div class="flex align-baseline">
                                    <h1 class="font-bold">
                                        &#64;{{ $tweet->user_name }}
                                    </h1>
                                    @if($tweet->isRetweet())
                                        <span class="ml-2 px-2 bg-purple-100 rounded">
                                            retweet
                                        </span>
                                    @else
                                        <span class="ml-2 px-2 bg-{{ $tweet->feed_type->getColour() }}-100 rounded">
                                            {{ $tweet->feed_type->value }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-2 tweet-text">
                                    {!! nl2br($tweet->parsed_text)  !!}
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

                                    @if($tweet->retweeted_by_user_name)
                                        , retweeted by {{ $tweet->retweeted_by_user_name }}
                                    @endif
                                </div>

                                <div class="flex gap-2 text-sm pt-2">
                                    <a href="{{ $tweet->getPublicUrl() }}"
                                       class="underline hover:no-underline mr-4 py-2"
                                    >
                                        Show
                                    </a>

                                    @if($tweet->canPublish())
                                        <a href="{{ action(\App\Http\Controllers\Tweets\SaveTweetController::class, ['tweet' => $tweet, ...request()->query->all()]) }}"
                                           class="underline hover:no-underline text-green-600 mr-4 py-2"
                                        >
                                            Save
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
                    </div>
                @endforeach
            </div>

            <div class="grid grid-cols-2">
                <a class="px-12 py-4 font-bold block text-center hover:bg-red-300"
                   href="{{ action(\App\Http\Controllers\Tweets\RejectedTweetController::class) }}"
                >
                    Show rejected
                </a>
                <a class="px-12 py-4 font-bold block text-center hover:bg-blue-300"
                   href="{{ action(\App\Http\Controllers\Tweets\SavedTweetController::class) }}"
                >
                    Show saved
                </a>
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
