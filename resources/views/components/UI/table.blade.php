@props(['striped' => false, 'hover' => true, 'compact' => false, 'caption' => null])

<div {{ $attributes->merge(['class' => 'table-card table-responsive']) }}>
    <table class="bpbd-table {{ $compact ? 'table--compact' : '' }}">
        @if($caption)
            <caption class="text-start px-3 py-2 text-slate-600">{{ $caption }}</caption>
        @endif

        {{ $slot }}
    </table>
</div>
