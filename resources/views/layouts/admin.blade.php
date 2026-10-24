@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-[#090B10]">
    <!-- Admin Sidebar -->
    <aside class="w-64 bg-[#0D111A] border-r border-[#202838] flex flex-col shrink-0 sticky top-0 h-screen z-20">
        <!-- Brand Header -->
        <div class="p-6 border-b border-[#202838] flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-[#141923] border border-[#B68A4A]/40 flex items-center justify-center text-[#B68A4A] shrink-0 shadow-inner">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
            </div>
            <div class="min-w-0">
                <h1 class="font-serif-dream font-bold text-sm text-[#D8D0C0] tracking-widest uppercase truncate">Dream Pawn</h1>
                <p class="text-[10px] text-[#B68A4A] font-semibold tracking-widest uppercase">The Curio Archive</p>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-3.5 py-5 space-y-1 overflow-y-auto">
            @php
                $navItems = [
                    ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ['route' => 'admin.items.index', 'label' => 'Items Inventory', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                    ['route' => 'admin.loan-requests.index', 'label' => 'Loan Requests', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
                    ['route' => 'admin.members.index', 'label' => 'Members', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                    ['route' => 'admin.fines.index', 'label' => 'Fines', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['route' => 'admin.categories.index', 'label' => 'Categories', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                    ['route' => 'admin.reports.loans.index', 'label' => 'Reports', 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ];
            @endphp

            @foreach ($navItems as $item)
                @php
                    $isActive = request()->routeIs($item['route'].'*');
                @endphp
                <a href="{{ route($item['route']) }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium transition-all duration-150 {{ $isActive ? 'bg-[#1B2232] text-[#B68A4A] border border-[#B68A4A]/30 shadow-sm' : 'text-[#858A96] hover:text-[#D8D0C0] hover:bg-[#141923] border border-transparent' }}">
                    <svg class="w-4 h-4 shrink-0 {{ $isActive ? 'text-[#B68A4A]' : 'text-[#858A96]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $item['icon'] }}"/>
                    </svg>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <!-- Current User Profile & Logout -->
        <div class="p-4 border-t border-[#202838] bg-[#0A0D14]">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 rounded-full bg-[#141923] border border-[#B68A4A]/40 flex items-center justify-center text-xs font-bold text-[#B68A4A] shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-[#D8D0C0] truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-[11px] text-[#858A96] truncate">Curator Authority</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-1.5 text-[11px] font-medium text-[#858A96] hover:text-rose-300 bg-[#141923] hover:bg-rose-950/30 border border-[#202838] hover:border-rose-500/30 rounded-lg transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Log Out</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Topbar -->
        <header class="h-16 border-b border-[#202838] bg-[#0D111A]/90 backdrop-blur-sm sticky top-0 z-10 px-8 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <span class="text-[11px] font-mono uppercase text-[#B68A4A]">Archive Control</span>
                <span class="text-[#202838]">/</span>
                <h2 class="text-xs font-medium text-[#858A96]">@yield('page_title', 'Overview')</h2>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" target="_blank" class="text-xs text-[#858A96] hover:text-[#B68A4A] flex items-center gap-1.5 transition">
                    <span>Front Sanctuary</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
                <div class="h-4 w-px bg-[#202838]"></div>
                <div class="text-[11px] font-mono text-[#858A96]">
                    {{ now()->translatedFormat('d M Y') }}
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6 md:p-8 max-w-7xl w-full mx-auto">
            @include('components.flash')
            @yield('admin_content')
        </main>
    </div>
</div>
@endsection
