<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWeightTargetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 権限チェック: true にしておけば誰でも通る
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * バリデーションルール
     */
    public function rules(): array
    {
        return [
            'target_weight' => [
                'required',
                'numeric',
                'regex:/^\d{1,3}(\.\d)?$/', // 1〜3桁の整数、オプションで小数点1桁
                'max:999.9',
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * エラーメッセージ
     */
    public function messages(): array
    {
        return [
            'target_weight.required' => '目標の体重を入力してください',
            'target_weight.numeric'  => '4桁までの数字で入力してください',
            'target_weight.regex'    => '小数点は1桁で入力してください',
            'target_weight.max'      => '4桁までの数字で入力してください',
        ];
    }
}