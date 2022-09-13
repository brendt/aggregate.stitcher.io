<?php
/** @var \Illuminate\Support\Collection|\App\Models\Tweet[] $tweets */
?>

@component('layout.app')
    <style>
        :root {
            --drag-background-color: #fff;
        }

        .left {
            --drag-background-color: rgb(237, 204, 204);
            --final-position: -200%;
        }

        .right {
            --drag-background-color: rgb(200, 235, 201);
            --final-position: 200%;
        }

        .drag-container {
            position: relative;
            height: auto;
            max-height: 1000px;
            overflow-x: hidden;
        }

        /* 0 reset */
        .drag {
            background-color: var(--drag-background-color);
            width: 100%;
            position: relative;
            height: auto;
            left: 0;
            top: 0;
        }

        /* 1 */
        .dragging {
            background-color: var(--drag-background-color);
        }

        /* 2 */
        .border-reached {
            background-color: var(--drag-background-color);
            filter: brightness(80%);
        }

        /* 3 */
        .drag-container.dragged {
            max-height: 0;
            transition: all 0.4s 0s ease-in;
            background-color: var(--drag-background-color);
        }

        .drag-container.dragged .drag {
            left: var(--final-position);
            transition: all 0.4s 0s ease-in;
        }
    </style>

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
                                class="block px-12 p-4 break-all"
                            >
                                <h1 class="font-bold">
                                    &#64;{{ $tweet->user_name }}
                                </h1>

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

        <script>
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const init = function (container, drag) {
                drag.addEventListener('touchstart', (e) => {
                    drag.setAttribute('x-drag-start', e.changedTouches[0].pageX);
                });

                drag.addEventListener('touchend', (e) => {
                    if (! drag.classList.contains('border-reached')) {
                        reset(drag);

                        return;
                    }

                    setDragged(drag, container);

                    const action = drag.classList.contains('left') ? 'deny' : 'save';

                    fetch(drag.getAttribute(`x-${action}-url`), {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                        }
                    });
                });

                drag.addEventListener('touchmove', (e) => {
                    const start = drag.getAttribute('x-drag-start');
                    const currentPos = e.changedTouches[0].pageX;
                    const delta = (currentPos - start) / 2;

                    if (Math.abs(delta) < 20) {
                        return;
                    }

                    e.preventDefault();
                    e.stopPropagation();

                    setDirection(drag, delta);
                    setPosition(drag, delta);
                    detectBorder(drag, delta);
                });
            };

            function setPosition(drag, delta) {
                drag.style.left = `${delta}px`;
            }

            function setDirection(drag, delta) {
                drag.classList.remove('left');
                drag.classList.remove('right');

                drag.classList.add(delta > 0 ? 'right' : 'left');
            }

            function detectBorder(drag, delta) {
                const border = drag.offsetWidth / 4;

                if (Math.abs(delta) > border) {
                    // Border reached
                    drag.classList.add('border-reached');
                } else {
                    // Border not reached
                    drag.classList.remove('border-reached');
                }
            }

            function reset(drag) {
                drag.classList.remove('left');
                drag.classList.remove('right');
                drag.classList.remove('border-reached');
                drag.classList.remove('dragging');
                drag.style.left = 0;
            }

            function setDragged(drag, container) {
                drag.classList.add('dragged');
                container.classList.add('dragged');
                container.classList.add(drag.classList.contains('left') ? 'left' : 'right');
                drag.style.left = null;
            }

            document.querySelectorAll('.drag-container').forEach(
                (container) => init(container, container.querySelector('.drag'))
            );
        </script>
@endcomponent
