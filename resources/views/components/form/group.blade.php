@props(['label'=>null,'for'=>null,'hint'=>null,'inline'=>false,'class'=>''])
<div {{ $attributes->merge(['class'=>"form-group $class"]) }}>
  @if($label)
    <label class="form-label" @if($for) for="{{ $for }}" @endif>{{ $label }}</label>
  @endif
  {{ $slot }}
  @if($hint)<div class="form-hint">{{ $hint }}</div>@endif
  @error($for)<div class="form-error">{{ $message }}</div>@enderror
</div>
