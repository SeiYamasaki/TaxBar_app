@extends('layouts.faq')

@section('header')
    <header class="header">
        <div class="logo">
            <a href="/view/login">
                <img src="{{ asset('images/logo.png') }}" alt="ロゴ">
            </a>
        </div>
        <nav class="nav">
            <ul>
                <li><a href="/">HOME</a></li>
                <li><a href="#TaxBarabout">テーマ</a></li>
                <li><a href="/view/prohibited">禁止事項</a></li>
                <li><a href="/inquiry">問合せ</a></li>
                <li><a href="/view/hachimantaishi">八幡平市</a></li>
                <li><a href="/faq">よくある質問</a></li>
                <li><a href="/pricing">料金表</a></li>
                <li><a href="/register/select">登録フォーム</a></li>
                <li><a href="/login">ログイン</a></li>
            </ul>
        </nav>
    </header>
@endsection

@section('content')
    <div class="faq-header">
        <h1 class="py-10 text-gray-800 text-5xl font-bold">📌 TaxBar&regFAQ</h1>
        <p class="pb-10 text-gray-800 text-2xl">TaxBar&regに寄せられた質問を記載しています｡</p>

    </div>

    <!-- 検索フォーム -->
    <div class="search-container">
        <form method="GET" action="{{ route('faqs.index') }}" class="search-form">
            <input type="text" name="search" class="search-input" placeholder="🔍 キーワードで検索"
                value="{{ request('search') }}">
            <button type="submit" class="search-button">検索</button>
        </form>
    </div>

    <!-- FAQリスト -->
    <div class="faq-list">
        @forelse ($faqs as $index => $faq)
            <div class="faq-card {{ $index % 2 == 0 ? 'question-row' : 'answer-row' }}">
                <h5 class="faq-question">{{ $faq->question }}</h5>
                <p class="faq-answer">{{ $faq->answer }}</p>
            </div>
        @empty
            <div class="faq-no-result">
                🚫 検索結果が見つかりませんでした。
            </div>
        @endforelse
    </div>

    <!-- ページネーション -->
    <div class="pagination-container">
        @if ($faqs->hasPages())
            {{ $faqs->links('pagination::bootstrap-4') }}
        @endif
    </div>

    <style>
        /* ヘッダー全体 */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 65px;
            background: black;
            z-index: 10;
            display: flex;
            align-items: center;
            /* 垂直方向の中央揃え */
            justify-content: center;
            /* 水平方向の中央揃え */
            padding: 0;
            box-sizing: border-box;
        }

        /* ロゴ */
        .logo {
            position: absolute;
            left: 20px;
            /* 左端に配置 */
        }

        .logo img {
            height: 50px;
            width: auto;
        }

        /* ナビゲーションメニュー */
        .nav {
            flex: 1;
            display: flex;
            justify-content: center;
            /* 均等配置の基準 */
        }

        .nav ul {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 40px;
            /* メニュー間のスペースを調整 */
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

        /* FAQ全体 */
        .faq-list {
            text-align: left;
            /* ✅ 左寄せ */
        }

        /* FAQ全体のコンテナ */
        .faq-wrapper {
            width: 100%;
            max-width: 1600px;
            background: white;
            padding: 100px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            margin-top: 20px;
        }

        /* FAQリスト */
        .faq-list {
            margin-top: 60px;
        }

        /* FAQ項目のカード */
        .faq-card {
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
            transition: 0.3s;
            text-align: left;
            /* ✅ 左寄せ */
        }

        .faq-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        /* 質問の背景色（淡い緑） */
        .question-row {
            background: #d4f8e8;
        }

        /* 回答の背景色（淡い青） */
        .answer-row {
            background: #e3f2fd;
        }

        /* 質問のスタイル */
        .faq-question {
            font-size: 1.5rem;
            font-weight: bold;
            color: #2c786c;
            margin-bottom: 5px;
        }

        /* 回答のスタイル */
        .faq-answer {
            color: #333;
            font-size: 1.5rem;
        }

        /* 検索フォームの左寄せ */
        .search-container {
            text-align: left;
            /* ✅ 左寄せ */
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        /* 検索ボックス */
        .search-form {
            display: flex;
            background: white;
            border-radius: 25px;
            padding: 5px 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
        }

        .search-input {
            border: none;
            padding: 10px;
            flex: 1;
            border-radius: 20px;
            outline: none;
        }

        .search-button {
            background: blue;
            border: none;
            padding: 10px 15px;
            border-radius: 20px;
            color: white;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .search-button:hover {
            background: #ff4f7b;
        }

        /* ページネーションのスタイル */
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
            gap: 10px;
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
            font-size: 14px;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 5px;
            border: 1px solid #6c63ff;
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
            padding: 8px 12px;
            border-radius: 5px;
            border: 1px solid #6c63ff;
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
@endsection
