<?php
use App\Posts\SourcesController;
use function Tempest\Router\uri;
?>

<div id="pending-sources" class="grid gap-2">
    <div
            :foreach="$pendingSources as $pendingSource"
            class="p-2 pl-4 rounded-lg shadow-sm bg-gray-200 flex items-center justify-between"
    >
        <h1>
            <span class="font-bold">{{ $pendingSource->name }}</span>
        </h1>

        <div class="flex gap-2">
            <x-action-button :action="uri([SourcesController::class, 'accept'], source: $pendingSource->id)" target="#pending-sources">
                <x-icon name="lucide:check" class="size-5 text-gray-400"/>
            </x-action-button>

            <x-action-button :action="uri([SourcesController::class, 'deny'], source: $pendingSource->id)" target="#pending-sources">
                <x-icon name="lucide:trash-2" class="size-5 text-gray-400"/>
            </x-action-button>

            <a class="bg-gray-100 p-2 rounded-md htmx-button flex items-center" :href="$pendingSource->uri">
                <x-icon name="lucide:external-link" class="size-5 text-gray-400"/>
            </a>
        </div>
    </div>
</div>
