<?php

namespace App\Livewire\exchange;

use Livewire\Attributes\On;
use Livewire\Component;

class Left extends Component
{
    public $code = 'KRW-EGX';

    protected $queryString = ['code' => ['keep' => true]];

    public function mount()
    {
        // 최초 로드시 트레이딩뷰 차트 초기화
        $this->initializeTradingViewChart();
    }

    #[On('emitCoinInfo')]
    public function emitCoinInfo($market, $coin)
    {
        $this->code = $market . '-'. $coin;

        $this->initializeTradingViewChart();
    }

    protected function initializeTradingViewChart()
    {
        $symbol = explode('-', $this->code);

        // JavaScript로 symbol을 전달하여 트레이딩뷰 차트 초기화
        $this->dispatch('initializeChart', ['market' => $symbol[0], 'coin' => $symbol[1]]);
    }

    public function render()
    {
        return view('exchange.left');
    }
}
