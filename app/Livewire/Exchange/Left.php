<?php

namespace App\Livewire\Exchange;

use App\Models\CryptocurrencySetting;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Livewire\Attributes\Url;
use Livewire\Component;

class Left extends Component
{
    #[Url(history: false, keep: true)]
    public $code = 'KRW-EGX';
    public $coin = '';
    public $market = '';
    public $coinInfo;
    public $exchangeAddress;
    public $datafeedAddress;
    public $hogaAddress;

    public function mount()
    {
        $this->exchangeAddress = env('NODEJS_EXCHANGE_ADDRESS');
        $this->datafeedAddress = env('NODEJS_DATAFEED_ADDRESS');
        $this->hogaAddress = env('NODEJS_HOGA_ADDRESS');

        [$this->market, $this->coin] = explode('-', $this->code);

        $this->settingCoinInfo();
    }

    public function settingCoinInfo()
    {
        // ccs_market_name2가 'example_market'이고 ccs_coin_name2가 'example_coin'인 레코드 찾기
        $this->coinInfo = CryptocurrencySetting::with('detail')
            ->where('ccs_market_name2', $this->market)
            ->where('ccs_coin_name2', $this->coin)
            ->first()
            ->toArray();
    }

    #[On('emitCoinInfo')]
    #[Renderless] //이벤트 렌더링이 필요없다.
    public function emitCoinInfo($market, $coin)
    {
        $this->code = $market . '-' . $coin;
        $this->coin = $coin;
        $this->market = $market;

        $this->settingCoinInfo();

        $this->dispatch('initializeLeft', ['market' => $market, 'coin' => $coin]);
    }

    public function render()
    {
        return view('exchange.left');
    }
}
