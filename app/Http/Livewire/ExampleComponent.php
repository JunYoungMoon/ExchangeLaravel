<?php
namespace App\Http\Livewire;

use Livewire\Component;

class ExampleComponent extends Component
{
    public $message = '';

    public function render()
    {
        return view('livewire.example-component');
    }
}
