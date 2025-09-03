<?php

namespace App\View\Components\Form;
use Illuminate\View\Component;

class Input extends Component
{
    public function __construct(
        public string $name,
        public string $type = 'text',
        public ?string $value = null,
        public ?string $placeholder = null
    ){}
    public function render(){ return view('components.form.input'); }
}
