<?php

namespace App\Actions;

use App\Models\CryptocurrencySetting;
use App\Models\DynamicCoinOrder;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Lorisleiva\Actions\Concerns\AsAction;
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class TransactionActions
{
    use AsAction;

    /**
     * @throws \Exception
     */
    public function handle($params)
    {
        Validator::make(
            $params,
            [
                'price' => 'required|numeric|min:0.00000001|max:100000000',
                'quantity' => 'required|numeric|min:0.00000001|max:100000000',
                'type' => 'required|in:sell,buy',
                'coin' => 'required',
                'market' => 'required',
            ],
            [
                'price.required' => '가격을 입력해주세요.',
                'price.numeric' => '가격은 숫자여야 합니다.',
                'price.min' => '가격은 0보다 커야 합니다.',
                'price.max' => '가격은 :max 이하여야 합니다.',
                'quantity.required' => '수량을 입력해주세요.',
                'quantity.numeric' => '수량은 숫자여야 합니다.',
                'quantity.min' => '수량은 0보다 커야 합니다.',
                'quantity.max' => '수량은 :max 이하여야 합니다.',
                'type.required' => '유형을 선택해주세요.',
                'type.in' => '유효하지 않은 유형입니다.',
                'coin' => '코인 정보가 없습니다.',
                'market' => '마켓 정보가 없습니다.',
            ]
        )->validate();

        // 지갑 보유 체크
        $user = User::where('id',Auth::id())->first();

        $cryptocurrencySetting = CryptocurrencySetting::where([
                                                            ['ccs_market_name2', $params['market']],
                                                            ['ccs_coin_name2', $params['coin']]
                                                        ])->first();

        $coinWalletAttribute = strtolower($params['coin']) . '_wallet';
        $marketWalletAttribute = strtolower($params['market']) . '_wallet';
        $coinUsingAttribute = strtolower($params['coin']) . '_using';
        $marketUsingAttribute = strtolower($params['market']) . '_using';
        $coinAvailableAttribute = strtolower($params['coin']) . '_available';
        $marketAvailableAttribute = strtolower($params['market']) . '_available';

        // 지갑이 없으면 에러
        if (!$user->$coinWalletAttribute) {
            throw new \Exception('지갑이 존재하지 않습니다.');
        }

        if ($params['quantity'] < $cryptocurrencySetting->ccs_min_exchange_amount) {
            throw new \Exception('최소 거래량 보다 적은 수를 입력하셨습니다.');
        } else if (($params['price'] * 100000000) % ($cryptocurrencySetting->ccs_min_bid * 100000000) != 0) {
            throw new \Exception('호가 단위로 입력 해주세요.');
        } else if ($cryptocurrencySetting->ccs_exchange_buy == 0) {
            throw new \Exception('현재 접속량이 많아 서버가 원활하지 않습니다. 잠시만 기다려주세요');
        }

        if ($params['type'] === 'buy') {
            // 사용자 보유 잔액
            $userBalance = $user->$marketAvailableAttribute;

            // 구매 수량과 가격
            $buyQuantity = $params['quantity'];
            $buyPrice = $params['price'];

            // 수수료율
            $commissionRate = $cryptocurrencySetting->ccs_commission_rate * 0.01;

            // 총 구매 금액 (수수료 포함)
            $totalCost = $buyQuantity * $buyPrice * (1 + $commissionRate);

            // 소수점 이하 8자리까지 포맷팅
            $formattedTotalCost = sprintf('%.8f', $totalCost);

            // 보유량 체크
            if ($userBalance < $formattedTotalCost) {
                throw new \Exception('보유 잔액이 부족합니다.');
            }
        } else {
            if($user->$coinAvailableAttribute < $params['quantity']){
                throw new \Exception('보유량보다 큰 숫자를 입력하셨습니다.');
            }
        }

        //동적 테이블 매핑
        $coinOrder = new DynamicCoinOrder();
        $coinOrder->setTableName(strtolower($params['market']), strtolower($params['coin']));

        $data = [
            'user_idx' => Auth::id(),
            'od_type' => $params['type'] === 'buy' ? '매수' : '매도',
            'od_type2' => $params['type'],
            'quantity' => $params['quantity'],
            'price' => $params['price'],
            'state' => '미체결',
            'state2' => 'out',
            'state3' => '',
            'commission' => sprintf('%.8f', $params['quantity'] * $params['price'] * $cryptocurrencySetting->ccs_commission_rate * 0.01),
            'real_price' => sprintf('%.8f', $params['quantity'] * $params['price']),
        ];

        $createdOrder = $coinOrder->create($data);

//        $test = $createdOrder->od_idx;

        if ($params['type'] === 'buy') {
            $symbolKey = $params['market'];
            $symbolUsing = $user->$marketUsingAttribute;
            $symbolAvailable = $user->$marketAvailableAttribute;
            $commission = sprintf('%.8f', $params['quantity'] * $params['price'] * $cryptocurrencySetting->ccs_commission_rate * 0.01);
            $amount = sprintf('%.8f', $params['quantity'] * $params['price'] + $commission);
        } else {
            $symbolKey = $params['coin'];
            $symbolUsing = $user->$coinUsingAttribute;
            $symbolAvailable = $user->$coinAvailableAttribute;
            $amount = $params['quantity'];
        }

        $data = [
            $symbolKey.'_using' => sprintf('%.8f', $symbolUsing + $amount),
            $symbolKey.'_available' => sprintf('%.8f', $symbolAvailable - $amount),
        ];

        User::where('id', Auth::id())->update($data);

        //elephantio로 소켓연결 추가중
        $client = new Client(new Version2X());


    }
}
