<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\WeightTarget;
use App\Http\Requests\UpdateWeightTargetRequest;

class WeightTargetController extends Controller
{
    /**
     * 編集フォーム表示
     */
    public function edit()
    {
        $user = Auth::user();
        $target = WeightTarget::firstOrCreate(['user_id' => $user->id]);

        return view('weight_target.edit', compact('target'));
    }

    /**
     * 更新処理
     */
    public function update(UpdateWeightTargetRequest $request)
    {
        $user = Auth::user();
        $target = WeightTarget::firstOrCreate(['user_id' => $user->id]);

        $target->target_weight = $request->target_weight;
        $target->save();

        return redirect()->route('weight_logs.index')
                         ->with('success', '目標体重を更新しました');
    }
}