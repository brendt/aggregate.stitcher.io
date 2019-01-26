<a
    href="{{ $href }}"
    class="{{ is_link_active($href) ? 'link-active' : '' }}"
>
    {{ $slot }}
</a>
