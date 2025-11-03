<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\WeightLogController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\WeightTargetController;


Route::get('/', function () {
    return redirect()->route('login'); // 未ログインはログイン画面へ
});

// ─── ゲスト専用ルート（未ログイン） ───
Route::middleware('guest')->group(function () {
    // ログイン
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // 新規会員登録 STEP1
    Route::get('/register/step1', [RegisterController::class, 'step1'])->name('register.step1');
    Route::post('/register/step1', [RegisterController::class, 'storeStep1']);
});

// ─── ログイン済みユーザー専用 ───
Route::middleware(['auth'])->group(function () {
    // ログアウト
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // 新規会員登録 STEP2
    Route::get('/register/step2', [RegisterController::class, 'step2'])->name('register.step2');
    Route::post('/register/step2', [RegisterController::class, 'storeStep2'])->name('register.step2.store');

    // 体重管理関連ルート（初期体重未登録ユーザーは STEP2 以外アクセス不可）
    Route::middleware('weight.notset')->group(function () {
        Route::get('/weight_logs', [WeightLogController::class, 'index'])->name('weight_logs.index');
        Route::get('/weight_logs/create', [WeightLogController::class, 'create'])->name('weight_logs.create');
        Route::post('/weight_logs', [WeightLogController::class, 'store'])->name('weight_logs.store');
        Route::get('/weight_logs/search', [WeightLogController::class, 'search'])->name('weight_logs.search');
        Route::get('/weight_logs/{weightLog}', [WeightLogController::class, 'show'])->name('weight_logs.show');
        Route::delete('/weight_logs/{weightLog}', [WeightLogController::class, 'destroy'])->name('weight_logs.destroy');
        Route::get('/weight_logs/goal_setting', [WeightLogController::class, 'goalSetting'])->name('weight_logs.goal_setting');
        Route::post('/weight_logs/goal_setting', [WeightLogController::class, 'saveGoal'])->name('weight_logs.save_goal');
    
         // ここに目標体重編集ルートを追加
        Route::get('/weight_target/edit', [WeightTargetController::class, 'edit'])->name('weight_target.edit');
        Route::put('/weight_target', [WeightTargetController::class, 'update'])->name('weight_target.update');

        // 編集ページ（フォーム表示）
Route::get('/weight_logs/{weightLog}/edit', [WeightLogController::class, 'edit'])->name('weight_logs.edit');

// 更新処理
Route::put('/weight_logs/{weightLog}', [WeightLogController::class, 'update'])->name('weight_logs.update');

    });
});