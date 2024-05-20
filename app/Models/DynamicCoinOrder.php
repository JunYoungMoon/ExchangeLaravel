<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicCoinOrder extends Model
{
    protected $table;

    protected $primaryKey = 'od_idx';

    public $incrementing = true;

    const UPDATED_AT = null; // updated_at 비활성화
    const CREATED_AT = 'reg_date'; // create_at을 reg_date로 변경

    protected $fillable = [
        'user_idx',
        'od_type',
        'od_type2',
        'quantity',
        'price',
        'state',
        'state2',
        'state3',
        'reg_date',
        'complete_date',
        'commission',
        'real_price',
        'wallet_krw1',
        'wallet_krw2',
        'wallet_egx1',
        'wallet_egx2',
        'trade_type',
        'trade_useridx',
        'trade_odidx',
    ];

    public function setTableName($market, $coin)
    {
        $this->table = 'mg_coinorder_' . $market . '_' . $coin;
    }

    protected $casts = [
        'reg_date' => 'datetime',
    ];
}
