<button
    type="button"
    class="bg-gray-100 p-2 rounded-md cursor-pointer htmx-button flex items-center"
    :class="$class ?? ''"
    :hx-post="$action"
    :hx-target="$target ?? '#app'"
    hx-trigger="click consume"
>
    <span class="during-input">
        <x-slot />
    </span>
    <x-icon name="svg-spinners:pulse-3" class="size-5 text-gray-600 during-request"/>
</button>
