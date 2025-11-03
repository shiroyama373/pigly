<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterStep2Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'initial_weight' => 'required|numeric',
            'target_weight' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'initial_weight.required' => '現在の体重を入力してください',
            'target_weight.required'  => '目標の体重を入力してください',
        ];
    }
}