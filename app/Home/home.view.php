<?php

use function Tempest\Router\uri;
use App\Posts\PostsController;
use App\Home\HomeController;
use App\Admin\AdminController;
use Tempest\DateTime\DateTime;
use App\Authentication\AuthController;

?>

<x-base>
    <x-slot name="head">
        <script :if="$user?->isAdmin" src="https://cdn.jsdelivr.net/npm/htmx.org@2.0.6/dist/htmx.min.js" integrity="sha384-Akqfrbj/HpNVo8k11SXBb6TlBWmXXlYQrCSqEWmyKJe+hDm3Z/B2WVG4smwBkRVm" crossorigin="anonymous"></script>
    </x-slot>

    <div class="max-w-[800px] m-auto grid gap-2">
        <div class="grid gap-2 mb-8 mt-4">
            <x-pending-posts :if="$user?->isAdmin" :pendingPosts="$pendingPosts" />
        </div>

        <a
                :foreach="$posts as $post"
                class="p-4 rounded-lg shadow-sm {{ $color($post) }} hover:shadow-lg hover:underline"
                :href="uri([PostsController::class, 'visit'], post: $post->id)"
        >
            <h1>
                <span class="font-bold">{{ $post->title }}</span>&nbsp;<span class="text-sm">–&nbsp;{{ $post->source->name }}</span>
            </h1>
        </a>

        <div class="flex gap-2">
            <a
                    :if="$page->hasNext"
                    :href="uri(HomeController::class, page: $page->nextPage)"
                    class="flex-auto mt-8 text-center bg-white font-bold hover:underline p-3 rounded-lg shadow-sm"
            >Read more</a>
            <a
                    :if="$user?->isAdmin"
                    :href="uri([AdminController::class, 'admin'])"
                    class="flex-auto mt-8 text-center bg-white font-bold hover:underline p-3 rounded-lg shadow-sm"
            >Admin</a>
        </div>

        <div class="flex justify-center text-sm mt-8 gap-1 text-gray-500">
            <a class="underline hover:no-underline" :if="$user === null" href="{{ uri([AuthController::class, 'login']) }}">Login</a>
            <a class="underline hover:no-underline" :else href="{{ uri([AuthController::class, 'logout']) }}">Logout</a>
            <span>–</span>
            <span>&copy;{{ DateTime::now()->format('YYYY') }} stitcher.io</span>
        </div>
    </div>
</x-base>
