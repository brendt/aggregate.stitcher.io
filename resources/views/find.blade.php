<?php
/** @var \Illuminate\Support\Collection|\App\Models\Post[] $posts */
?>

@component('layout.app')
    <div class="mx-auto container grid gap-4 mt-4">
        @if($user)
            @include('includes.adminMenu')
        @endif

        <livewire:share-timeline></livewire:share-timeline>

        <div class="bg-white mx-4 shadow-md p-2 px-4 flex flex-wrap gap-2 items-center">
            <span>Find for:</span>
            <x-tag
                color="blue"
                class="text-sm {{ $filter === \App\Services\PostSharing\SharingChannel::TWITTER ? 'font-bold' : '' }}"
                :url="action(\App\Http\Controllers\Posts\FindPostController::class, ['filter' => \App\Services\PostSharing\SharingChannel::TWITTER->value])">
                Twitter
            </x-tag>
            <x-tag
                color="orange"
                class="text-sm {{ $filter === \App\Services\PostSharing\SharingChannel::HACKERNEWS ? 'font-bold' : '' }}"
                :url="action(\App\Http\Controllers\Posts\FindPostController::class, ['filter' => \App\Services\PostSharing\SharingChannel::HACKERNEWS->value])">
                HackerNews
            </x-tag>
            <x-tag
                color="purple"
                class="text-sm {{ $filter === \App\Services\PostSharing\SharingChannel::R_PHP ? 'font-bold' : '' }}"
                :url="action(\App\Http\Controllers\Posts\FindPostController::class, ['filter' => \App\Services\PostSharing\SharingChannel::R_PHP->value])">
                /r/php
            </x-tag>
            <x-tag
                color="green"
                class="text-sm {{ $filter === \App\Services\PostSharing\SharingChannel::R_WEBDEV ? 'font-bold' : '' }}"
                :url="action(\App\Http\Controllers\Posts\FindPostController::class, ['filter' => \App\Services\PostSharing\SharingChannel::R_WEBDEV->value])">
                /r/webdev
            </x-tag>
            <x-tag
                color="red"
                class="text-sm {{ $filter === \App\Services\PostSharing\SharingChannel::R_PROGRAMMING ? 'font-bold' : '' }}"
                :url="action(\App\Http\Controllers\Posts\FindPostController::class, ['filter' => \App\Services\PostSharing\SharingChannel::R_PROGRAMMING->value])">
                /r/programming
            </x-tag>
            <x-tag
                color="red"
                class="text-sm {{ $filter === \App\Services\PostSharing\SharingChannel::LOBSTERS ? 'font-bold' : '' }}"
                :url="action(\App\Http\Controllers\Posts\FindPostController::class, ['filter' => \App\Services\PostSharing\SharingChannel::LOBSTERS->value])">
                Lobste.rs
            </x-tag>
        </div>

        <div class="bg-white mx-4 shadow-md grid">
            @if($message)
                <div class="px-12 py-4 bg-green-100 font-bold block text-center">
                    {{ $message }}
                </div>
            @endif

            <div class="">
                @foreach ($posts as $post)
                    @component('includes.postAdmin', ['post' => $post, 'user' => $user, 'showDeny' => false, 'channelFilter' => $filter])
                        @if($filter)
                            <x-slot name="buttons">
                                <x-tag
                                    :url="action(\App\Http\Controllers\Posts\SnoozeShareController::class, ['post' => $post, 'channel' => $filter->value])"
                                    color="blue"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-500">
                                        <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 00-1.06 1.06l14.5 14.5a.75.75 0 101.06-1.06l-1.745-1.745a10.029 10.029 0 003.3-4.38 1.651 1.651 0 000-1.185A10.004 10.004 0 009.999 3a9.956 9.956 0 00-4.744 1.194L3.28 2.22zM7.752 6.69l1.092 1.092a2.5 2.5 0 013.374 3.373l1.091 1.092a4 4 0 00-5.557-5.557z" clip-rule="evenodd"/>
                                        <path d="M10.748 13.93l2.523 2.523a9.987 9.987 0 01-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 010-1.186A10.007 10.007 0 012.839 6.02L6.07 9.252a4 4 0 004.678 4.678z"/>
                                    </svg>

                                    <span class="ml-1 text-gray-800">
                                        Snooze
                                    </span>
                                </x-tag>
                                <x-tag
                                    :url="action(\App\Http\Controllers\Posts\SnoozeShareController::class, ['post' => $post, 'channel' => $filter->value, 'permanent' => true])"
                                    color="red"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-500">
                                        <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 00-1.06 1.06l14.5 14.5a.75.75 0 101.06-1.06l-1.745-1.745a10.029 10.029 0 003.3-4.38 1.651 1.651 0 000-1.185A10.004 10.004 0 009.999 3a9.956 9.956 0 00-4.744 1.194L3.28 2.22zM7.752 6.69l1.092 1.092a2.5 2.5 0 013.374 3.373l1.091 1.092a4 4 0 00-5.557-5.557z" clip-rule="evenodd"/>
                                        <path d="M10.748 13.93l2.523 2.523a9.987 9.987 0 01-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 010-1.186A10.007 10.007 0 012.839 6.02L6.07 9.252a4 4 0 004.678 4.678z"/>
                                    </svg>

                                    <span class="ml-1 text-gray-800">
                                        Hide forever
                                    </span>
                                </x-tag>
                            </x-slot>
                        @endif
                    @endcomponent
                @endforeach
            </div>

{{--            @if($posts->hasMorePages())--}}
{{--                <a class="px-12 py-4 font-bold block text-center hover:bg-pink-200" href="{{ $posts->nextPageUrl() }}"--}}
{{--                   title="Add your own">--}}
{{--                    more--}}
{{--                </a>--}}
{{--            @endif--}}
        </div>

    @auth()
        @include('includes.copyLink')
    @endauth
@endcomponent
