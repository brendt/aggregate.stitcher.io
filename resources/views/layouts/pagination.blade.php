@if ($paginator->hasPages())
    <div class="flex justify-center" role="navigation">
        @if ($paginator->onFirstPage())
            <span aria-hidden="true" class="p-1 pl-2 pr-2">&lsaquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="p-1 pl-2 pr-2" aria-label="@lang('pagination.previous')">&lsaquo;</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="ml-1 mr-1">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="text-bold p-1 pl-2 pr-2 bg-grey-light">{{ $page }}</span>
                    @else
                        <a class="p-1 pl-2 pr-2 hover:bg-grey" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="p-1 pl-2 pr-2" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
        @else
            <span aria-hidden="true" class="p-1 pl-2 pr-2">&rsaquo;</span>
        @endif
    </div>
@endif
