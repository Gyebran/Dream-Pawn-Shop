<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dream Pawn Shop') — Surreal Collectible Props Rental</title>

    <!-- Google Fonts: Plus Jakarta Sans & Cinzel -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="/build/assets/app.css">
    @endif

    <style>
        .font-serif-dream { font-family: 'Cinzel', Georgia, serif; }
        .font-sans-ui { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="bg-[#090B10] text-[#D8D0C0] font-sans-ui antialiased min-h-screen selection:bg-[#B68A4A]/30 selection:text-[#DFC08A]">
    <div class="relative z-10 flex flex-col min-h-screen">
        @yield('content')
    </div>

    <!-- Global Toast Container -->
    <div id="toast-container" class="fixed bottom-6 right-6 z-50 flex flex-col gap-3 max-w-md pointer-events-none"></div>

    <!-- Global Toast / Modal Script -->
    <script>
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = `pointer-events-auto px-4 py-3 rounded-xl shadow-2xl border text-sm flex items-center gap-3 transition-all duration-300 transform translate-y-4 opacity-0 ${
                type === 'success' 
                    ? 'bg-[#141923] text-[#D8D0C0] border-[#B68A4A]/50 shadow-[#090B10]/80' 
                    : (type === 'error' ? 'bg-[#181216] text-rose-200 border-rose-500/40 shadow-[#090B10]/80' : 'bg-[#1B2232] text-[#D8D0C0] border-slate-700 shadow-[#090B10]/80')
            }`;
            
            const icon = type === 'success' 
                ? '<svg class="w-5 h-5 text-[#B68A4A] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>'
                : '<svg class="w-5 h-5 text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>';

            toast.innerHTML = `${icon}<span>${message}</span>`;
            container.appendChild(toast);

            requestAnimationFrame(() => {
                toast.classList.remove('translate-y-4', 'opacity-0');
            });

            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-x-4');
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }

        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-wrapper:not(.hidden)').forEach(modal => {
                    closeModal(modal.id);
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
