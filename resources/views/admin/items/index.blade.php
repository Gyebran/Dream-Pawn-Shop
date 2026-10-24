@extends('layouts.admin')

@section('title', 'Items Inventory — The Curio Archive')
@section('page_title', 'Items Inventory')

@section('admin_content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-serif-dream text-xl md:text-2xl font-bold text-[#D8D0C0] tracking-wide">Items Inventory</h1>
            <p class="text-xs text-[#858A96] mt-1">Manage your collection of unique artifacts and prop records</p>
        </div>
        <button type="button" onclick="openModal('create-item-modal')"
                class="px-4 py-2 rounded-lg bg-[#B68A4A] hover:bg-[#C99B58] text-[#090B10] font-bold text-xs transition flex items-center justify-center gap-1.5 self-start sm:self-auto shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>+ Add Item</span>
        </button>
    </div>

    <!-- Integrated Search & Filter Bar -->
    <form method="GET" action="{{ route('admin.items.index') }}" class="curio-card p-3.5 flex flex-wrap items-center gap-3">
        <div class="flex-1 min-w-[240px] relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-[#858A96]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </span>
            <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search by name, code, or description..."
                   class="w-full pl-9 pr-3 py-1.5 rounded-lg bg-[#0D111A] border border-[#202838] text-xs text-[#D8D0C0] placeholder-[#5A6272] focus:border-[#B68A4A] focus:outline-none transition">
        </div>

        <div class="w-40 sm:w-44">
            <select name="status" class="w-full px-3 py-1.5 rounded-lg bg-[#0D111A] border border-[#202838] text-xs text-[#D8D0C0] focus:border-[#B68A4A] focus:outline-none transition">
                <option value="">All Status</option>
                <option value="available" {{ ($filters['status'] ?? '') === 'available' ? 'selected' : '' }}>Available</option>
                <option value="reserved" {{ ($filters['status'] ?? '') === 'reserved' ? 'selected' : '' }}>Reserved</option>
                <option value="loaned" {{ ($filters['status'] ?? '') === 'loaned' ? 'selected' : '' }}>On Loan</option>
                <option value="archived" {{ ($filters['status'] ?? '') === 'archived' ? 'selected' : '' }}>Archived</option>
            </select>
        </div>

        <button type="submit" class="px-3.5 py-1.5 rounded-lg bg-[#1B2232] hover:bg-[#242D3D] text-[#D8D0C0] border border-[#202838] text-xs font-medium transition flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5 text-[#858A96]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
            <span>Filter</span>
        </button>

        @if (!empty($filters['search']) || !empty($filters['status']))
            <a href="{{ route('admin.items.index') }}" class="text-xs text-[#858A96] hover:text-[#B68A4A] transition">Reset</a>
        @endif
    </form>

    <!-- Items Table -->
    <div class="curio-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#D8D0C0]">
                <thead class="bg-[#0D111A] text-[11px] font-semibold text-[#858A96] uppercase tracking-wider border-b border-[#202838]">
                    <tr>
                        <th class="px-4 py-3.5 text-center w-14">Image</th>
                        <th class="px-4 py-3.5">Name</th>
                        <th class="px-4 py-3.5">Code</th>
                        <th class="px-4 py-3.5">Category</th>
                        <th class="px-4 py-3.5">Status</th>
                        <th class="px-4 py-3.5 text-right w-28">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1A2130]">
                    @forelse ($items as $item)
                        <tr class="hover:bg-[#1B2232]/50 transition">
                            <!-- Image / Thumbnail -->
                            <td class="px-4 py-3.5 text-center">
                                <div class="w-9 h-9 rounded-lg bg-[#0D111A] border border-[#202838] flex items-center justify-center text-[#B68A4A] mx-auto shrink-0 shadow-inner">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </td>

                            <!-- Name & Curator Note -->
                            <td class="px-4 py-3.5">
                                <a href="{{ route('admin.items.show', $item->id) }}" class="font-medium text-[#D8D0C0] text-sm hover:text-[#B68A4A] transition block">
                                    {{ $item->name }}
                                </a>
                                @if ($item->description)
                                    <span class="text-[11px] text-[#858A96] block truncate max-w-xs mt-0.5" title="{{ $item->description }}">
                                        {{ $item->description }}
                                    </span>
                                @endif
                            </td>

                            <!-- Unit Code -->
                            <td class="px-4 py-3.5 font-mono text-xs text-[#B68A4A] font-semibold">
                                {{ $item->unit_code }}
                            </td>

                            <!-- Categories -->
                            <td class="px-4 py-3.5">
                                <div class="flex flex-wrap gap-1">
                                    @forelse ($item->categories as $c)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-[#1B2232] text-[#B68A4A] border border-[#B68A4A]/20">
                                            {{ $c->name }}
                                        </span>
                                    @empty
                                        <span class="text-[#5A6272] italic">-</span>
                                    @endforelse
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="px-4 py-3.5">
                                @include('components.status-badge', ['status' => $item->status])
                                @if (in_array($item->status, ['reserved', 'loaned']))
                                    <span class="block text-[10px] text-[#858A96] mt-0.5">In active loan</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-4 py-3.5 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1">
                                    <!-- View Link -->
                                    <a href="{{ route('admin.items.show', $item->id) }}"
                                       class="p-1.5 rounded-lg text-[#858A96] hover:text-[#D8D0C0] hover:bg-[#1B2232] border border-transparent hover:border-[#202838] transition"
                                       title="View details">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>

                                    <!-- Edit Button (Safe Data Binding) -->
                                    <button type="button" 
                                            data-action="edit-item"
                                            data-id="{{ $item->id }}"
                                            data-unit-code="{{ $item->unit_code }}"
                                            data-name="{{ $item->name }}"
                                            data-description="{{ $item->description }}"
                                            data-category-ids="{{ $item->categories->pluck('id')->join(',') }}"
                                            class="p-1.5 rounded-lg text-[#858A96] hover:text-[#B68A4A] hover:bg-[#1B2232] border border-transparent hover:border-[#202838] transition"
                                            title="Edit artifact">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>

                                    <!-- Archive Button (Safe Data Binding) -->
                                    @if ($item->status === 'available')
                                        <button type="button" 
                                                data-action="archive-item"
                                                data-id="{{ $item->id }}"
                                                data-unit-code="{{ $item->unit_code }}"
                                                data-name="{{ $item->name }}"
                                                class="p-1.5 rounded-lg text-[#858A96] hover:text-rose-400 hover:bg-rose-950/20 border border-transparent hover:border-rose-500/20 transition"
                                                title="Archive artifact">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    @elseif ($item->status !== 'archived')
                                        <span class="p-1.5 text-[#5A6272] cursor-not-allowed" title="Item is currently reserved or on loan and cannot be archived">
                                            <svg class="w-4 h-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                @include('components.empty-state', [
                                    'title' => 'No Artifacts Found',
                                    'description' => 'No items match your active search or filter criteria.'
                                ])
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @include('components.pagination', ['paginator' => $items])
    </div>
