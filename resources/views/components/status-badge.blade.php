@props(['status', 'type' => 'item'])

@php
    $s = strtolower((string)$status);
    $configs = [
        // Items
        'available' => ['label' => 'Available', 'class' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/25', 'dot' => 'bg-emerald-400'],
        'reserved'  => ['label' => 'Reserved', 'class' => 'bg-amber-500/10 text-amber-300 border-amber-500/25', 'dot' => 'bg-amber-400'],
        'loaned'    => ['label' => 'On Loan', 'class' => 'bg-sky-500/10 text-sky-400 border-sky-500/25', 'dot' => 'bg-sky-400'],
        'archived'  => ['label' => 'Archived', 'class' => 'bg-slate-500/10 text-slate-400 border-slate-500/20', 'dot' => 'bg-slate-400'],

        // Loan Requests
        'pending'   => ['label' => 'Pending', 'class' => 'bg-amber-500/10 text-amber-300 border-amber-500/25', 'dot' => 'bg-amber-400'],
        'approved'  => ['label' => 'Approved', 'class' => 'bg-blue-500/10 text-blue-300 border-blue-500/25', 'dot' => 'bg-blue-400'],
        'active'    => ['label' => 'Active', 'class' => 'bg-sky-500/10 text-sky-300 border-sky-500/25', 'dot' => 'bg-sky-400'],
        'returned'  => ['label' => 'Returned', 'class' => 'bg-purple-500/10 text-purple-300 border-purple-500/25', 'dot' => 'bg-purple-400'],
        'rejected'  => ['label' => 'Rejected', 'class' => 'bg-rose-500/10 text-rose-300 border-rose-500/25', 'dot' => 'bg-rose-400'],
        'cancelled' => ['label' => 'Cancelled', 'class' => 'bg-slate-500/10 text-slate-400 border-slate-500/20', 'dot' => 'bg-slate-400'],

        // Fines
        'unpaid'    => ['label' => 'Unpaid', 'class' => 'bg-rose-500/10 text-rose-300 border-rose-500/25', 'dot' => 'bg-rose-400'],
        'paid'      => ['label' => 'Settled', 'class' => 'bg-emerald-500/10 text-emerald-300 border-emerald-500/25', 'dot' => 'bg-emerald-400'],

        // Member accounts
        'active_account'   => ['label' => 'Active', 'class' => 'bg-emerald-500/10 text-emerald-300 border-emerald-500/25', 'dot' => 'bg-emerald-400'],
        'inactive_account' => ['label' => 'Inactive', 'class' => 'bg-rose-500/10 text-rose-300 border-rose-500/25', 'dot' => 'bg-rose-400'],
    ];

    if ($type === 'member') {
        $key = $status ? 'active_account' : 'inactive_account';
    } else {
        $key = $s;
    }

    $badge = $configs[$key] ?? ['label' => ucfirst($s), 'class' => 'bg-slate-500/10 text-slate-400 border-slate-500/20', 'dot' => 'bg-slate-400'];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-medium border ' . $badge['class']]) }}>
    <span class="w-1.5 h-1.5 rounded-full {{ $badge['dot'] }}"></span>
    <span>{{ $badge['label'] }}</span>
</span>
