@props([
    'id' => 'searchbar',
    'placeholder' => 'Pencarian',
    'value' => '',
    'showFilter' => false,
    'filterTarget' => null, // contoh: '#offcanvasFilter'
    'action' => null, // opsi: submit ke route
    'method' => 'GET', // GET/POST
    'debounce' => 350, // ms (untuk event input real-time)
])

<form id="{{ $id }}" role="search" data-debounce="{{ $debounce }}"
    {{ $attributes->merge(['class' => 'searchbar']) }}
    @if ($action) action="{{ $action }}" method="{{ $method }}" @endif>
    @if ($showFilter && $filterTarget)
        <button class="searchbar__btn searchbar__btn--ghost" type="button" data-bs-toggle="offcanvas"
            data-bs-target="{{ $filterTarget }}" aria-label="Buka filter">
            <i class="bi bi-list"></i>
        </button>
    @endif

    <input class="searchbar__input" type="search" name="q" value="{{ $value }}"
        placeholder="{{ $placeholder }}" autocomplete="off" />

    <button class="searchbar__btn" type="submit" aria-label="Cari">
        <i class="bi bi-search"></i>
    </button>
</form>
