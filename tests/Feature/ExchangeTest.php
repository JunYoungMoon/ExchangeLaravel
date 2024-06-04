<?php


use App\Actions\CheckBalance;
use App\DTO\TradeContext;
use App\Models\CryptocurrencySetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExchangeTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // 필요한 데이터 생성
        $this->user = User::factory()->create();
        $this->cryptocurrencySetting = CryptocurrencySetting::factory()->create();

        // TradeContext 생성
        $this->tradeContext = new TradeContext([
            'price' => 100,
            'quantity' => 1,
            'type' => 'buy',
            'coin' => $this->cryptocurrencySetting->ccs_coin_name2,
            'market' => $this->cryptocurrencySetting->ccs_market_name2,
        ], $this->user, $this->cryptocurrencySetting);
    }

    public function test_handle_with_quantity_less_than_min_exchange_amount()
    {
        $this->tradeContext->request['quantity'] = 0.01;

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('최소 거래량 보다 적은 수를 입력하셨습니다.');

        (new CheckBalance())->handle($this->tradeContext);
    }

    public function test_handle_with_invalid_bid_price()
    {
        $this->tradeContext->request['price'] = 0.03;

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('호가 단위로 입력 해주세요.');

        (new CheckBalance())->handle($this->tradeContext);
    }

    public function test_handle_with_exchange_buy_disabled()
    {
        $this->cryptocurrencySetting->ccs_exchange_buy = 0;

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('현재 접속량이 많아 서버가 원활하지 않습니다. 잠시만 기다려주세요');

        (new CheckBalance())->handle($this->tradeContext);
    }

    public function test_handle_with_insufficient_balance_for_buy()
    {
        $this->user->krw_available = 0.01; // 사용자의 마켓 잔액 설정
        $this->user->save();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('보유 잔액이 부족합니다.');

        (new CheckBalance())->handle($this->tradeContext);
    }

    public function test_handle_with_insufficient_balance_for_sell()
    {
        $this->tradeContext->request['type'] = 'sell';
        $this->user->egx_available = 0.01; // 사용자의 코인 잔액 설정
        $this->user->save();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('보유량보다 큰 숫자를 입력하셨습니다.');

        (new CheckBalance())->handle($this->tradeContext);
    }

    public function test_handle_with_sufficient_balance()
    {
        $this->user->krw_available = 1000; // 사용자의 마켓 잔액 설정
        $this->user->egx_available = 1000; // 사용자의 코인 잔액 설정
        $this->user->save();

        (new CheckBalance())->handle($this->tradeContext);

        $this->assertTrue(true); // 예외가 발생하지 않음을 확인
    }
}
