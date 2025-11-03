@extends('layouts.app')

@section('body-class', 'auth-page')

@section('title', '体重管理')

@section('css')
<link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/weight.css') }}">
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection

@section('content')
<!-- 体重情報ボックス -->
<div class="weight-card-wrapper">
    <div class="weight-card">
        <h3>目標体重</h3>
        <p class="weight-number">{{ $weightTarget?->target_weight ?? '-' }}kg</p>
    </div>
    <div class="weight-card">
        <h3>目標まで</h3>
        <p class="weight-number">
            @if($weightTarget && $currentWeight)
                {{ $weightTarget->target_weight - $currentWeight->weight }}kg
            @else
                -
            @endif
        </p>
    </div>
    <div class="weight-card">
        <h3>最新体重</h3>
        <p class="weight-number">{{ $currentWeight?->weight ?? '-' }}kg</p>
    </div>
</div>

<!-- 検索フォーム＋データ追加 -->
<section class="log-section">
    <div class="table-box">
        <!-- 検索フォーム -->
        <form method="GET" action="{{ route('weight_logs.index') }}" class="search-form-box">
            <div class="form-row">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="date-input">
                <span>〜</span>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="date-input">
                <button type="submit" class="btn search-btn">検索</button>
                @if(request('start_date') || request('end_date'))
                    <a href="{{ route('weight_logs.index') }}" class="btn gray-btn reset-btn">リセット</a>
                @endif
                <button type="button" id="openModalBtn" class="btn gradient-btn add-btn">データ追加</button>
            </div>
        </form>

        <!-- モーダル -->
        <div id="weightModal" class="modal">
            <div class="modal-content">
                <h2>Weight Logを追加</h2>

                <form action="{{ route('weight_logs.store') }}" method="POST" novalidate>
                    @csrf

                    <!-- 日付 -->
                    <div class="modal-row">
                        <label>日付 <span class="required-tag">必須</span></label>
                        <div class="date-wrapper">
                            <input type="text" name="date" id="modal-date" placeholder="年/月/日" class="date-input empty">
                            <span class="calendar-icon">&#128197;</span>
                        </div>
                        @error('date')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- 体重 -->
                    <div class="modal-row">
                        <label>体重 <span class="required-tag">必須</span></label>
                        <div class="input-group">
                            <input type="text" name="weight" value="{{ old('weight') }}" placeholder="50.0">
                            <span>kg</span>
                        </div>
                        @error('weight')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- 摂取カロリー -->
                    <div class="modal-row">
                        <label>摂取カロリー <span class="required-tag">必須</span></label>
                        <div class="input-group">
                            <input type="text" name="calories" value="{{ old('calories') }}" placeholder="1200">
                            <span>kcal</span>
                        </div>
                        @error('calories')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- 運動時間 -->
                    <div class="modal-row">
                        <label>運動時間 <span class="required-tag">必須</span></label>
                        <input type="text" name="exercise_time" placeholder="00:00" value="{{ old('exercise_time') }}">
                        @error('exercise_time')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- 運動内容 -->
                    <div class="modal-row">
                        <label>運動内容</label>
                        <textarea name="exercise_content" placeholder="運動内容を追加">{{ old('exercise_content') }}</textarea>
                        @error('exercise_content')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- ボタン -->
                    <div class="form-buttons">
                        <button type="button" id="closeModalBtn">戻る</button>
                        <button type="submit" class="btn gradient-btn">登録</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- 検索条件と件数をフォーム外に表示 --}}
        @if(request('start_date') || request('end_date'))
            <div class="selected-dates">
                {{ request('start_date') ?? '未指定' }} 〜 {{ request('end_date') ?? '未指定' }} の検索結果 {{ $weightLogs->total() }} 件
            </div>
        @endif

        <!-- 詳細ログ -->
        <table>
            <thead>
                <tr>
                    <th>日付</th>
                    <th>体重</th>
                    <th>食事摂取カロリー</th>
                    <th>運動時間</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($weightLogs as $log)
                    <tr>
                        <td>{{ $log->date->format('Y/m/d') }}</td>
                        <td>{{ $log->weight }}kg</td>
                        <td>{{ $log->calorie }}kcal</td>
                        <td>{{ $log->exercise }}分</td>
                        <td class="edit-btn-cell">
                            @if($log->id)
                                <a href="{{ route('weight_logs.edit', $log->id) }}" class="btn add-btn" title="編集">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-10 10A.5.5 0 0 1 4 14H1.5a.5.5 0 0 1-.5-.5V11a.5.5 0 0 1 .146-.354l10-10zM11.207 2L2 11.207V13h1.793L14 3.793 11.207 2z"/>
                                    </svg>
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">データがありません</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $weightLogs->links('pagination::bootstrap-4') }}
        </div>
    </div>
</section>

<!-- JSでモーダル・Flatpickr制御 -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const openBtn = document.getElementById('openModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const modal = document.getElementById('weightModal');
    const dateInput = document.getElementById('modal-date');
    const calendarIcon = dateInput.nextElementSibling;

    function updateDateInputColor() {
        if (dateInput.value) {
            dateInput.classList.add('filled');
            dateInput.classList.remove('empty');
        } else {
            dateInput.classList.add('empty');
            dateInput.classList.remove('filled');
        }
    }

    const fp = flatpickr(dateInput, {
        dateFormat: "Y/m/d",
        allowInput: true,
        appendTo: document.body,
        onChange: updateDateInputColor
    });

    updateDateInputColor();
    dateInput.addEventListener('input', updateDateInputColor);

    if (openBtn) openBtn.addEventListener('click', () => {
        modal.style.display = 'flex';
        fp.redraw();
    });
    if (closeBtn) closeBtn.addEventListener('click', () => modal.style.display = 'none');

    @if ($errors->any())
        modal.style.display = 'flex';
    @endif

    if (calendarIcon) {
        calendarIcon.addEventListener('click', () => fp.open());
    }
});
</script>
@endsection