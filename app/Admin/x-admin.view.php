<div id="app" class="grid md:grid-cols-2 gap-2">
    <div>
        Pending: {{ $pendingCount }}

    </div>
    <div>
        <div class="grid gap-4">
            <div class="grid gap-2">
                <h2 class="font-bold">Pending Posts</h2>
                <x-pending-posts :pendingPosts="$pendingPosts" />
            </div>
            <div class="grid gap-2">
                <h2 class="font-bold">Pending Sources</h2>
                <x-pending-sources :pendingPosts="$pendingPosts" />
            </div>
        </div>
    </div>
</div>