<?php

namespace App\Livewire;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class Pagination extends Component
{
    #[Reactive]
    public $page;
    public $perPage;
    public $total;
    public $totalPage;

    public function mount($page, $perPage, $total)
    {
        $this->page = $page;
        $this->perPage = $perPage;
        $this->total = $total;
    }

    public function render()
    {
        $this->totalPage = ceil($this->total / $this->perPage);

        return view('livewire.pagination');
    }
}