</div>

<!-- Modal: Add New Item -->
<div id="create-item-modal" class="modal-wrapper fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="fixed inset-0 modal-backdrop" onclick="closeModal('create-item-modal')"></div>
    <div class="relative curio-card modal-content p-6 max-w-lg w-full shadow-2xl z-10 max-h-[90vh] overflow-y-auto bg-[#141923] border border-[#202838]">
        <div class="flex items-center justify-between pb-3 border-b border-[#202838] mb-4">
            <div>
                <h3 class="font-serif-dream text-base font-bold text-[#D8D0C0]">Register New Artifact</h3>
                <p class="text-xs text-[#858A96] mt-0.5">Catalogue a new physical prop into the curio collection</p>
            </div>
            <button type="button" onclick="closeModal('create-item-modal')" class="text-[#858A96] hover:text-[#D8D0C0] p-1 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.items.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-[#D8D0C0] mb-1">Unit Code * (Unique Identifier)</label>
                <input type="text" name="unit_code" required
                       class="w-full px-3 py-2 rounded-lg bg-[#0D111A] border border-[#202838] text-xs text-[#D8D0C0] font-mono focus:border-[#B68A4A] focus:outline-none placeholder-[#5A6272]"
                       placeholder="e.g. DPS-009, REL-042">
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#D8D0C0] mb-1">Artifact Name *</label>
                <input type="text" name="name" required
                       class="w-full px-3 py-2 rounded-lg bg-[#0D111A] border border-[#202838] text-xs text-[#D8D0C0] focus:border-[#B68A4A] focus:outline-none placeholder-[#5A6272]"
                       placeholder="e.g. The Yesterday Watch">
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#D8D0C0] mb-1">Assign Categories</label>
                <div class="p-3 rounded-lg bg-[#0D111A] border border-[#202838] max-h-36 overflow-y-auto space-y-1.5">
                    @foreach ($categories as $cat)
                        <label class="flex items-center gap-2 text-xs text-[#D8D0C0] hover:text-[#B68A4A] cursor-pointer">
                            <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}"
                                   class="rounded bg-[#141923] border-[#202838] text-[#B68A4A] focus:ring-[#B68A4A]/20">
                            <span>{{ $cat->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#D8D0C0] mb-1">Description & Curator Note</label>
                <textarea name="description" rows="3"
                          class="w-full px-3 py-2 rounded-lg bg-[#0D111A] border border-[#202838] text-xs text-[#D8D0C0] focus:border-[#B68A4A] focus:outline-none placeholder-[#5A6272]"
                          placeholder="Physical appearance, surreal properties, or historical notes..."></textarea>
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-[#202838]">
                <button type="button" onclick="closeModal('create-item-modal')" class="px-3.5 py-1.5 rounded-lg text-xs font-medium text-[#858A96] hover:text-[#D8D0C0] transition">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-1.5 rounded-lg bg-[#B68A4A] hover:bg-[#C99B58] text-[#090B10] font-bold text-xs transition shadow-sm">
                    Save Artifact
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Item -->
<div id="edit-item-modal" class="modal-wrapper fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="fixed inset-0 modal-backdrop" onclick="closeModal('edit-item-modal')"></div>
    <div class="relative curio-card modal-content p-6 max-w-lg w-full shadow-2xl z-10 max-h-[90vh] overflow-y-auto bg-[#141923] border border-[#202838]">
        <div class="flex items-center justify-between pb-3 border-b border-[#202838] mb-4">
            <div>
                <h3 class="font-serif-dream text-base font-bold text-[#D8D0C0]">Edit Artifact Record</h3>
                <p class="text-xs text-[#858A96] mt-0.5">Update catalog specifications and categories</p>
            </div>
            <button type="button" onclick="closeModal('edit-item-modal')" class="text-[#858A96] hover:text-[#D8D0C0] p-1 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="edit-item-form" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')
            <div>
                <label class="block text-xs font-semibold text-[#D8D0C0] mb-1">Unit Code *</label>
                <input type="text" id="edit-item-unit-code" name="unit_code" required
                       class="w-full px-3 py-2 rounded-lg bg-[#0D111A] border border-[#202838] text-xs text-[#D8D0C0] font-mono focus:border-[#B68A4A] focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#D8D0C0] mb-1">Artifact Name *</label>
                <input type="text" id="edit-item-name" name="name" required
                       class="w-full px-3 py-2 rounded-lg bg-[#0D111A] border border-[#202838] text-xs text-[#D8D0C0] focus:border-[#B68A4A] focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#D8D0C0] mb-1">Assign Categories</label>
                <div class="p-3 rounded-lg bg-[#0D111A] border border-[#202838] max-h-36 overflow-y-auto space-y-1.5">
                    @foreach ($categories as $cat)
                        <label class="flex items-center gap-2 text-xs text-[#D8D0C0] hover:text-[#B68A4A] cursor-pointer">
                            <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}" id="edit-cat-{{ $cat->id }}"
                                   class="edit-item-cat-checkbox rounded bg-[#141923] border-[#202838] text-[#B68A4A] focus:ring-[#B68A4A]/20">
                            <span>{{ $cat->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#D8D0C0] mb-1">Description & Curator Note</label>
                <textarea id="edit-item-description" name="description" rows="3"
                          class="w-full px-3 py-2 rounded-lg bg-[#0D111A] border border-[#202838] text-xs text-[#D8D0C0] focus:border-[#B68A4A] focus:outline-none"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-[#202838]">
                <button type="button" onclick="closeModal('edit-item-modal')" class="px-3.5 py-1.5 rounded-lg text-xs font-medium text-[#858A96] hover:text-[#D8D0C0] transition">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-1.5 rounded-lg bg-[#B68A4A] hover:bg-[#C99B58] text-[#090B10] font-bold text-xs transition shadow-sm">
                    Update Artifact
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Archive Item Confirmation -->
<div id="archive-item-modal" class="modal-wrapper fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="fixed inset-0 modal-backdrop" onclick="closeModal('archive-item-modal')"></div>
    <div class="relative curio-card modal-content p-6 max-w-md w-full shadow-2xl z-10 bg-[#141923] border border-rose-500/30">
        <div class="flex items-center gap-3 text-rose-400 mb-3">
            <div class="w-10 h-10 rounded-xl bg-rose-500/10 border border-rose-500/25 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <h3 class="font-serif-dream text-base font-bold text-[#D8D0C0]">Archive Artifact</h3>
                <p class="text-[11px] text-[#858A96]">Curatorial preservation action</p>
            </div>
        </div>
        <p class="text-xs text-[#D8D0C0] mb-4 leading-relaxed">
            Are you sure you want to archive artifact <strong id="archive-item-name" class="text-[#B68A4A]"></strong> (<span id="archive-item-code" class="font-mono text-[#B68A4A]"></span>)?
            Archived items will be hidden from the public member catalog while keeping historical loan records fully preserved.
        </p>
        <form id="archive-item-form" method="POST" class="flex items-center justify-end gap-2.5">
            @csrf
            @method('PATCH')
            <button type="button" onclick="closeModal('archive-item-modal')" class="px-3.5 py-1.5 rounded-lg text-xs font-medium text-[#858A96] hover:text-[#D8D0C0] transition">
                Cancel
            </button>
            <button type="submit" class="px-4 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs transition shadow-sm">
                Confirm Archive
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Safe data binding for Edit action
        document.querySelectorAll('[data-action="edit-item"]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const id = btn.getAttribute('data-id');
                const code = btn.getAttribute('data-unit-code');
                const name = btn.getAttribute('data-name');
                const desc = btn.getAttribute('data-description');
                const catIdsStr = btn.getAttribute('data-category-ids') || '';
                const catIds = catIdsStr.split(',').filter(Boolean).map(Number);

                document.getElementById('edit-item-form').action = '/admin/items/' + id;
                document.getElementById('edit-item-unit-code').value = code || '';
                document.getElementById('edit-item-name').value = name || '';
                document.getElementById('edit-item-description').value = desc || '';

                document.querySelectorAll('.edit-item-cat-checkbox').forEach(function (cb) {
                    cb.checked = catIds.includes(Number(cb.value));
                });

                openModal('edit-item-modal');
            });
        });

        // Safe data binding for Archive action
        document.querySelectorAll('[data-action="archive-item"]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const id = btn.getAttribute('data-id');
                const code = btn.getAttribute('data-unit-code');
                const name = btn.getAttribute('data-name');

                document.getElementById('archive-item-form').action = '/admin/items/' + id + '/archive';
                document.getElementById('archive-item-name').textContent = name || '';
                document.getElementById('archive-item-code').textContent = code || '';

                openModal('archive-item-modal');
            });
        });
    });
</script>
@endsection
