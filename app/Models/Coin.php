<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    use HasFactory;

    protected $primaryKey = ['coin_name', 'coin_type'];

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'coin_name',
        'coin_type',
        'logo',
        'trade_min_amount',
        'reg_date',
        'commition',
        'min_order',
        'min_hoga',
        'buy_able',
        'sell_able',
        'deposit_able',
        'withdraw_able',
        'withdraw_commition',
        'coin_no',
        'wallet',
        'qr_code',
    ];

    protected $casts = [
        'reg_date' => 'datetime',
    ];
}
