<?php
use function Tempest\Router\uri;
use App\Suggestions\SuggestionController;
?>

<div id="suggestions" class="grid gap-2">
    <div
        :foreach="$suggestions as $suggestion"
        class="p-2 pl-4 rounded-lg shadow-sm bg-slate-200 flex gap-2 flex-col sm:flex-row items-center justify-between"
    >

        <h1 class="text-gray-500">
            <span class="font-bold break-all">{{ $suggestion->uri }}</span>
        </h1>

        <div class="flex gap-8 sm:gap-2">
            <a class="bg-gray-100 p-2 rounded-md htmx-button flex items-center" :href="$suggestion->uri">
                <x-icon name="lucide:external-link" class="size-6 sm:size-5 text-gray-400"/>
            </a>

            <x-action-button :action="uri([SuggestionController::class, 'deny'], suggestion: $suggestion->id)" target="#suggestions">
                <x-icon name="lucide:trash-2" class="size-6 sm:size-5 text-gray-400"/>
            </x-action-button>

            <x-action-button :if="$suggestion->feedUri" :action="uri([SuggestionController::class, 'publish'], suggestion: $suggestion->id) . '?feed'" target="#suggestions">
                <x-icon name="lucide:check-check" class="size-6 sm:size-5 text-gray-400"/>
            </x-action-button>

            <x-action-button :action="uri([SuggestionController::class, 'publish'], suggestion: $suggestion->id)" target="#suggestions">
                <x-icon name="lucide:check" class="size-6 sm:size-5 text-gray-400"/>
            </x-action-button>
        </div>
    </div>
</div>