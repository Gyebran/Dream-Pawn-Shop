@if (session('success'))
    <div class="mb-5 p-3.5 rounded-xl bg-[#141923] border border-[#10B981]/40 text-[#D8D0C0] flex items-start gap-3 shadow-sm" role="alert">
        <svg class="w-4 h-4 text-[#10B981] mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div class="flex-1 text-xs leading-relaxed">
            <strong class="font-semibold text-emerald-200">Success:</strong> {{ session('success') }}
        </div>
    </div>
@endif

@if (session('error'))
    <div class="mb-5 p-3.5 rounded-xl bg-[#191114] border border-[#F43F5E]/40 text-[#FECDD3] flex items-start gap-3 shadow-sm" role="alert">
        <svg class="w-4 h-4 text-[#F43F5E] mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div class="flex-1 text-xs leading-relaxed">
            <strong class="font-semibold text-rose-200">Notice:</strong> {{ session('error') }}
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="mb-5 p-3.5 rounded-xl bg-[#191114] border border-[#F43F5E]/40 text-[#FECDD3] shadow-sm" role="alert">
        <div class="flex items-center gap-2 mb-2 font-semibold text-rose-200 text-xs">
            <svg class="w-4 h-4 text-[#F43F5E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <span>Please correct the following input errors:</span>
        </div>
        <ul class="list-disc list-inside text-xs space-y-1 text-rose-300/80 pl-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
