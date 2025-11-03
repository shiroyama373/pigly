@extends('layouts.app')

@section('title', '初期体重登録')

@section('css')
<link rel="stylesheet" href="{{ asset('css/step2.css') }}">
@endsection


@section('no-header') @endsection
@section('body-class', 'gradient-page')


@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="step2-container">

        <div class="logo">PiGLy</div>
        <div class="subtitle">新規会員登録</div>
        <div class="step-label">STEP2 体重データの入力</div>

        {{-- フォーム --}}
        <form method="POST" action="{{ route('register.step2.store') }}" novalidate>
            @csrf

            {{-- 現在の体重 --}}
            <div class="form-group">
                <label for="initial_weight">現在の体重</label>
                <div class="step2-input-wrapper">
                    <input type="number" step="0.1" name="initial_weight" id="initial_weight" value="{{ old('initial_weight') }}" placeholder="現在の体重を入力">
                    <span>kg</span>
                </div>
                @error('initial_weight')
                    <div class="step2-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- 目標体重 --}}
            <div class="form-group">
                <label for="target_weight">目標の体重</label>
                <div class="step2-input-wrapper">
                    <input type="number" step="0.1" name="target_weight" id="target_weight" value="{{ old('target_weight') }}" placeholder="目標の体重を入力">
                    <span>kg</span>
                </div>
                @error('target_weight')
                    <div class="step2-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- 登録ボタン --}}
            <button type="submit" class="step2-button">アカウントの作成</button>
        </form>

    </div>
</div>
@endsection