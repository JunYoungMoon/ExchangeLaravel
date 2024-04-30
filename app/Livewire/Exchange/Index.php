<?php

namespace App\Livewire\Exchange;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    #[Layout('layouts.app2')]
    public function render()
    {
        return view('exchange.index');
    }
}
