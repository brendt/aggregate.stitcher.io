<?php
use function Tempest\Router\uri;
use App\Suggestions\SuggestionController;
?>

<x-base>
    <div class="max-w-[800px] m-auto grid gap-2">
        <x-form method="post" :action="uri([SuggestionController::class, 'createSuggestion'])">
            <div class="grid items-center gap-2 mb-4 mt-4">
                <x-input type="text" name="suggestion">
                    <x-slot name="label">
                        <span class="font-bold text-slate-600">Suggest a post or RSS feed:</span>
                    </x-slot>
                </x-input>

                <div class="flex justify-end">
                    <x-submit/>
                </div>
            </div>
        </x-form>
    </div>
</x-base>