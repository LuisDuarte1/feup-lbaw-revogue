@if ($paginator->hasPages())
    <nav class="pagination">
        <ul class="pagination-buttons">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                    <span>Previous</span>
                </li>
            @else
                <li class="abled"><a href="{{ $paginator->previousPageUrl() }}" rel="prev">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                        <span>
                            Previous
                        </span>
                    </a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="abled">
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next"> 
                        <span>Next</span>
                        <ion-icon name="chevron-forward-outline"></ion-icon> 
                    </a>
                </li>
            @else
                <li class="disabled">
                    <span>Next</span>
                    <ion-icon name="chevron-forward-outline"></ion-icon> 
                </li>
            @endif
        </ul>
    </nav>
@endif
