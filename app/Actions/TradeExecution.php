<?php

namespace App\Actions;

use App\DTO\TradeContext;
use App\Models\DynamicCoinOrder;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class TradeExecution
{
    use AsAction;

    /**
     * @throws \Exception
     */
    public function handle(TradeContext $tradeContext)
    {
        //동적 테이블 매핑
        $coinOrder = new DynamicCoinOrder();
        $coinOrder->setTableName(strtolower($tradeContext->request['market']), strtolower($tradeContext->request['coin']));

        $data = [
            'user_idx' => Auth::id(),
            'od_type' => $tradeContext->request['type'] === 'buy' ? '매수' : '매도',
            'od_type2' => $tradeContext->request['type'],
            'quantity' => $tradeContext->request['quantity'],
            'price' => $tradeContext->request['price'],
            'state' => '미체결',
            'state2' => 'out',
            'state3' => '',
            'commission' => sprintf('%.8f', $tradeContext->request['quantity'] * $tradeContext->request['price'] * $tradeContext->cryptocurrencySetting->ccs_commission_rate * 0.01),
            'real_price' => sprintf('%.8f', $tradeContext->request['quantity'] * $tradeContext->request['price']),
        ];

        $createdOrder = $coinOrder->create($data);

        if ($tradeContext->request['type'] === 'buy') {
            $symbolKey = strtolower($tradeContext->request['market']);
            $symbolUsing = $tradeContext->user->{$tradeContext->marketUsingAttribute};
            $symbolAvailable = $tradeContext->user->{$tradeContext->marketAvailableAttribute};
            $commission = sprintf('%.8f', $tradeContext->request['quantity'] * $tradeContext->request['price'] * $tradeContext->cryptocurrencySetting->ccs_commission_rate * 0.01);
            $amount = sprintf('%.8f', $tradeContext->request['quantity'] * $tradeContext->request['price'] + $commission);
        } else {
            $symbolKey = strtolower($tradeContext->request['coin']);
            $symbolUsing = $tradeContext->user->{$tradeContext->coinUsingAttribute};
            $symbolAvailable = $tradeContext->user->{$tradeContext->coinAvailableAttribute};
            $amount = $tradeContext->request['quantity'];
        }

        $data = [
            $symbolKey.'_using' => sprintf('%.8f', $symbolUsing + $amount),
            $symbolKey.'_available' => sprintf('%.8f', $symbolAvailable - $amount),
        ];

        DB::beginTransaction();

        try {
            User::where('id', Auth::id())->update($data);

            $client = new Client(new Version2X(env('NODEJS_EXCHANGE_ADDRESS')));

            $client->connect();

            $data = [
                'coin' => $tradeContext->request['coin'],
                'market' => $tradeContext->request['market'],
                'od_idx' => $createdOrder->od_idx
            ];

            $client->of("exchange");

            $response = $client->emit('order_updata', $data, true);

            if ($response['data']) {
                $client->disconnect();

                DB::commit();

                return 'success';
            } else {
                throw new \Exception();
            }
            // 트랜잭션 커밋
        } catch (\Exception $e) {
            // 예외 발생 시 롤백
            DB::rollback();

            return 'false';
        }
    }
}
