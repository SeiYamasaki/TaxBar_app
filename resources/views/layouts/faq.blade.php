<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>よくある質問 | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @livewireStyles
    <style>
        /* 🌿 背景を鮮やかな緑のグラデーション */
        body {
            background: linear-gradient(135deg, #38ef7d, #11998e);
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* FAQ全体のコンテナ */
        .faq-wrapper {
            width: 100%;
            max-width: 1200px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        /* FAQリスト */
        .faq-list {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    @yield('header')
    <div class="faq-wrapper">
        @yield('content')
    </div>

    @livewireScripts
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
