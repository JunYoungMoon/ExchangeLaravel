<?php

namespace App\Actions;

use App\DTO\TradeContext;
use Lorisleiva\Actions\Concerns\AsAction;

class CheckBalance
{
    use AsAction;

    /**
     * @throws \Exception
     */
    public function handle(TradeContext $tradeContext)
    {
        if ($tradeContext->request['quantity'] < $tradeContext->cryptocurrencySetting->ccs_min_exchange_amount) {
            throw new \Exception('최소 거래량 보다 적은 수를 입력하셨습니다.');
        } else if (($tradeContext->request['price'] * 100000000) % ($tradeContext->cryptocurrencySetting->ccs_min_bid * 100000000) != 0) {
            throw new \Exception('호가 단위로 입력 해주세요.');
        } else if ($tradeContext->cryptocurrencySetting->ccs_exchange_buy == 0) {
            throw new \Exception('현재 접속량이 많아 서버가 원활하지 않습니다. 잠시만 기다려주세요');
        }

        if ($tradeContext->request['type'] === 'buy') {
            // 사용자 보유 잔액
            $userBalance = $tradeContext->user->{$tradeContext->marketAvailableAttribute};

            // 구매 수량과 가격
            $buyQuantity = $tradeContext->request['quantity'];
            $buyPrice = $tradeContext->request['price'];

            // 수수료율
            $commissionRate = $tradeContext->cryptocurrencySetting->ccs_commission_rate * 0.01;

            // 총 구매 금액 (수수료 포함)
            $totalCost = $buyQuantity * $buyPrice * (1 + $commissionRate);

            // 소수점 이하 8자리까지 포맷팅
            $formattedTotalCost = sprintf('%.8f', $totalCost);

            // 보유량 체크
            if ($userBalance < $formattedTotalCost) {
                throw new \Exception('보유 잔액이 부족합니다.');
            }
        } else {
            if($tradeContext->user->{$tradeContext->coinAvailableAttribute} < $tradeContext->request['quantity']){
                throw new \Exception('보유량보다 큰 숫자를 입력하셨습니다.');
            }
        }
    }
}
