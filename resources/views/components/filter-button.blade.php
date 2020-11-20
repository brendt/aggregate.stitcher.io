<a
    href="{{ filter($name, $value ?? null) }}"
    class="
        button button-small
        {{ filter_active($name, $value ?? null) ? 'button-active' : '' }}
        {{ $class ?? '' }}
    "
>
    {{ $slot ?? '' }}
</a>
