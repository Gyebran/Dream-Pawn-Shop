@props(['paginator'])

@if ($paginator->hasPages())
    <div class="px-5 py-3.5 flex items-center justify-between border-t border-[#202838] bg-[#0E131F] text-xs text-[#858A96]">
        <div>
            Showing <span class="text-[#D8D0C0] font-medium">{{ $paginator->firstItem() ?? 0 }}</span> to <span class="text-[#D8D0C0] font-medium">{{ $paginator->lastItem() ?? 0 }}</span> of <span class="text-[#D8D0C0] font-medium">{{ $paginator->total() }}</span> artifacts
        </div>

        <div class="flex items-center gap-1.5">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-1.5 rounded-lg border border-[#202838] bg-[#141923]/50 text-[#5A6272] cursor-not-allowed text-xs">
                    &larr; Prev
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg border border-[#202838] bg-[#141923] hover:bg-[#1B2232] text-[#D8D0C0] transition text-xs">
                    &larr; Prev
                </a>
            @endif

            {{-- Current Page indicator --}}
            <span class="px-3 py-1.5 rounded-lg bg-[#B68A4A] text-[#090B10] font-bold text-xs shadow-sm">
                {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
            </span>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg border border-[#202838] bg-[#141923] hover:bg-[#1B2232] text-[#D8D0C0] transition text-xs">
                    Next &rarr;
                </a>
            @else
                <span class="px-3 py-1.5 rounded-lg border border-[#202838] bg-[#141923]/50 text-[#5A6272] cursor-not-allowed text-xs">
                    Next &rarr;
                </span>
            @endif
        </div>
    </div>
@endif
