<?php
/** @var \Illuminate\Support\Collection|\App\Models\Post[] $posts */
?>

@component('layout.app')
    <div class="mx-auto container grid gap-4 mt-2 md:mt-4">
        <div class="bg-white mx-1 md:mx-4 shadow-md grid ">
            <div class="flex items-center">
                <a href="/" class="px-1 md:px-2 hover:bg-pink-200 self-stretch flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M15.79 14.77a.75.75 0 01-1.06.02l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 111.04 1.08L11.832 10l3.938 3.71a.75.75 0 01.02 1.06zm-6 0a.75.75 0 01-1.06.02l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 111.04 1.08L5.832 10l3.938 3.71a.75.75 0 01.02 1.06z" clip-rule="evenodd"/>
                    </svg>
                </a>

                <div class="m-2 md:m-4">
                    <h1 class="font-bold text-xl">
                        {{ $post->getParsedTitle() }} — {{ $post->getShortSourceName() }}
                    </h1>

                    <div class="flex text-xs mt-1">
                        <a class="bg-gray-100 hover:bg-gray-200 hover:border-gray-300 rounded border py-1 px-2 flex items-center" href="{{ $post->getPublicUrl() }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-500">
                                <path fill-rule="evenodd" d="M4.25 5.5a.75.75 0 00-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 00.75-.75v-4a.75.75 0 011.5 0v4A2.25 2.25 0 0112.75 17h-8.5A2.25 2.25 0 012 14.75v-8.5A2.25 2.25 0 014.25 4h5a.75.75 0 010 1.5h-5z" clip-rule="evenodd"/>
                                <path fill-rule="evenodd" d="M6.194 12.753a.75.75 0 001.06.053L16.5 4.44v2.81a.75.75 0 001.5 0v-4.5a.75.75 0 00-.75-.75h-4.5a.75.75 0 000 1.5h2.553l-9.056 8.194a.75.75 0 00-.053 1.06z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-1 text-gray-800">
                            {{ $post->visits }}
                        </span>
                        </a>

                        <div class="bg-gray-100 ml-2 rounded border py-1 px-2 flex items-center cursor-default">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd"/>
                            </svg>

                            @php
                                $diffInHours = ($post->published_at ?? $post->created_at)->diffInHours(now())
                            @endphp

                            <span class="ml-1 text-gray-800">
                            @if($diffInHours <= 1)
                                    right now
                                @elseif($diffInHours <= 24)
                                    {{ $diffInHours }} {{ \Illuminate\Support\Str::plural('hour', $diffInHours) }}
                                @else
                                    {{ $post->created_at->diffInDays(now()) }} {{ \Illuminate\Support\Str::plural('day', $post->created_at->diffInDays(now())) }}
                                @endif
                        </span>
                        </div>

                        <a class="bg-gray-100 hover:bg-gray-200 hover:border-gray-300 ml-2 rounded border py-1 px-2 flex items-center" href="{{ action(\App\Http\Controllers\Posts\PostCommentsController::class, $post->uuid) }}">
                            @if($post->comments->isNotEmpty())
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400">
                                    <path d="M3.505 2.365A41.369 41.369 0 019 2c1.863 0 3.697.124 5.495.365 1.247.167 2.18 1.108 2.435 2.268a4.45 4.45 0 00-.577-.069 43.141 43.141 0 00-4.706 0C9.229 4.696 7.5 6.727 7.5 8.998v2.24c0 1.413.67 2.735 1.76 3.562l-2.98 2.98A.75.75 0 015 17.25v-3.443c-.501-.048-1-.106-1.495-.172C2.033 13.438 1 12.162 1 10.72V5.28c0-1.441 1.033-2.717 2.505-2.914z"/>
                                    <path d="M14 6c-.762 0-1.52.02-2.271.062C10.157 6.148 9 7.472 9 8.998v2.24c0 1.519 1.147 2.839 2.71 2.935.214.013.428.024.642.034.2.009.385.09.518.224l2.35 2.35a.75.75 0 001.28-.531v-2.07c1.453-.195 2.5-1.463 2.5-2.915V8.998c0-1.526-1.157-2.85-2.729-2.936A41.645 41.645 0 0014 6z"/>
                                </svg>

                                <span class="ml-1 text-gray-800">{{ $post->comments->count() }}</span>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400">
                                    <path fill-rule="evenodd" d="M2 10c0-3.967 3.69-7 8-7 4.31 0 8 3.033 8 7s-3.69 7-8 7a9.165 9.165 0 01-1.504-.123 5.976 5.976 0 01-3.935 1.107.75.75 0 01-.584-1.143 3.478 3.478 0 00.522-1.756C2.979 13.825 2 12.025 2 10z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                        </a>
                    </div>
                </div>
            </div>

            <div class="mb-2 bg-gray-100 p-2 md:px-12 md:py-4">
                @if($user)
                    <form action="{{ action(\App\Http\Controllers\Posts\StorePostCommentController::class, $post->uuid) }}" method="POST" class="">
                        @csrf

                        <label for="comment">Leave your comment:</label>

                        <div class="grid my-2">
                            <textarea name="comment" id="comment" rows="4" class="w-full border-gray-300 bg-white rounded border py-1 px-2">{{ old('comment') }}</textarea>

                            @error('comment')
                            <span class="text-red-600">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="text-gray-800 bg-gray-200 hover:bg-gray-100 hover:border-gray-400 rounded border py-1 px-2">Submit</button>
                        </div>
                    </form>
                @else
                    <p class="ml-2 md:ml-4">
                        Only registered users can comment.
                        If you already have an account, you can
                        <a href="{{ route('login', ['to' => action(\App\Http\Controllers\Posts\PostCommentsController::class, $post->uuid)]) }}" class="underline hover:no-underline">log in here</a>. If you don't have an account, please read the
                        <a href="{{ action(\App\Http\Controllers\Users\AboutInvitesController::class) }}" class="underline hover:no-underline">about invitations page</a>.
                    </p>
                @endif
            </div>

            <div class="px-2 md:px-4 mb-2">
                @foreach ($post->comments as $comment)
                    <div class="
                        my-1
                        md:my-4
                        bg-gray-100
                        rounded
                        p-2
                        md:p-4
                        @if($user ?? null)
                            {{ $user->hasSeenComment($comment, $lastSeenAt) ? '' : 'is-new-comment' }}
                        @endif
                    ">
                        <div class="font-bold">
                            {{ $comment->user->name }}
                            <span class="font-light text-sm ml-1">
                                {{ $comment->created_at->format('Y-m-d H:i:s') }}
                            </span>
                        </div>
                        <div class="mt-1 md:mt-2">
                            {!! $comment->getEscapedComment() !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endcomponent
