<?php

namespace App\Livewire\exchange;

use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class Left extends Component
{
    public $code = 'KRW-EGX';
    public $coin = 'EGX';
    public $market = 'KRW';

    protected $queryString = ['code' => ['keep' => true]];

    #[On('emitCoinInfo')]
    #[Renderless] //이벤트를 렌더링이 필요없다.
    public function emitCoinInfo($market, $coin)
    {
        $this->code = $market . '-' . $coin;
        $this->coin = $coin;
        $this->market = $market;

        $this->dispatch('initializeChart', ['market' => $market, 'coin' => $coin]);
    }

    public function render()
    {
        return view('exchange.left');
    }

    public function buy($buy_price, $buy_qtt)
    {
        $test = 'a';

    }
}
