<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public function __construct(
        public string $id,
        public string $title
    ){}

    public function render()
    {
        return view('components.ui.modal');
    }
}
