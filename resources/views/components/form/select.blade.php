@props(['name','options'=>[],'placeholder'=>null,'value'=>null])
<select name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge(['class'=>"form-select ".($errors->has($name)?'is-invalid':'')]) }}>
  @if($placeholder)<option value="">{{ $placeholder }}</option>@endif
  @foreach($options as $val => $text)
    <option value="{{ $val }}" @selected(old($name, $value)==$val)>{{ $text }}</option>
  @endforeach
</select>
@error($name)<div class="form-error">{{ $message }}</div>@enderror
