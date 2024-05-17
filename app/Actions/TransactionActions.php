<?php

namespace App\Actions;

use App\Models\CryptocurrencySetting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Lorisleiva\Actions\Concerns\AsAction;

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
                'price' => 'required|numeric|max:100000000',
                'quantity' => 'required|numeric|max:100000000',
                'type' => 'required|in:sell,buy',
                'coin' => 'required',
                'market' => 'required',
            ],
            [
                'price.required' => '가격을 입력해주세요.',
                'price.numeric' => '가격은 숫자여야 합니다.',
                'price.max' => '가격은 :max 이하여야 합니다.',
                'quantity.required' => '수량을 입력해주세요.',
                'quantity.numeric' => '수량은 숫자여야 합니다.',
                'quantity.max' => '수량은 :max 이하여야 합니다.',
                'type.required' => '유형을 선택해주세요.',
                'type.in' => '유효하지 않은 유형입니다.',
                'coin' => '코인 정보가 없습니다.',
                'market' => '마켓 정보가 없습니다.',
            ]
        )->validate();

        // 지갑 보유 체크
        $user = User::select(strtolower($params['coin']).'_wallet as wallet')->where('id',Auth::id())->first();
        $cryptocurrencySetting = CryptocurrencySetting::where([
                                                            ['ccs_market_name2', $params['market']],
                                                            ['ccs_coin_name2', $params['coin']]
                                                        ])->first();

        if (!$user->wallet) {
            throw new \Exception('지갑이 존재하지 않습니다.');
        }

        if ($params['type'] === 'buy') {
            if ($params['buy_qtt'] < $cryptocurrencySetting->ccs_min_exchange_amount) {
                throw new \Exception('최소 거래량 보다 적은 수를 입력하셨습니다.');
            } else if (($params['buy_price'] * 100000000) % ($cryptocurrencySetting->ccs_min_bid * 100000000) != 0) {
                throw new \Exception('호가 단위로 입력 해주세요.');
            } else if ($cryptocurrencySetting->ccs_exchange_buy == 0) {
                throw new \Exception('현재 접속량이 많아 서버가 원활하지 않습니다. 잠시만 기다려주세요');
            }

            // 보유량 체크필요
        } else {

        }



        // 지갑이 없으면 에러

        // 판매시, 구매시 구분해서 코인 보유량 체크
    }
}
