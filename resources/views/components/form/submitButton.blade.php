<button
    type="submit"
    class="
        p-2
        border border-black rounded-sm
        hover:bg-blue hover:text-white
        {{ $class ?? null }}
    "
>
    {{ $slot ?? null }}
</button>
