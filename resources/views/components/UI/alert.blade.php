@props(['variant'=>'info','closable'=>true])

<div {{ $attributes->merge(['class'=>"ui-alert ui-alert--$variant"]) }}>
  <div class="ui-alert__content">
    {{ $slot }}
  </div>
  @if($closable)
    <button type="button" class="ui-alert__close" onclick="this.closest('.ui-alert').remove()">✕</button>
  @endif
</div>
