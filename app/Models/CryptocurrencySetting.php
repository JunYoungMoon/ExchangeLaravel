<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptocurrencySetting extends Model
{
    use HasFactory;

    protected $table = 'mg_cryptocurrency_setting';

    protected $primaryKey = 'ccs_id';

    const UPDATED_AT = null; // updated_at 비활성화
    const CREATED_AT = null; // create_at 비활성화

    protected $fillable = [
        'ccs_market_name',
        'ccs_market_name2',
        'ccs_coin_name',
        'ccs_coin_english',
        'ccs_coin_chinese',
        'ccs_coin_name2',
        'ccs_coin_img',
        'ccs_min_exchange_amount',
        'ccs_min_buy_price',
        'ccs_min_bid',
        'ccs_deposit_min_amount',
        'ccs_withdraw_min_amount',
        'ccs_withdraw_commission',
        'ccs_exchange_buy',
        'ccs_exchange_sell',
        'ccs_deposit',
        'ccs_withdraw',
        'ccs_commission_rate',
        'ccs_order',
        'ccs_link',
        'ccs_view_main',
        'ccs_view_exchange',
        'ccs_view_wallet',
        'ccs_lv1_value',
        'ccs_lv2_value',
        'ccs_lv3_value',
        'ccs_lv4_value',
        'ccs_lv5_value',
        'inAddress',
        'contractAddress',
        'iserc20',
        'category',
    ];

    protected $casts = [
        'ccs_exchange_buy' => 'boolean',
        'ccs_exchange_sell' => 'boolean',
        'ccs_deposit' => 'boolean',
        'ccs_withdraw' => 'boolean',
        'ccs_view_main' => 'boolean',
        'ccs_view_exchange' => 'boolean',
        'ccs_view_wallet' => 'boolean',
        'iserc20' => 'boolean',
    ];

    public function detail()
    {
        return $this->hasOne(CryptocurrencySettingDetail::class, 'ccs_id', 'ccs_id');
    }
}
