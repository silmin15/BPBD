@props([
    // ['month' => true, 'date_range' => false, 'category' => false, ...]
    'fields' => [],
    // action GET untuk filter
    'action' => url()->current(),
])

<form method="get" action="{{ $action }}" class="row g-2 align-items-end mb-3">

    @if (($fields['month'] ?? false) === true)
        <div class="col-auto">
            <label class="form-label mb-1">Bulan</label>
            <input type="month" name="month" value="{{ request('month') }}" class="form-control">
        </div>
    @endif

    @if (($fields['date_range'] ?? false) === true)
        <div class="col-auto">
            <label class="form-label mb-1">Tanggal Mulai</label>
            <input type="date" name="start" value="{{ request('start') }}" class="form-control">
        </div>
        <div class="col-auto">
            <label class="form-label mb-1">Tanggal Akhir</label>
            <input type="date" name="end" value="{{ request('end') }}" class="form-control">
        </div>
    @endif

    @if (($fields['category'] ?? false) === true)
        <div class="col-auto">
            <label class="form-label mb-1">Kategori</label>
            <select name="category" class="form-select">
                <option value="">Semua</option>
                @foreach ($fields['category_options'] ?? [] as $val => $label)
                    <option value="{{ $val }}" @selected(request('category') == $val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    @endif

    {{-- tambahkan bidang lain sesuai kebutuhan halaman --}}
    <div class="col-auto">
        <button class="btn btn-outline-secondary"><i class="bi bi-funnel me-1"></i>Filter</button>
    </div>
</form>
