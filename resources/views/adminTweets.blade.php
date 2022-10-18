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
            --final-drag-background-color: rgb(243, 162, 162);
            --final-position: -200%;
        }

        .right {
            --drag-background-color: rgb(200, 235, 201);
            --final-drag-background-color: rgb(145, 239, 149);
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
            background-color: var(--final-drag-background-color);
        }

        /* 3 */
        .drag-container.dragged {
            max-height: 0;
            transition: all 0.3s 0s ease-in;
            background-color: var(--final-drag-background-color);
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

        <script>
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            class Drag
            {
                element;
                event;

                constructor(element, event) {
                    this.element = element;
                    this.event = event;
                }

                get deltaX() {
                    // TODO: refactor to x-drag-start-x
                    const startX = this.element.getAttribute('x-drag-start');
                    const currentPosX = this.event.changedTouches[0].pageX;

                    return currentPosX - startX;
                }

                get deltaY() {
                    const startY = this.element.getAttribute('x-drag-start-y');
                    const currentPosY = this.event.changedTouches[0].pageY;

                    return currentPosY - startY;
                }

                get borderReached() {
                    return this.element.classList.contains('border-reached');
                }

                isDraggingVertical() {
                    if (this.element.hasAttribute('x-dragging-horizontal')) {
                        return false;
                    }

                    return Math.abs(this.deltaY) > 10
                        || this.element.hasAttribute('x-dragging-vertical');
                }

                isDraggingHorizontal() {
                    if (this.element.hasAttribute('x-dragging-vertical')) {
                        return false;
                    }

                    return Math.abs(this.deltaX) > 10
                        || this.element.hasAttribute('x-dragging-horizontal');
                }

                markDraggingHorizontal() {
                    this.element.setAttribute('x-dragging-horizontal', 'true');
                }

                markDraggingVertical() {
                    this.element.setAttribute('x-dragging-vertical', 'true');
                }

                isAlreadyDragging() {
                    return this.isDraggingVertical() || this.isDraggingHorizontal();
                }

                determineDragDirection() {
                    if (this.isDraggingHorizontal()) {
                        this.markDraggingHorizontal();

                        return 'horizontal';
                    } else if (this.isDraggingVertical()) {
                        this.markDraggingVertical();

                        return 'vertical';
                    } else {
                        return null;
                    }
                }

                setPosition() {
                    this.element.style.left = `${this.deltaX}px`;
                }

                setDirection() {
                    this.element.classList.remove('left');
                    this.element.classList.remove('right');
                    this.element.classList.add(this.deltaX > 0 ? 'right' : 'left');
                }

                detectBorder() {
                    const border = this.element.offsetWidth / 4;

                    if (Math.abs(this.deltaX) > border) {
                        // Border reached
                        this.element.classList.add('border-reached');
                    } else {
                        // Border not reached
                        this.element.classList.remove('border-reached');
                    }
                }

                reset() {
                    this.element.classList.remove('left');
                    this.element.classList.remove('right');
                    this.element.classList.remove('border-reached');
                    this.element.classList.remove('dragging');
                    this.element.style.left = 0;
                    this.element.removeAttribute('x-dragging-horizontal');
                    this.element.removeAttribute('x-dragging-vertical');
                }

                handleDragStart() {
                    this.element.setAttribute('x-drag-start', this.event.changedTouches[0].pageX);
                    this.element.setAttribute('x-drag-start-y', this.event.changedTouches[0].pageY);
                }

                handleDragMove() {
                    if (this.determineDragDirection() === 'vertical') {
                        return;
                    }

                    if (Math.abs(this.deltaX) < 10) {
                        return;
                    }

                    if (this.event.cancelable) {
                        this.event.preventDefault();
                    }

                    this.event.stopPropagation();

                    this.setDirection();
                    this.setPosition();
                    this.detectBorder();
                }

                handleDragEnd() {
                    this.element.removeAttribute('x-dragging-vertical');

                    if (!this.borderReached) {
                        this.reset();

                        return;
                    }

                    const container = this.element.parentElement;
                    const isLeft = this.element.classList.contains('left');
                    const action = isLeft ? 'deny' : 'save';

                    this.element.classList.add('dragged');
                    this.element.style.left = null;
                    container.classList.add('dragged');
                    container.classList.add(isLeft ? 'left' : 'right');

                    fetch(this.element.getAttribute(`x-${action}-url`), {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                        }
                    });

                    const tweetCountElement = document.querySelector('#tweet-count');
                    const tweetCount = parseInt(tweetCountElement.innerHTML);

                    tweetCountElement.innerHTML = tweetCount - 1;
                }
            }

            const init = function (element) {
                element.addEventListener('touchstart', (event) => {
                    const drag = new Drag(element, event);

                    drag.handleDragStart();
                });

                element.addEventListener('touchmove', (event) => {
                    const drag = new Drag(element, event);

                    drag.handleDragMove();
                });

                element.addEventListener('touchend', (event) => {
                    const drag = new Drag(element, event);

                    drag.handleDragEnd();
                });
            };

            document.querySelectorAll('.drag').forEach((element) => init(element));
        </script>
@endcomponent
