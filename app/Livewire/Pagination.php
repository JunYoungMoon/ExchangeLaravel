<?php

namespace App\Livewire;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class Pagination extends Component
{
    #[Reactive]
    public $page;
    #[Reactive]
    public $perPage;
    #[Reactive]
    public $total;

    public function mount($page, $perPage, $total)
    {
        $this->page = $page;
        $this->perPage = $perPage;
        $this->total = $total;
    }

    public function render()
    {
        $totalPage = ceil($this->total / $this->perPage);

        return view('livewire.pagination', [
            'totalPage' => $totalPage
        ]);
    }
}
