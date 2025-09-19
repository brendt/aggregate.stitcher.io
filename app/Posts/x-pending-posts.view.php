<?php
use App\Posts\PostsController;
use function Tempest\Router\uri;
?>

<div id="pending-posts" class="grid gap-2">
    <div
            :foreach="$pendingPosts as $pendingPost"
            class="p-2 pl-4 rounded-lg shadow-sm bg-gray-200 flex items-center justify-between"
    >
        <h1 class="text-gray-500">
            <span class="font-bold">{{ $pendingPost->title }}</span>&nbsp;<span class="text-sm">–&nbsp;{{ $pendingPost->source->name }}</span>
        </h1>

        <div class="flex gap-2">
            <a class="bg-gray-100 p-2 rounded-md htmx-button flex items-center" :href="$pendingPost->uri">
                <x-icon name="lucide:external-link" class="size-5 text-gray-400"/>
            </a>

            <x-action-button :action="uri([PostsController::class, 'deny'], post: $pendingPost->id)" target="#pending-posts">
                <x-icon name="lucide:trash-2" class="size-5 text-gray-400"/>
            </x-action-button>

            <x-action-button :if="!$shouldQueue" :action="uri([PostsController::class, 'publish'], post: $pendingPost->id)" target="#pending-posts">
                <x-icon name="lucide:check" class="size-5 text-gray-400"/>
            </x-action-button>

            <x-action-button :if="$shouldQueue" :action="uri([PostsController::class, 'queue'], post: $pendingPost->id)" target="#pending-posts">
                <x-icon name="lucide:alarm-clock-check" class="size-5 text-gray-400"/>
            </x-action-button>
        </div>
    </div>
</div>
