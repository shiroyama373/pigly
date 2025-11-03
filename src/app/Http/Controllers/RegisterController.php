<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Actions\Fortify\CreateNewUser;
use App\Http\Requests\RegisterStep1Request;
use App\Http\Requests\RegisterStep2Request;
use App\Models\WeightLog;       // 追加
use App\Models\WeightTarget;    // 追加

class RegisterController extends Controller
{
    // Step1 フォーム表示
    public function step1()
    {
        return view('register.step1');
    }

    // Step1 フォーム送信（フォームリクエスト + Fortify）
    public function storeStep1(RegisterStep1Request $request, CreateNewUser $creator)
    {
        $data = $request->validated();
        $user = $creator->create($data);

        Auth::login($user);

        return redirect()->route('register.step2');
    }

    // Step2 フォーム表示
    public function step2()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('register.step1');
        }

        return view('register.step2', compact('user'));
    }

    // Step2 フォーム送信（初期体重登録）
    public function storeStep2(RegisterStep2Request $request)
    {
        $validated = $request->validated();

        $user = Auth::user();

        // 1️⃣ 初期体重を users テーブルに保存
        $user->weight_init = $validated['initial_weight'];
        $user->save();

        // 2️⃣ 目標体重を weight_targets テーブルに保存
       $user->weightTarget()->updateOrCreate(
    ['user_id' => $user->id],                    // 条件: user_id
    ['target_weight' => $validated['target_weight']] // 設定する値
); 

        // 3️⃣ 初期体重を weight_logs テーブルにも登録（当日のログとして）
        WeightLog::create([
            'user_id' => $user->id,
            'date' => now()->format('Y-m-d'),
            'weight' => $validated['initial_weight'],
            'calorie' => 0,   // 初期値
            'exercise' => 0,  // 初期値
        ]);

        return redirect()->route('weight_logs.index');
    }
}