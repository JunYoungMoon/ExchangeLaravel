<?php

namespace App\Livewire\exchange;

use App\Models\MemberCoinFavor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Right extends Component
{
    public $coins;
    public $userFavors;
    public $holdList;

    public function mount()
    {
        //redis코인정보 가져오기
        $response = Http::get('http://localhost:8193/coinInfo');
        $this->coins = collect($response->json());

        //관심,보유 코인 가져오기
        if (Auth::check()) {
            // 관심 코인 가져오기
            // 로그인한 사용자의 id를 가져온다.
            $userId = Auth::id();

            // 해당 사용자의 favor를 가져온다.
            $this->userFavors = MemberCoinFavor::where('user_id', $userId)->pluck('coin');

            // 보유 코인 가져오기
            // 해당하는 사용자를 찾는다.
            $user = User::find($userId);

            $uniqueCoins = [];

            foreach ($this->coins as $coin) {
                $coinName = strtolower($coin['coin_name']);

                // 해당 컬럼이 존재하고, 보유한게 있는지 체크한다.
                if (isset($user->{$coinName . '_available'}) && isset($user->{$coinName . '_using'}) &&
                    ($user->{$coinName . '_available'} > 0 || $user->{$coinName . '_using'} > 0)) {
                    // 중복이 없는 코인 이름을 배열에 추가한다.
                    if (!in_array($coinName, $uniqueCoins)) {
                        $uniqueCoins[] = $coinName;
                    }
                }
            }

            // 중복이 없는 코인 이름이 저장된 배열을 $this->hold_list에 할당한다.
            $this->holdList = collect($uniqueCoins);
        }

        $this->addCoinProperty();
        $this->updateView();
    }

    /**
     * 각 코인에 대한 추가 속성을 설정
     * - 가격 변동 백분율을 계산하고, 색상 코드를 지정
     * - 주요 화면에 표시되는 코인만을 대상
     */
    public function addCoinProperty()
    {
        $temp_coin = [];

        foreach ($this->coins as $coin) {
            if ($coin['ccs_view_main'] != 1) {
                continue; // 메인 뷰에 표시되는 코인만 처리
            }

            // 어제 가격을 기준으로 변동가 계산
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

            // 소수점 2자리로 변동률을 계산하고 필요한 정보를 배열에 추가
            $coin['percent'] = number_format($percent, 2);
            $coin['percent_string'] = $percent_string;
            $coin['percent_color_code'] = $percent_color_code;

            $temp_coin[] = $coin; // 처리된 코인을 임시 배열에 추가
        }

        $this->coins = $temp_coin;
    }

    public function updateView()
    {
        foreach ($this->coins as &$coin) {
            $isFavor = 'off';

            if (Auth::check()) {
                foreach ($this->userFavors as $favor) {
                    if (strtolower($favor) === strtolower($coin['type2'].'_'.$coin['type'])) {
                        $isFavor = 'on';
                    }
                }
            }

            $coin['is_favor'] = $isFavor;

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

            $coin['transaction_amount'] = $transactionAmount;

            $lastPrice = 0;

            if ($coin['last_price']) {
                $lastPrice = number_format($coin['last_price'], 4);
            }

            $coin['last_price_formatted'] = $lastPrice;
        }
    }

    public function render()
    {
        return view('exchange.right');
    }
}
