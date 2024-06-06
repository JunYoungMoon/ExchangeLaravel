<?php

namespace App\Http\Requests\Exchange;

use Illuminate\Foundation\Http\FormRequest;

class TradeRequest extends FormRequest
{
    public function authorize(): bool
    {
        // 기본적으로 모든 인증된 사용자에게 요청 허용
        return true;

        // 추가 권한 검사 (필요시 사용)
        // return $this->user()->can('trade');
        // return $this->user()->isActive();
    }

    public function rules(): array
    {
        return [
            'price' => 'required|numeric|min:0.00000001|max:100000000',
            'quantity' => 'required|numeric|min:0.00000001|max:100000000',
            'type' => 'required|in:sell,buy',
            'coin' => 'required',
            'market' => 'required',
        ];
    }

    // 커스텀 에러 메시지 정의
    public function messages(): array
    {
        return [
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
            'coin.required' => '코인 정보를 입력해주세요.',
            'market.required' => '마켓 정보를 입력해주세요.',
        ];
    }
}
