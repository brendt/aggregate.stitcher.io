<a
    href="{{ query_sort($name) }}"
    class=""
>
    {{ $slot ?? '' }}

    @if(query_sort_active($name))
        &#9662;
    @endif

    @if(query_sort_active('-' . $name))
        &#9652;
    @endif
</a>
