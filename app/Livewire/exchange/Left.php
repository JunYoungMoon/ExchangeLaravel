<?php

namespace App\Livewire\exchange;

use Livewire\Attributes\On;
use Livewire\Component;

class Left extends Component
{
    public $code = 'AAPL';

    protected $queryString = ['code' => ['keep' => true]];

    public function mount()
    {
        // 최초 로드시 트레이딩뷰 차트 초기화
        $this->initializeTradingViewChart();
    }

    #[On('emitCoinInfo')]
    public function emitCoinInfo($market, $code)
    {
        $this->code = $code;

        $this->initializeTradingViewChart();
    }

    protected function initializeTradingViewChart()
    {
        $symbol = $this->code;
        // JavaScript로 symbol을 전달하여 트레이딩뷰 차트 초기화
        $this->dispatch('initializeChart', $symbol);
    }

    public function render()
    {
        return view('exchange.left');
    }
}
