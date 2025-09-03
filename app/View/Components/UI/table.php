<?php

namespace App\View\Components\UI;

use Illuminate\View\Component;

class Table extends Component
{
    public function __construct(
        public bool $striped = false,
        public bool $hover = true,
        public bool $compact = false,
        public ?string $caption = null
    ) {}

    public function render()
    {
        return view('components.ui.table');
    }
}
