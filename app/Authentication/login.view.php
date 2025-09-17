<?php
use function Tempest\Router\uri;
use App\Authentication\AuthController;
?>

<x-base title="Login">
    <div class="flex justify-center items-center h-screen">
        <div class="flex justify-between gap-2">
            <a href="{{ uri([AuthController::class, 'google']) }}" class="p-4 bg-white hover:bg-gray-100 border-4 border-white rounded-xl">
                <x-icon name="logos:google-icon" class="size-6" />
            </a>
        </div>
    </div>
</x-base>
