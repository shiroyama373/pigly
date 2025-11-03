<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWeightRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'target_weight' => [
                'required', 
                'regex:/^\d{1,3}(\.\d)?$/', // 3桁まで + 小数点1桁
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'target_weight.required' => '目標の体重を入力してください',
            'target_weight.regex'    => '4桁までの数字で入力してください',
        ];
    }
}