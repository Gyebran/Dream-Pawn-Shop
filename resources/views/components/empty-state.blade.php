@props(['title' => 'No Artifacts Found', 'description' => 'No records currently match the archival criteria.', 'action' => null, 'actionUrl' => null])

<div class="py-12 px-4 text-center">
    <div class="w-14 h-14 mx-auto mb-3.5 rounded-xl bg-[#1B2232] border border-[#202838] flex items-center justify-center text-[#B68A4A]">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
        </svg>
    </div>
    <h3 class="text-sm font-semibold text-[#D8D0C0] mb-1">{{ $title }}</h3>
    <p class="text-xs text-[#858A96] max-w-sm mx-auto mb-4 leading-relaxed">{{ $description }}</p>
    @if ($action && $actionUrl)
        <a href="{{ $actionUrl }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-semibold bg-[#B68A4A] hover:bg-[#C99B58] text-[#090B10] transition shadow-sm">
            {{ $action }}
        </a>
    @endif
</div>
