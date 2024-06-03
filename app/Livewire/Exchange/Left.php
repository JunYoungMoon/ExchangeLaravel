<?php

namespace App\Livewire\Exchange;

use App\Actions\CheckBalance;
use App\Actions\Test;
use App\Actions\TradeExecution;
use App\DTO\TradeContext;
use App\Http\Requests\Exchange\TransactionRequest;
use App\Models\CryptocurrencySetting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Livewire\Attributes\Url;
use Livewire\Component;
use Illuminate\Support\Facades\RateLimiter;

class Left extends Component
{
    #[Url(history: false, keep: true)]
    public $code = 'KRW-EGX';
    public $coin = '';
    public $market = '';
    public $coinInfo;
    public $originalCoins;
    public $exchangeAddress;
    public $datafeedAddress;
    public $hogaAddress;
    public $yesterdayPrice;
    public $lastPrice;

    public function mount($originalCoins, $exchangeAddress, $datafeedAddress, $hogaAddress)
    {
        $this->originalCoins = $originalCoins;
        $this->exchangeAddress = $exchangeAddress;
        $this->datafeedAddress = $datafeedAddress;
        $this->hogaAddress = $hogaAddress;

        [$this->market, $this->coin] = explode('-', $this->code);

        $this->settingCoinInfo();
        $this->getYesterdayAndLastPrice();
    }

    public function settingCoinInfo()
    {
        // ccs_market_name2가 'example_market'이고 ccs_coin_name2가 'example_coin'인 레코드 찾기
        $this->coinInfo = CryptocurrencySetting::with('detail')
            ->where('ccs_market_name2', $this->market)
            ->where('ccs_coin_name2', $this->coin)
            ->first()
            ->toArray();
    }

    public function getYesterdayAndLastPrice()
    {
        foreach ($this->originalCoins as $coin) {
            if(strtolower($this->coin) === $coin['coin_name'] && strtolower($this->market) === $coin['type_string']){
                $this->coinInfo['price']['yesterdayPrice'] = $coin['yesterday_price'];
                $this->coinInfo['price']['lastPrice'] = $coin['last_price'];
                $this->coinInfo['price']['percent'] = $coin['percent'];
                $this->coinInfo['price']['percent_string'] = $coin['percent_string'];
                $this->coinInfo['price']['percent_color_code'] = $coin['percent_color_code'];
                $this->coinInfo['price']['max_price'] = $coin['max_price'];
                $this->coinInfo['price']['min_price'] = $coin['min_price'];
                $this->coinInfo['price']['transaction_value'] = $coin['value'];

                break;
            }
        }
    }

    #[On('emitCoinInfo')]
    #[Renderless] //이벤트 렌더링이 필요없다.
    public function emitCoinInfo($market, $coin)
    {
        $this->code = $market . '-' . $coin;
        $this->coin = $coin;
        $this->market = $market;

        $this->settingCoinInfo();
        $this->getYesterdayAndLastPrice();

        $this->dispatch('initializeLeft', ['market' => $market, 'coin' => $coin]);
    }

    #[Renderless]
    public function transaction($price, $quantity, $type)
    {
        try {
            if (!Auth::check()) {
                throw new \Exception('로그인이 필요합니다.');
            }

            if (RateLimiter::tooManyAttempts('send-message:'.Auth::id(), 2)) {
                throw new \Exception('너무 많은 요청을 했습니다.');
            }

            RateLimiter::increment('send-message:'.Auth::id());

            $request['price'] = $price;
            $request['quantity'] = $quantity;
            $request['type'] = $type;
            $request['coin'] = $this->coin;
            $request['market'] = $this->market;

            Validator::make(
                $request,
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
                ['ccs_market_name2', $request['market']],
                ['ccs_coin_name2', $request['coin']]
            ])->first();

            $tradeContext = new TradeContext($request, $user, $cryptocurrencySetting);

            // 지갑이 없으면 에러
            if (!$tradeContext->user->{$tradeContext->coinWalletAttribute}) {
                throw new \Exception('지갑이 존재하지 않습니다.');
            }

            //잔액 체크
            CheckBalance::run($tradeContext);

            //체결
            if (TradeExecution::run($tradeContext) === 'success') {
                $this->dispatch('success', '체결 완료');
            }
        } catch (\Illuminate\Validation\ValidationException|\Exception $e) {
            // 다른 종류의 예외 처리
            $errorMessage = $e->getMessage();
            // 에러 메시지를 뷰로 보내기
            $this->dispatch('errorOccurred', $errorMessage);
        }
    }

    public function render()
    {
        return view('exchange.left');
    }
}
