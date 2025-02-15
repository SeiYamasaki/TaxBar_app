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
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        /* ヘッダーの固定 */
        .header {
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background: black;
            color: white;
            padding: 15px 0;
            text-align: center;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-sizing: border-box;
            padding-left: 20px;
            padding-right: 20px;
        }

        /* ヘッダーの下に余白を作成 */
        .header-space {
            height: 80px;
        }

        /* ロゴ */
        .logo img {
            height: 50px;
            width: auto;
        }

        /* ナビゲーションメニュー */
        .nav ul {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 20px;
        }

        .nav ul li {
            text-align: center;
        }

        .nav ul li a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            padding: 0.5rem;
            transition: color 0.3s;
        }

        .nav ul li a:hover {
            color: red;
            text-decoration: underline;
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
            margin-top: 100px;
        }

        /* FAQリスト */
        .faq-list {
            margin-top: 20px;
        }

        /* ✅ TaxMinutes 風ページネーション */
        .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
        }

        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0 auto;
            gap: 8px;
            align-items: center;
            justify-content: center;
        }

        .pagination li {
            display: flex;
            align-items: center;
        }

        /* 通常のページ番号 */
        .pagination li a,
        .pagination li span {
            text-decoration: none;
            color: #4a4a4a;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 5px;
            transition: 0.3s;
        }

        .pagination li a:hover {
            color: white;
            background: #6c63ff;
        }

        /* 現在のページ */
        .pagination .active span {
            color: white;
            background: #6c63ff;
            padding: 10px 15px;
            border-radius: 5px;
        }

        /* ページネーションの矢印 */
        .pagination .prev a,
        .pagination .next a {
            font-size: 18px;
            color: #6c63ff;
            padding: 10px 15px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pagination .prev a:hover,
        .pagination .next a:hover {
            background: #6c63ff;
            color: white;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="logo">
            <a href="/view/login">
                <img src="{{ asset('images/logo.png') }}" alt="ロゴ">
            </a>
        </div>
        <nav class="nav">
            <ul>
                <li><a href="/">HOME</a></li>
                <li><a href="/taxminivideos">Tax Minutes&reg</a></li>
                <li><a href="#TaxBarabout">テーマ</a></li>
                <li><a href="/view/prohibited">禁止事項</a></li>
                <li><a href="/inquiry">問合せ</a></li>
                <li><a href="/view/hachimantaishi">八幡平市</a></li>
                <li><a href="/pricing">料金表</a></li>
                <li><a href="/register/select">登録フォーム</a></li>
                <li><a href="/login">ログイン</a></li>
            </ul>
        </nav>
    </header>
    <div class="header-space"></div>
    <div class="faq-wrapper">
        @yield('content')
    </div>
    @livewireScripts
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
