<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TaxBar®️は八幡平市から始まりました｡">
    <title>TaxBar®️</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <!-- ヘッダー -->
    <header class="header">
        <!-- ロゴ -->
        <div class="logo">
            <a href="#">
                <img src="{{ asset('images/logo.png') }}" alt="ロゴ">
            </a>
        </div>
        <!-- ナビゲーション -->
        <nav class="nav">
            <ul>
                <li><a href="/">HOME</a></li>
                <li><a href="#TaxMinutes">Tax Minutes&reg</a></li>
                <li><a href="#TaxBarabout">テーマ</a></li>
                <li><a href="/view/prohibited">禁止事項</a></li>
                <li><a href="/inquiry">問合せ</a></li>
                {{-- <li><a href="/view/hachimantaishi">八幡平市</a></li> --}}
                <li><a href="/faq">よくある質問</a></li>
                <li><a href="/pricing">料金表</a></li>
                <li><a href="#Reji">登録フォーム</a></li>
                <li><a href="/login">ログイン</a></li>
            </ul>
        </nav>
    </header>

    <!-- 背景動画 -->
    <div class="video-container">
        <video autoplay muted loop poster="{{ asset('images/fallback.jpg') }}">
            <source src="{{ asset('videos/hachimantai_v6.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <!-- 動画の下のコンテンツ -->
    <div class="content">
        <h1 class="txt1">八幡平市初動｡</h1>
        <p class="txt2">そこには物語があります｡</p>
    </div>
