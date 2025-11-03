@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/step1.css') }}">
@endsection

@section('no-header') @endsection
@section('body-class', 'gradient-page')

@section('content')
<div class="step1-form-box">
    <div class="logo">PiGLy</div>
    <div class="subtitle">新規会員登録</div> 
    <div class="step-title">STEP1 アカウント情報の登録</div>
    <form method="POST" action="{{ route('register.step1') }}">
        @csrf
        <div class="form-group">
            <label>お名前</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="お名前を入力">
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>メールアドレス</label>
            <input type="text" name="email" value="{{ old('email') }}" placeholder="メールアドレスを入力">
            @error('email')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>パスワード</label>
            <input type="password" name="password" placeholder="パスワードを入力">
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">次に進む</button>
    </form>
    <a href="{{ route('login') }}" class="link">ログインはこちら</a>
</div>
@endsection