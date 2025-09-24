<?php
use function Tempest\Router\uri;
use App\Suggestions\SuggestionController;
?>

<x-base>
    <div class="max-w-[600px] m-auto grid gap-2">
        <x-form method="post" :action="uri([SuggestionController::class, 'createSuggestion'])">
            <div class="grid items-center gap-2 mb-4 mt-4">
                <div class="flex justify-center items-center gap-2 mb-4 mt-4">
                    <span class="font-bold text-slate-600">Submit to Aggregate</span>
                </div>

                <p>
                    Aggregate is a community-powered RSS feed, which you are a part of. Leave a link here to an interesting post, video, or blog, and it might be published in the feed!
                </p>

                <x-input type="text" name="suggestion">
                    <x-slot name="label">
                        <span class="font-bold text-slate-600">Your suggestion:</span>
                    </x-slot>
                </x-input>

                <div class="flex items-center gap-4 justify-end">
                    <a href="/" class="p-2 underline hover:no-underline">Back</a>
                    <x-submit/>
                </div>
            </div>
        </x-form>
    </div>
</x-base>