@if ($paginator->hasPages())
    <nav class="pager" role="navigation" aria-label="Постраничная навигация">
        @if ($paginator->onFirstPage())
            <span class="pager__item pager__item--disabled">←</span>
        @else
            <a class="pager__item" href="{{ $paginator->previousPageUrl() }}" rel="prev">←</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="pager__item pager__item--disabled">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="pager__item pager__item--active">{{ $page }}</span>
                    @else
                        <a class="pager__item" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a class="pager__item" href="{{ $paginator->nextPageUrl() }}" rel="next">→</a>
        @else
            <span class="pager__item pager__item--disabled">→</span>
        @endif
    </nav>
@endif
