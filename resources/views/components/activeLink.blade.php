<a
    href="{{ $href }}"
    class="{{ is_link_active($href, ...($other ?? [])) ? 'link-active' : '' }}"
>
    {{ $slot }}
</a>
