<div id="app" class="md:flex justify-between  items-start gap-8">
    <div class="grid gap-4 w-[50%]">
        <div class="grid gap-2">
            <h2 class="font-bold">Pending Posts</h2>
            <x-pending-posts :pendingPosts="$pendingPosts"/>
        </div>
        <div class="grid gap-2">
            <h2 class="font-bold">Pending Sources</h2>
            <x-pending-sources :pendingPosts="$pendingPosts"/>
        </div>
    </div>
    <div class="grid gap-4 w-[50%]">
        <div class="grid gap-2">
            <h2 class="font-bold">Sources</h2>
            <x-sources-list />
        </div>
    </div>
</div>