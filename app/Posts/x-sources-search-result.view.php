<?php
use function Tempest\Router\uri;
use App\Posts\PendingSourcesController;
?>

<div class="grid gap-2" id="search-results">
    <div
        :foreach="($sources ?? []) as $source"
        class="p-2 pl-4 rounded-lg shadow-sm bg-gray-200 flex items-center justify-between"
    >
        <h1>
            <span class="font-bold">{{ $source->name }}</span>
        </h1>

        <div class="flex gap-2">
            <x-action-button :if="$source->isPending || $source->isDenied" :action="uri([PendingSourcesController::class, 'publish'], source: $source->id)" target="#sources-list">
                <x-icon name="lucide:check" class="size-5 text-gray-400"/>
            </x-action-button>

            <x-action-button :if="$source->isPending || $source->isPublished" :action="uri([PendingSourcesController::class, 'deny'], source: $source->id)" target="#sources-list">
                <x-icon name="lucide:trash-2" class="size-5 text-gray-400"/>
            </x-action-button>

            <a class="bg-gray-100 p-2 rounded-md htmx-button flex items-center" :href="$source->uri">
                <x-icon name="lucide:external-link" class="size-5 text-gray-400"/>
            </a>
        </div>
    </div>
</div>