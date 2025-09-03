<?php

namespace App\View\Components\UI;

use Illuminate\View\Component;

class Button extends Component
{
    public function __construct(
        public string $variant = 'primary',  // primary, secondary, danger, dll
        public string $size = 'md',          // sm, md, lg
        public bool $icon = false
    ) {}

    public function render()
    {
        return view('components.ui.button');
    }
}
