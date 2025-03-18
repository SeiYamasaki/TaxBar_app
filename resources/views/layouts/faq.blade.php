<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>よくある質問 | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        /* 🌿 背景を鮮やかな緑のグラデーション */
        body {
            background: linear-gradient(135deg, #38ef7d, #11998e) !important;
            font-family: 'Arial', sans-serif !important;
            margin: 0 !important;
            padding: 0 !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            min-height: 100vh !important;
        }

        /* 📌 h1（タイトル）の最適化 */
        h1 {
            text-align: center !important;
            font-size: 1.8rem !important;
            /* PC向け: text-5xl相当 */
            font-weight: bold !important;
            margin: 20px 0 !important;
        }

        /* 📱 スマホ用のフォントサイズ調整 */
        @media (max-width: 768px) {
            h1 {
                font-size: 2rem !important;
                /* text-3xl相当 */
            }
        }

        /* ヘッダーの固定 */
        .header {
            width: 100% !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            background: black !important;
            color: white !important;
            padding: 15px 20px !important;
            text-align: center !important;
            z-index: 1000 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            box-sizing: border-box !important;
        }

        /* ヘッダーの下に余白を作成 */
        .header-space {
            height: 80px !important;
        }

        /* ロゴ */
        .logo img {
            height: 50px !important;
            width: auto !important;
        }

        /* ナビゲーションメニュー */
        .nav {
            display: flex !important;
        }

        .nav ul {
            display: flex !important;
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
            gap: 20px !important;
        }

        .nav ul li {
            text-align: center !important;
        }

        .nav ul li a {
            text-decoration: none !important;
            color: white !important;
            font-size: 16px !important;
            font-weight: bold !important;
            padding: 0.5rem !important;
            transition: color 0.3s !important;
        }

        .nav ul li a:hover {
            color: red !important;
            text-decoration: underline !important;
        }

        /* FAQ全体のコンテナ */
        .faq-wrapper {
            width: 100% !important;
            max-width: 1200px !important;
            background: white !important;
            padding: 30px !important;
            border-radius: 10px !important;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2) !important;
            text-align: center !important;
            margin-top: 120px !important;
        }

        /* FAQリスト */
        .faq-list {
            margin-top: 20px !important;
        }

        /* ✅ TaxMinutes 風ページネーション */
        .pagination-container {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            margin-top: 30px !important;
        }

        .pagination {
            display: flex !important;
            list-style: none !important;
            padding: 0 !important;
            margin: 0 auto !important;
            gap: 8px !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .pagination li {
            display: flex !important;
            align-items: center !important;
        }

        /* 通常のページ番号 */
        .pagination li a,
        .pagination li span {
            text-decoration: none !important;
            color: #4a4a4a !important;
            font-size: 16px !important;
            font-weight: bold !important;
            padding: 10px 15px !important;
            border-radius: 5px !important;
            transition: 0.3s !important;
        }

        .pagination li a:hover {
            color: white !important;
            background: #6c63ff !important;
        }

        /* 現在のページ */
        .pagination .active span {
            color: white !important;
            background: #6c63ff !important;
            padding: 10px 15px !important;
            border-radius: 5px !important;
        }

        /* ページネーションの矢印 */
        .pagination .prev a,
        .pagination .next a {
            font-size: 18px !important;
            color: #6c63ff !important;
            padding: 10px 15px !important;
            border-radius: 5px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .pagination .prev a:hover,
        .pagination .next a:hover {
            background: #6c63ff !important;
            color: white !important;
        }

        /* 📱 スマホ対応（最大幅 768px） */
        @media (max-width: 768px) {

            /* ヘッダーをコンパクトに */
            .header {
                flex-direction: column !important;
                padding: 10px !important;
                height: auto !important;
            }

            .header-space {
                height: 80px !important;
            }

            /* ナビゲーションメニューをハンバーガー化 */
            .nav {
                display: none !important;
                width: 100% !important;
                flex-direction: column !important;
                background: black !important;
                position: absolute !important;
                top: 100% !important;
                left: 0 !important;
                text-align: center !important;
                padding: 10px 0 !important;
            }

            .nav ul {
                flex-direction: column !important;
                gap: 10px !important;
            }

            .nav ul li {
                width: 100% !important;
            }

            .nav ul li a {
                font-size: 18px !important;
                display: block !important;
                padding: 10px !important;
            }

            /* ハンバーガーメニュー */
            .menu-toggle {
                display: block !important;
                font-size: 24px !important;
                color: white !important;
                cursor: pointer !important;
                padding: 10px !important;
                position: absolute !important;
                top: 15px !important;
                right: 20px !important;
            }

            /* FAQの幅を調整 */
            .faq-wrapper {
                max-width: 90% !important;
                padding: 15px !important;
            }

            /* ページネーションを小さく */
            .pagination-container {
                flex-direction: column !important;
                gap: 5px !important;
            }

            .pagination li a,
            .pagination li span {
                font-size: 14px !important;
                padding: 8px 10px !important;
            }
        }
    </style>
</head>

<body>
    @include('components.header')
    <div class="header-space"></div>
    <div class="faq-wrapper">
        @yield('content')
    </div>
    @livewireScripts
    <script src="{{ asset('js/app.js') }}"></script>
    @include('components.footer')
</body>

</html>
