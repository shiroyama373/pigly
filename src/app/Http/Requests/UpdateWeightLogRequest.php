<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWeightLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'weight' => [
                'required',
                'numeric',                      // 数字であるか
                'max:9999',                      // 4桁以内
                'regex:/^\d{1,3}(\.\d{1})?$/',  // 小数点1桁
            ],
            'calories' => 'required|numeric',
            'exercise_time' => 'required|regex:/^\d{1,2}:\d{2}$/', // 00:00形式
            'exercise_content' => 'nullable|string|max:120',
        ];
    }

    public function messages(): array
    {
        return [
            'date.required' => '日付を入力してください',
            'weight.required' => '体重を入力してください',
            'weight.numeric' => '数字で入力してください',
            'weight.max' => '4桁までの数字で入力してください',
            'weight.regex' => '小数点は1桁で入力してください',
            'calories.required' => '摂取カロリーを入力してください',
            'calories.numeric' => '数字で入力してください',
            'exercise_time.required' => '運動時間を入力してください',
            'exercise_time.regex' => '00:00形式で入力してください',
            'exercise_content.max' => '120文字以内で入力してください',
        ];
    }
}