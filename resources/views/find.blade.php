<?php
/** @var \Illuminate\Support\Collection|\App\Models\Post[] $posts */
?>

@component('layout.app')
    <div class="mx-auto container grid gap-4 mt-4">
        @if($user)
            @include('includes.adminMenu')
        @endif

        <livewire:share-timeline></livewire:share-timeline>

        <div class="bg-white mx-4 shadow-md p-2 px-4 flex gap-2 items-center">
            <span>Find for:</span>
            <x-tag color="blue" class="text-sm" :url="action(\App\Http\Controllers\Posts\FindPostController::class, ['filter' => \App\Services\PostSharing\SharingChannel::TWITTER->value])">
                Twitter
            </x-tag>
            <x-tag color="orange" class="text-sm" :url="action(\App\Http\Controllers\Posts\FindPostController::class, ['filter' => \App\Services\PostSharing\SharingChannel::HACKERNEWS->value])">
                HackerNews
            </x-tag>
            <x-tag color="purple" class="text-sm" :url="action(\App\Http\Controllers\Posts\FindPostController::class, ['filter' => \App\Services\PostSharing\SharingChannel::R_PHP->value])">
                /r/php
            </x-tag>
            <x-tag color="red" class="text-sm" :url="action(\App\Http\Controllers\Posts\FindPostController::class, ['filter' => \App\Services\PostSharing\SharingChannel::R_WEBDEV->value])">
                /r/webdev
            </x-tag>
            <x-tag color="red" class="text-sm" :url="action(\App\Http\Controllers\Posts\FindPostController::class, ['filter' => \App\Services\PostSharing\SharingChannel::R_PROGRAMMING->value])">
                /r/programming
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
                    @include('includes.postAdmin', [
                        'showDeny' => false,
                        'showHide' => true,
                    ])
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
