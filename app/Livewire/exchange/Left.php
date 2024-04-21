<?php

namespace App\Livewire\exchange;

use App\Models\CryptocurrencySetting;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class Left extends Component
{
    public $code = 'KRW-EGX';
    public $coin = 'EGX';
    public $market = 'KRW';

    public $buy_price;
    public $buy_qtt;

    protected $queryString = ['code' => ['keep' => true]];

    public function mount(){
        // ccs_market_name2가 'example_market'이고 ccs_coin_name2가 'example_coin'인 레코드 찾기
        $settings = CryptocurrencySetting::where('ccs_market_name2', $this->market)
            ->where('ccs_coin_name2', $this->coin)
            ->get();

        $settings = $settings->toArray();
    }

    #[On('emitCoinInfo')]
    #[Renderless] //이벤트를 렌더링이 필요없다.
    public function emitCoinInfo($market, $coin)
    {
        $this->code = $market . '-' . $coin;
        $this->coin = $coin;
        $this->market = $market;

        // ccs_market_name2가 'example_market'이고 ccs_coin_name2가 'example_coin'인 레코드 찾기
        $settings = CryptocurrencySetting::where('ccs_market_name2', $this->market)
            ->where('ccs_coin_name2', $this->coin)
            ->get();

        //코인정보를 가져온다.

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
