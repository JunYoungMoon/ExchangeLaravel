<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CryptocurrencySettingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ccs_market_name' => 'KRW',
            'ccs_coin_name' => 'EGX',
            'ccs_market_name2' => 'KRW',
            'ccs_coin_name2' => 'EGX',
            'ccs_coin_img' => 'aaa',
            'ccs_min_exchange_amount' => 0.1, // null이 아닌 적절한 값으로 설정
            'ccs_min_buy_price' => 0.1, // null이 아닌 적절한 값으로 설정
            'ccs_min_bid' => 0.1, // null이 아닌 적절한 값으로 설정
            'ccs_deposit_min_amount' => 0.1, // null이 아닌 적절한 값으로 설정
            'ccs_withdraw_min_amount' => 0.1, // null이 아닌 적절한 값으로 설정
            'ccs_withdraw_commission' => 0.1, // null이 아닌 적절한 값으로 설정
            'ccs_exchange_buy' => 1,
            'ccs_exchange_sell' => 1,
            'ccs_deposit' => 1,
            'ccs_withdraw' => 1,
            'ccs_commission_rate' => 0.1, // null이 아닌 적절한 값으로 설정
            'ccs_order' => 1,
            'ccs_link' => 'example.com',
            'ccs_view_main' => 1,
            'ccs_view_exchange' => 1,
            'ccs_view_wallet' => 1,
            'ccs_lv1_value' => 0.1, // null이 아닌 적절한 값으로 설정
            'ccs_lv2_value' => 0.1, // null이 아닌 적절한 값으로 설정
            'ccs_lv3_value' => 0.1, // null이 아닌 적절한 값으로 설정
            'ccs_lv4_value' => 0.1, // null이 아닌 적절한 값으로 설정
            'ccs_lv5_value' => 0.1, // null이 아닌 적절한 값으로 설정
            'inAddress' => 'address',
            'contractAddress' => 'contract address',
            'iserc20' => 1,
            'category' => 'category',
        ];
    }
}
