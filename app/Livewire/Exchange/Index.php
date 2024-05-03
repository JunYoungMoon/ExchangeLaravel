<?php

namespace App\Livewire\Exchange;

use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    public $originalCoins;
    public $exchangeAddress;
    public $datafeedAddress;
    public $hogaAddress;

    public function mount(){
        $this->exchangeAddress = env('NODEJS_EXCHANGE_ADDRESS');
        $this->datafeedAddress = env('NODEJS_DATAFEED_ADDRESS');
        $this->hogaAddress = env('NODEJS_HOGA_ADDRESS');

        $this->originalCoins = $this->getCoinList();
        $this->originalCoins = $this->addCoinProperty();
    }

    /**
     * api를 통해 redis 코인정보를 가져옴
     */
    public function getCoinList()
    {
        //redis 코인정보 가져오기
        $response = Http::get($this->exchangeAddress . '/coinList');
        $this->originalCoins = collect($response->json());

        $filteredCoins = [];

        //메인 화면에 보여질 코인만 다룬다.
        foreach ($this->originalCoins as $coin) {
            if ($coin['ccs_view_main'] == 1) {
                $filteredCoins[] = $coin;
            }
        }
        return $filteredCoins;
    }

    /**
     * 각 코인에 대한 추가 속성을 설정
     * - 어제 가격을 기준으로 변동가 백분율을 계산 및 색상 코드 지정
     * - 거래대금 추가
     */
    public function addCoinProperty()
    {
        $temp_coin = [];

        foreach ($this->originalCoins as $coin) {
            // 어제 가격을 기준으로 변동가 백분율을 계산 및 색상 코드 지정
            $percent_price = $coin['last_price'] - $coin['yesterday_price'];

            if ($coin['yesterday_price'] != 0) {
                $percent = (($percent_price) / $coin['yesterday_price']) * 100;
                $percent_color_code = $percent_price < 0 ? 'blue' : 'red';
                $percent_string = $percent_price < 0 ? '-' : '+';
            } else {
                $percent = 0;
                $percent_color_code = 'black';
                $percent_string = '';
            }

            //거래대금 추가
            $transactionAmount = $coin['value'];

            if ($transactionAmount) {
                if ($transactionAmount > 1000000) {
                    $transactionAmount = intval($transactionAmount / 1000000) . '백만';
                } else {
                    $transactionAmount = intval($transactionAmount);
                }
            } else {
                $transactionAmount = '-';
            }

            $lastPrice = 0;

            if ($coin['last_price']) {
                $lastPrice = number_format($coin['last_price'], 4);
            }

            // 필요한 정보를 배열에 추가
            $coin['percent'] = number_format($percent, 2);
            $coin['percent_string'] = $percent_string;
            $coin['percent_color_code'] = $percent_color_code;
            $coin['transaction_amount'] = $transactionAmount;
            $coin['last_price_formatted'] = $lastPrice;

            $temp_coin[strtoupper($coin['type2'] . '_' . $coin['type'])] = $coin; // 처리된 코인을 임시 배열에 추가
        }
        return $temp_coin;
    }

    #[Layout('layouts.app2')]
    public function render()
    {
        return view('exchange.index', [
            'originalCoins' => $this->originalCoins,
            'exchangeAddress' => $this->exchangeAddress,
            'datafeedAddress' => $this->datafeedAddress,
            'hogaAddress' => $this->hogaAddress,
        ]);
    }
}
