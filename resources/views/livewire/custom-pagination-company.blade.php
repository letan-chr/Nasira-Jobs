<nav aria-label="Page navigation example">
@if ($paginator->hasPages())
    <ul role="navigation" class="pagination mb-0 justify-content-center flex-wrap">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item previous disabled mt-2" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span aria-hidden="true">
                    <i class="fa-solid fa-angle-left text-gray pt-1"></i>
                </span>
                <span class="sr-only">@lang('pagination.previous')</span>
            </li>
        @else
            <li class="page-item">
                <a wire:click="previousPage" rel="prev" class="page-link previous"
                        aria-label="@lang('pagination.previous')">
                    <span aria-hidden="true">
                        <i class="fa-solid fa-angle-left text-gray"></i>
                    </span>
                    <span class="sr-only">@lang('pagination.previous')</span>
                </a>
            </li>
        @endif
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled mt-1" aria-disabled="true">{{ $element }}</li>
            @endif
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item"><a class="page-link active">{{ $page }}</a></li>
                    @else
                        <li class="page-item">
                            <a wire:click="gotoPage({{ $page }})" class="page-link text-gray">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a wire:click="nextPage({{$paginator->lastPage()}})" rel="next"
                        aria-label="@lang('pagination.next')" class="page-link next">
                    <span aria-hidden="true">
                        <i class="fa-solid fa-angle-right text-gray"></i>
                    </span>
                    <span class="sr-only ">@lang('pagination.next')</span>
                </a>
            </li>
        @else
            <li class="page-item next disabled mt-1" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span aria-hidden="true">
                    <i class="fa-solid fa-angle-right text-gray pt-1"></i>
                </span>
                <span class="sr-only ">@lang('pagination.next')</span>
            </li>
        @endif
    </ul>
@endif
</nav>
