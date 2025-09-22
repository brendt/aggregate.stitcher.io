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
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                let copyUris = document.querySelectorAll('.copy-uri');

                copyUris.forEach(element => {
                    element.addEventListener('click', () => {
                        if (navigator.clipboard) {
                            navigator.clipboard.writeText(element.getAttribute('data-uri'));
                        }

                        copyUris.forEach(elementToClear => {
                            elementToClear.classList.remove('copied');
                        })

                        element.classList.add('copied');
                    });
                })
            });
        </script>
    </x-slot>

    <div class="max-w-[800px] m-auto grid gap-2">
        <div class="flex justify-center items-center gap-2 mb-4 mt-4">
            <span class="font-bold text-slate-600">My community-driven feed, follow via <a href="/rss" class="underline hover:no-underline">RSS</a></span>
        </div>

        <div class="grid gap-2 mb-8 mt-4" :if="$user?->isAdmin">
            <x-pending-posts :pendingPosts="$pendingPosts" :shouldQueue="$shouldQueue" :futureQueued="$futureQueued"/>
        </div>

        <div
                :foreach="$posts as $post"
                class="rounded-lg bg-white shadow-sm hover:shadow-lg flex items-center justify-between"
        >
            <div class="pl-4">
                <span class="text-md sm:text-xs p-1 px-2 rounded-sm {{ $color($post) }}">{{ $post->visits }}</span>
            </div>

            <a :href="uri([PostsController::class, 'visit'], post: $post->id)" class="hover:underline grow p-4">
                <span class="font-bold">{{ $post->title }}</span>
                <br class="inline sm:hidden">
                <span class="hidden sm:inline">&nbsp;</span>
                <span class="text-sm block overflow-hidden">{{ $post->source->shortName }}</span>
            </a>

            <div class="flex p-4 cursor-pointer group copy-uri" :data-uri="uri([PostsController::class, 'visit'], post: $post->id)">
                <x-icon
                        name="lucide:link"
                        class="icon-copy size-7 sm:size-6 p-1 bg-gray-100 rounded-sm group-hover:bg-gray-200"
                />
                <x-icon
                        name="lucide:check"
                        class="icon-copied size-7 sm:size-6 p-1 bg-emerald-600 text-emerald-50 rounded-sm"
                />
            </div>
        </div>

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
            <a href="/rss" class="underline hover:no-underline">RSS</a>
            <span>–</span>
            <span>&copy;{{ DateTime::now()->format('YYYY') }} stitcher.io</span>
        </div>
    </div>
</x-base>
