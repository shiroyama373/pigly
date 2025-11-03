@extends('layouts.app')

@section('title', 'ログイン')

@section('no-header') @endsection
@section('body-class', 'gradient-page')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login-box">
    <div class="logo">PiGLy</div>
    <div class="subtitle">ログイン</div>

    {{-- 🔻ここに追加します（認証エラー表示） --}}
    @if (session('auth_error'))
        <div class="auth-error-box">
            {{ session('auth_error') }}
        </div>
    @endif
    {{-- 🔺ここまで追加 --}}

    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        <!-- メールアドレス -->
        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレスを入力">
            
            <!-- バリデーションエラー -->
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- パスワード -->
        <div class="form-group">
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password" placeholder="パスワードを入力">
            
            <!-- バリデーションエラー -->
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-login">ログイン</button>
    </form>

    <a href="{{ route('register.step1') }}" class="link mt-3">アカウント作成はこちら</a>
</div>
@endsection