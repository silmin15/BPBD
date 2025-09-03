{{-- resources/views/components/form/actions.blade.php --}}
@props([
    'align' => 'end', // start | center | end | between
    'stack' => false, // true => tombol vertikal (mobile)
])

@php
    $justify =
        [
            'start' => 'justify-content-start',
            'center' => 'justify-content-center',
            'end' => 'justify-content-end',
            'between' => 'justify-content-between',
        ][$align] ?? 'justify-content-end';

    $base = $stack ? 'd-grid gap-2' : "d-flex gap-2 $justify";
@endphp

<div {{ $attributes->merge(['class' => "form-actions $base"]) }}>
    {{ $slot }}
</div>
