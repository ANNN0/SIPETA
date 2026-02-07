@props(['paginator'])

@if ($paginator->total() > 0)
    <div class="modern-pagination">
        <div class="pagination-info">
            <span class="page-range">{{ $paginator->firstItem() }}-{{ $paginator->lastItem() }}</span>
            <span class="page-total">of {{ $paginator->total() }}</span>
        </div>

        <div class="pagination-controls">
            @if ($paginator->onFirstPage())
                <button class="pagination-nav prev" disabled>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M11 2L5 8l6 6V2z" />
                    </svg>
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-nav prev">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M11 2L5 8l6 6V2z" />
                    </svg>
                </a>
            @endif

            {{-- Page Number Info --}}
            <div class="pagination-page-info">
                <span class="current-page">Page {{ $paginator->currentPage() }}</span>
                <span class="page-separator">of</span>
                <span class="total-pages">{{ $paginator->lastPage() }}</span>
            </div>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-nav next">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M5 2l6 6-6 6V2z" />
                    </svg>
                </a>
            @else
                <button class="pagination-nav next" disabled>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M5 2l6 6-6 6V2z" />
                    </svg>
                </button>
            @endif
        </div>
    </div>
@endif
