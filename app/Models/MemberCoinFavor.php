<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberCoinFavor extends Model
{
    use HasFactory;

    protected $table = 'member_coin_favors';

    protected $fillable = [
        'user_id',
        'symbol'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
