@extends('layouts.app')

@section('title', '体重データ登録')

@section('css')
<link rel="stylesheet" href="{{ asset('css/weight.css') }}">
@endsection

@section('content')
<div class="form-overlay">
  <div class="form-box">
    <h2>Weight Logを追加</h2>

    <form action="{{ route('weight_logs.store') }}" method="POST">
      @csrf

      <div class="form-group required">
        <label for="date">日付</label>
        <input type="date" id="date" name="date" required>
      </div>

      <div class="form-group required">
        <label for="weight">体重（kg）</label>
        <input type="number" step="0.1" id="weight" name="weight" required>
      </div>

      <div class="form-group required">
        <label for="calorie">食事摂取カロリー（kcal）</label>
        <input type="number" id="calorie" name="calorie" required>
      </div>

      <div class="form-group required">
        <label for="exercise">運動時間（分）</label>
        <input type="number" id="exercise" name="exercise" required>
      </div>

      <div class="form-group">
        <label for="exercise_content">運動内容</label>
        <input type="text" id="exercise_content" name="exercise_content" placeholder="運動内容を追加">
      </div>

      <div class="form-buttons">
        <button type="button" class="btn gray-btn" onclick="history.back()">戻る</button>
        <button type="submit" class="btn gradient-btn">登録</button>
      </div>
    </form>
  </div>
</div>
@endsection