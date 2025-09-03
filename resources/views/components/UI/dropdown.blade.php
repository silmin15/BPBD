@props(['id','align'=>'end'])
<div class="ui-dropdown" x-data="{open:false}">
  <button type="button" class="btn btn--secondary" @click="open=!open" aria-expanded="false" aria-controls="{{ $id }}">
    {{ $trigger ?? 'Menu' }}
  </button>

  <div id="{{ $id }}" class="ui-dropdown__menu {{ $align === 'start' ? 'start' : 'end' }}"
       x-show="open" @click.outside="open=false" @keydown.escape.window="open=false" x-transition>
    {{ $slot }}
  </div>
</div>
