<a
    href="{{ filter($name, $value ?? null) }}"
    class="
        text-sm button
        {{ filter_active($name, $value ?? null) ? 'text-black' : '' }}
        {{ $class ?? '' }}
    "
>
    {{ $slot ?? '' }}
</a>
