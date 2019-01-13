<a
    href="{{ filter($name, $value ?? null) }}"
    class="
        text-sm button button-small
        {{ filter_active($name, $value ?? null) ? 'button-active' : '' }}
        {{ $class ?? '' }}
    "
>
    {{ $slot ?? '' }}
</a>
