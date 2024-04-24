<?php

namespace App\Livewire\exchange;

use App\Models\MemberCoinFavor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;
use Livewire\Component;

class Right extends Component
{
    public $originalCoins;
    public $copiedCoins;
    public $favors;
    public $holds;
    public $search;

    public function mount()
    {
        $this->getCoinList();
        $this->addCoinProperty();

        $this->copiedCoins = $this->originalCoins;

        $this->getHold();
        $this->getFavor();
    }

    public function getCoinList()
    {
        //redis 코인정보 가져오기
        $response = Http::get('http://localhost:8193/coinList');
        $this->originalCoins = collect($response->json());

        $filteredCoins = [];

        //메인 화면에 보여질 코인만 다룬다.
        foreach ($this->originalCoins as $coin) {
            if ($coin['ccs_view_main'] == 1) {
                $filteredCoins[] = $coin;
            }
        }

        $this->originalCoins = $filteredCoins;
    }

    public function getHold()
    {
        //보유 코인 가져오기
        if (Auth::check()) {
            $userId = Auth::id();

            $user = User::find($userId);

            $uniqueCoins = [];

            foreach ($this->copiedCoins as $coin) {
                $coinName = strtolower($coin['coin_name']);

                // 해당 컬럼이 존재하고, 보유한게 있는지 체크한다.
                if (isset($user->{$coinName . '_available'}) && isset($user->{$coinName . '_using'}) &&
                    ($user->{$coinName . '_available'} > 0 || $user->{$coinName . '_using'} > 0)) {
                    // 중복이 없는 코인 이름을 배열에 추가한다. (EGX, BOSS, ...)
                    if (!in_array($coinName, $uniqueCoins)) {
                        $uniqueCoins[] = $coinName;
                    }
                }
            }

            // 중복이 없는 코인 이름이 저장된 배열을 $this->hold_list에 할당한다.
            $this->holds = collect($uniqueCoins);
        }
    }

    public function getFavor(){
        //관심 코인 가져오기
        if (Auth::check()) {
            $userId = Auth::id();

            // 로그인한 사용자의 id로 관심 코인정보를 가져온다. (KRW_EGX, KRW_BOSS, ...)
            $this->favors = MemberCoinFavor::where('user_id', $userId)->pluck('coin')->map(function ($favor) {
                return strtolower($favor);
            });
        }
    }

    /**
     * 각 코인에 대한 추가 속성을 설정
     * - 어제 가격을 기준으로 변동가 백분율을 계산 및 색상 코드 지정
     * - 그인 사용자인 경우 좋아요 여부 체크
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

            $temp_coin[] = $coin; // 처리된 코인을 임시 배열에 추가
        }

        $this->originalCoins = $temp_coin;
    }

    #[On('changeTab')]
    public function changeTab($tab)
    {
        switch ($tab) {
            case 'KRW':
                //카피본 초기화
                $this->copiedCoins = $this->originalCoins;
                break;
            case 'HOLD':
                //원본 코인과 hold를 join하여 copied 덮어 씌우기
//                foreach ($this->originalCoins as $coin) {
//                    foreach ($this->holds as $hold) {
//                        if (strtolower($hold) === strtolower($coin['type'])) {
//                            $this->copiedCoins[] = $coin;
//                        }
//                    }
//                }

                $this->copiedCoins = $this->originalCoins;
                $this->getHold();

                $this->copiedCoins = collect($this->copiedCoins)->filter(function ($coin) {
                    return collect($this->holds)->contains(strtolower($coin['type']));
                })->all();

                break;
            case 'FAVOR':
                //원본 코인과 favors를 join하여 copied 덮어 씌우기
                $this->copiedCoins = $this->originalCoins;
                $this->getFavor();

                $this->copiedCoins = collect($this->copiedCoins)->filter(function ($coin) {
                    return collect($this->favors)->contains(strtolower($coin['type2'] . "_" . $coin['type']));
                })->all();

                break;
        }
    }

    public function updatedSearch(){
        $this->copiedCoins = collect($this->originalCoins)->filter(function ($coin) {
            // 검색어를 소문자로 변환하여 일치 여부를 검사
            $search = strtolower($this->search);

            // $coin['ccs_coin_name'] 또는 $coin['coin_name'] 중 하나라도 검색어를 포함하는지 확인
            return strpos(strtolower($coin['ccs_coin_name']), $search) !== false ||
                strpos(strtolower($coin['coin_name']), $search) !== false;
        })->all();
    }

    public function render()
    {
        foreach ($this->copiedCoins as &$coin) {
            // 현재 코인이 사용자의 관심 코인 목록에 있는지 확인
            $coin['is_favor'] = $this->favors->contains(strtolower($coin['type2'] . '_' . $coin['type'])) ? 'on' : 'off';
        }

        return view('exchange.right');
    }
}
