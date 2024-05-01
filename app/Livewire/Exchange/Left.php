<?php

namespace App\Livewire\Exchange;

use App\Models\CryptocurrencySetting;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Livewire\Attributes\Url;
use Livewire\Component;

class Left extends Component
{
    #[Url]
    public $code = 'KRW-EGX';
    public $coin = 'EGX';
    public $market = 'KRW';
    public $settings;
    public $exchangeAddress;
    public $datafeedAddress;
    public $hogaAddress;

    protected $queryString = [
        'code' => ['keep' => true]
    ];

    public function mount()
    {
        $this->exchangeAddress = env('NODEJS_EXCHANGE_ADDRESS');
        $this->datafeedAddress = env('NODEJS_DATAFEED_ADDRESS');
        $this->hogaAddress = env('NODEJS_HOGA_ADDRESS');

        [$this->market, $this->coin] = explode('-', $this->code);

        $this->settingCoin();
    }

    public function settingCoin()
    {
        // ccs_market_name2가 'example_market'이고 ccs_coin_name2가 'example_coin'인 레코드 찾기
        $settings = CryptocurrencySetting::where('ccs_market_name2', $this->market)
            ->where('ccs_coin_name2', $this->coin)
            ->first();

//        $this->settings = $settings->toArray();
    }

    #[On('emitCoinInfo')]
    #[Renderless] //이벤트 렌더링이 필요없다.
    public function emitCoinInfo($market, $coin)
    {
        $this->code = $market . '-' . $coin;
        $this->coin = $coin;
        $this->market = $market;

        $this->settingCoin();

        $this->dispatch('initializeLeft', ['market' => $market, 'coin' => $coin]);
    }

    public function render()
    {
        return view('exchange.left');
    }
}
