@props(['name','type'=>'text','value'=>null,'placeholder'=>null])
<input
  type="{{ $type }}"
  name="{{ $name }}"
  id="{{ $name }}"
  value="{{ old($name, $value) }}"
  placeholder="{{ $placeholder }}"
  {{ $attributes->merge(['class'=>"form-control ".($errors->has($name)?'is-invalid':'')]) }}
/>
