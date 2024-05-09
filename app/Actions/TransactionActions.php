<?php

namespace App\Actions;

use Illuminate\Support\Facades\Validator;
use Lorisleiva\Actions\Concerns\AsAction;

class TransactionActions
{
    use AsAction;

    public function handle($params)
    {
        Validator::make(
            $params,
            [
                'price' => 'required|numeric|max:100000000',
                'quantity' => 'required|numeric|max:100000000',
                'type' => 'required|in:sell,buy'
            ],
            [
                'price.required' => '가격을 입력해주세요.',
                'price.numeric' => '가격은 숫자여야 합니다.',
                'price.max' => '가격은 :max 이하여야 합니다.',
                'quantity.required' => '수량을 입력해주세요.',
                'quantity.numeric' => '수량은 숫자여야 합니다.',
                'quantity.max' => '수량은 :max 이하여야 합니다.',
                'type.required' => '유형을 선택해주세요.',
                'type.in' => '유효하지 않은 유형입니다.'
            ]
        )->validate();
    }
}
