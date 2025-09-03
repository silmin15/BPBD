<?php

namespace App\View\Components\Form;
use Illuminate\View\Component;

class Group extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?string $for = null,
        public ?string $hint = null,
        public bool $inline = false,
        public string $class = ''
    ){}
    public function render(){ return view('components.form.group'); }
}
