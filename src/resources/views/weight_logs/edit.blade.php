@extends('layouts.app')

@section('body-class', 'auth-page')

@section('title', '情報更新')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
<link rel="stylesheet" href="{{ asset('css/weight_edit.css') }}">
@endsection

@section('content')
<div class="page-wrapper">

    <!-- フォーム全体の白いボックス -->
    <form class="styled-form" action="{{ route('weight_logs.update', $weightLog->id) }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        <h2 class="form-title">Weight Logを更新</h2>

<div class="form-group date-group">
    <label for="date">日付</label>
    <div class="date-wrapper" style="position: relative;">
        <input type="text" id="date" name="date" 
               placeholder="年/月/日"
               value="{{ old('date', $weightLog->date ? $weightLog->date->format('Y-m-d') : \Carbon\Carbon::today()->format('Y-m-d')) }}">
        <span class="calendar-icon">&#128197;</span> <!-- 右側に表示 -->
    </div>
    @error('date')
        <span style="color:red; font-size:0.9rem">{{ $message }}</span>
    @enderror
</div>

<!-- flatpickr CSS & JS 読み込み -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
/* 日付入力の文字色 */
.date-input {
    color: #aaa; /* デフォルトは薄グレー */
}
.date-input.filled {
    color: #000; /* 入力済みは黒 */
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const dateInput = document.getElementById('date');

    // flatpickr 初期化
    flatpickr(dateInput, {
        dateFormat: "Y-m-d",
        defaultDate: dateInput.value || null,
        allowInput: true,
        onChange: function(selectedDates, dateStr) {
            updateDateColor();
        },
        onClear: function() {
            updateDateColor();
        }
    });

    // 文字色切り替え
    function updateDateColor() {
        if (dateInput.value) {
            dateInput.classList.add('filled');
        } else {
            dateInput.classList.remove('filled');
        }
    }

    // 初期状態
    updateDateColor();

    // 手入力時も色を変更
    dateInput.addEventListener('input', updateDateColor);
});
</script>

<div class="form-group input-with-unit">
    <label for="weight">体重</label>
    <div class="input-container">
        <input type="text" id="weight" name="weight" placeholder="50.0" value="{{ old('weight', $weightLog->weight ?? '') }}">
        <span class="unit">kg</span>
    </div>
    @error('weight')
        <span style="color:red; font-size:0.9rem">{{ $message }}</span>
    @enderror
</div>

<div class="form-group input-with-unit">
    <label for="calories">摂取カロリー</label>
    <div class="input-container">
        <input type="text" id="calories" name="calories" placeholder="1200" value="{{ old('calories', $weightLog->calories ?? '') }}">
        <span class="unit">kcal</span>
    </div>
    @error('calories')
        <span style="color:red; font-size:0.9rem">{{ $message }}</span>
    @enderror
</div>

        <!-- 運動時間 -->
        <div class="form-group">
            <label for="exercise_time">運動時間</label>
            <input type="text" id="exercise_time" name="exercise_time" placeholder="00:00" 
       value="{{ old('exercise_time', $weightLog->exercise_time ? \Carbon\Carbon::parse($weightLog->exercise_time)->format('H:i') : '') }}">
            @error('exercise_time')
                <span style="color:red">{{ $message }}</span>
            @enderror
        </div>

        <!-- 運動内容 -->
        <div class="form-group">
            <label for="exercise_content">運動内容</label>
            <textarea id="exercise_content" name="exercise_content" placeholder="運動内容を追加">{{ old('exercise_content', $weightLog->exercise_content ?? '') }}</textarea>
            @error('exercise_content')
                <span style="color:red">{{ $message }}</span>
            @enderror
        </div>

        <!-- ボタン横並び -->
        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:20px;">
            <!-- 中央部分:戻る＋更新 -->
            <div style="margin:auto; display:flex; gap:10px;">
                <a href="{{ route('weight_logs.index') }}" class="btn gray-btn">戻る</a>
                <button type="submit" class="btn gradient-btn">更新</button>
            </div>

            <!-- 右端: 削除 -->
            <button type="button" class="btn delete-btn" onclick="if(confirm('本当に削除しますか？')){ document.getElementById('delete-form').submit(); }">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
    </form>

    <!-- 削除フォーム -->
    <form id="delete-form" action="{{ route('weight_logs.destroy', $weightLog->id) }}" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection