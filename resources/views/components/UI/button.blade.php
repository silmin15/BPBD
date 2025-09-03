@props([
    'variant' => 'primary', // default: primary (oranye)
    'size' => 'md', // default: medium
    'type' => 'button',
])

<button type="{{ $type }}" {{ $attributes->merge([
    'class' => "btn btn--$variant btn--$size",
]) }}>
    {{ $slot }}
</button>
