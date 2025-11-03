<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

        <!-- Google Fonts: Merriweather -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&display=swap" rel="stylesheet">
    
    <!-- 共通CSS -->
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- ページごとのCSS -->
    @yield('css')
</head>
<body class="@yield('body-class')">

    @unless(View::hasSection('no-header'))
    <!-- ヘッダー共通 -->
    <header class="header">
        <div class="logo">PiGLy</div>
        <div class="header-buttons">
            <!-- 目標体重設定ボタン -->
            <a href="{{ route('weight_target.edit') }}" class="btn gray-btn target-weight-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                    <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.892 3.433-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.892-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zM8 5.754a2.246 2.246 0 1 1 0 4.492 2.246 2.246 0 0 1 0-4.492z"/>
                </svg>
                目標体重設定
            </a>

            <!-- ログアウトボタン -->
            <form method="POST" action="{{ route('logout') }}" class="logout-btn">
                @csrf
                <button type="submit" class="btn gray-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 17l5-5-5-5v3H9v4h7v3z"/>
                        <path d="M4 4h10v2H4v12h10v2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    </svg>
                    ログアウト
                </button>
            </form>
        </div>
    </header>
    @endunless

    <!-- メインコンテンツ -->
    <main>
        @yield('content')
    </main>

    <!-- ページごとのJS -->
    @yield('scripts')
</body>
</html>