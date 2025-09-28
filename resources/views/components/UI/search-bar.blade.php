@props([
    'id' => 'searchbar',
    'placeholder' => 'Pencarian',
    'value' => '',
    'name' => 'q',
    'showFilter' => false,
    'filterTarget' => null, // contoh: '#offcanvasFilter'
    'action' => null, // URL untuk submit (opsional)
    'method' => 'GET', // GET/POST/PUT/PATCH/DELETE
    'debounce' => 350, // ms (untuk JS input debounce, kalau ada)
    'size' => 'md', // 'md' | 'nav' (kecil untuk navbar)
])

@php
    $method = strtoupper($method ?? 'GET');
    // class dasar + varian ukuran
    $classes = 'searchbar' . ($size === 'nav' ? ' searchbar--nav' : '');
@endphp

<form id="{{ $id }}" role="search" data-debounce="{{ $debounce }}"
    {{ $attributes->merge(['class' => $classes]) }}
    @if ($action) action="{{ $action }}" method="{{ in_array($method, ['GET', 'POST']) ? $method : 'POST' }}" @endif>

    {{-- method spoofing & csrf bila perlu --}}
    @if ($action && !in_array($method, ['GET', 'POST']))
        @method($method)
    @endif
    @if ($action && ($method === 'POST' || !in_array($method, ['GET', 'POST'])))
        @csrf
    @endif

    @if ($showFilter && $filterTarget)
        <button class="searchbar__btn searchbar__btn--ghost" type="button" data-bs-toggle="offcanvas"
            data-bs-target="{{ $filterTarget }}" aria-controls="{{ ltrim($filterTarget, '#') }}" aria-label="Buka filter">
            <i class="bi bi-sliders"></i>
        </button>
    @endif

    <input class="searchbar__input" type="search" name="{{ $name }}" value="{{ $value }}"
        placeholder="{{ $placeholder }}" autocomplete="off" aria-label="Kolom pencarian">

    <button class="searchbar__btn" type="submit" aria-label="Cari">
        <i class="bi bi-search"></i>
    </button>
</form>
