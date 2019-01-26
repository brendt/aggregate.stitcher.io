<a
    href="{{ query_sort($name) }}"
    class=""
>
    {{ $slot ?? '' }}

    @if(query_sort_active($name))
        &#9662;
    @elseif(query_sort_active('-' . $name))
        &#9652;
    @else
        <span class="text-grey">&#9652; &#9662;</span>
    @endif
</a>
