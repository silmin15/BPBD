<?php

namespace App\View\Components\UI;

use Illuminate\View\Component;

class Alert extends Component
{
    public function __construct(
        public string $variant = 'info', // info | success | warning | danger
        public bool $closable = true
    ){}
    public function render(){ return view('components.ui.alert'); }
}
