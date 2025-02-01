<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'プラン一覧') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    <style>
        /* ✅ 画面全体の中央配置を保証 */
        body {
            background: linear-gradient(to right, #4f92ff, #0052cc, #002766);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ✅ メインコンテンツの中央配置 */
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
        }
    </style>

    @stack('styles')

    {{-- <!-- Bootstrap 5 -->登録フォームのデザイン --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- <!-- FontAwesome -->登録フォームのデザイン --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


</head>

<body>
    <div class="container">
        <!-- 💙 ヘッダーを削除し、独自のタイトルを表示 -->
        <div class="header">
            {{ config('app.name', 'プラン一覧') }}
        </div>

        <!-- 💙 メインコンテンツ -->
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    @stack('scripts')
</body>

</html>
