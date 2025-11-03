<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use Carbon\Carbon;
use App\Http\Requests\UpdateWeightLogRequest;



class WeightLogController extends Controller
{
    // 体重ログ一覧
    public function index(Request $request)
    {
        $user = Auth::user();

        // 初期体重未登録の場合は STEP2 へリダイレクト
        if (is_null($user->weight_init)) {
            return redirect()->route('register.step2');
        }

        // 目標体重取得
        $weightTarget = WeightTarget::where('user_id', $user->id)->first();

        // 最新体重取得
        $currentWeight = WeightLog::where('user_id', $user->id)->latest('date')->first();

        // クエリビルダーで日付絞り込み
        $query = WeightLog::where('user_id', $user->id);

        if ($request->start_date) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        // 取得（ページネーション 8 件、検索条件保持）
        $weightLogs = $query->orderBy('date', 'desc')->paginate(8)->withQueryString();

        return view('weight_logs.index', compact('weightTarget', 'currentWeight', 'weightLogs'));
    }

    // 新規登録フォーム表示
    public function create()
    {
        return view('weight_logs.create');
    }

    // 新規登録保存（WeightLogRequest を使用）
    public function store(UpdateWeightLogRequest $request)
    {
    $validated = $request->validated();
    $user = Auth::user();

    // 運動時間を hh:mm → 分に変換
    $exerciseMinutes = null;
    if (!empty($validated['exercise_time'])) {
        [$hours, $minutes] = explode(':', $validated['exercise_time']);
        $exerciseMinutes = ((int)$hours) * 60 + ((int)$minutes);
    }

    WeightLog::create([
        'user_id' => $user->id,
        'date' => $validated['date'],
        'weight' => $validated['weight'],
        'calorie' => $validated['calories'] ?? null,
        'exercise' => $exerciseMinutes,           // 分単位で保存
        'exercise_time' => $validated['exercise_time'] ?? null, // 元の hh:mm も保存したい場合
        'exercise_content' => $validated['exercise_content'] ?? null,
    ]);

    return redirect()->route('weight_logs.index')
                     ->with('success', '体重データを登録しました。');
}

    // 個別体重詳細
    public function show($weightLogId)
    {
        $weightLog = WeightLog::findOrFail($weightLogId);
        return view('weight_logs.show', compact('weightLog'));
    }

    // 編集フォーム表示
    // 編集フォーム
public function edit(WeightLog $weightLog)
{
    return view('weight_logs.edit', compact('weightLog'));
}
    // 更新処理（WeightLogRequest でも可、必要に応じて）
public function update(UpdateWeightLogRequest $request, WeightLog $weightLog)
{
    $validated = $request->validated();

    $weightLog->update([
        'date' => $validated['date'],
        'weight' => $validated['weight'],
        'calories' => $validated['calories'] ?? null, // ← カラム名修正
        'exercise_time' => $validated['exercise_time'] ?? null,
        'exercise_content' => $validated['exercise_content'] ?? null,
    ]);

    return redirect()->route('weight_logs.index')
                     ->with('success', '体重情報を更新しました');
}

    // 削除処理
    public function destroy($weightLogId)
    {
        $weightLog = WeightLog::findOrFail($weightLogId);
        $weightLog->delete();

        return redirect()->route('weight_logs.index')
                         ->with('success', '体重情報を削除しました');
    }

    // 目標設定フォーム
    public function goalSetting()
    {
        return view('weight_logs.goal_setting');
    }
}