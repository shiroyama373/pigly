@extends('layouts.app')

@section('body-class', 'auth-page')

@section('title', '目標体重変更')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
<link rel="stylesheet" href="{{ asset('css/weight_target_edit.css') }}">
@endsection

@section('content')
<div class="page-wrapper">
  <div class="weight-box">
    <h2>目標体重設定</h2>
    <form action="{{ route('weight_target.update') }}" method="POST">
      @csrf
      @method('PUT')

      <div class="input-group">
        <input type="text" id="target_weight" name="target_weight" placeholder="50" value="{{ old('target_weight', $target->target_weight) }}">
        <span class="unit">kg</span>
      </div>
      @error('target_weight')
        <div class="error-message">
          {{ $message }}
        </div>
      @enderror

      <div class="form-buttons">
        <a href="{{ route('weight_logs.index') }}" class="btn gray-btn">戻る</a>
        <button type="submit" class="btn gradient-btn">更新</button>
      </div>
    </form>
  </div>
</div>
@endsection