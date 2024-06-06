<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Requests\Exchange\TradeRequest;

class ExchangeController extends Controller
{
    public function trade(TradeRequest $request)
    {
        $validated = $request->validated();


    }
}
