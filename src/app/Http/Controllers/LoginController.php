<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    /**
     * ログイン画面表示
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * ログイン処理
     */
    public function login(LoginRequest $request)
    {
        // バリデーション済みの入力値を取得
        $credentials = $request->validated();

        // 認証チェック
        if (Auth::attempt($credentials)) {
            // セッション再生成（セキュリティ対策）
            $request->session()->regenerate();

            // ログイン成功 → 体重管理画面に遷移
            return redirect()->route('weight_logs.index');
        }

        // 認証失敗 → ログイン画面に戻してエラー表示
        return back()->with('auth_error', 'メールアドレスまたはパスワードが違います。');
    }

    /**
     * ログアウト処理
     */
    public function logout(Request $request)
    {
        Auth::logout(); // ログアウト
        $request->session()->invalidate(); // セッション無効化
        $request->session()->regenerateToken(); // CSRFトークン再生成

        return redirect('/login'); // ログイン画面に戻す
    }
}