<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TaxBar®️のトップページです。">
    <title>TaxBar®️ | HOME</title>
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
                <li><a href="/taxminivideos">Tax Minutes&reg</a></li>
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

    <!-- 背景動画 -->
    <div class="video-container">
        <video autoplay muted loop>
            <source src="{{ asset('videos/loginbackground.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <!-- Xタイムライン -->
    <div class="timeline-container">
        <div class="timeline-item">
            <h1 class="x1txt">~TaxBar&reg;からのお知らせ~</h1>
            <a class="twitter-timeline" data-width="500" data-height="700" data-tweet-limit="3"
                href="https://twitter.com/Python_SEI?ref_src=twsrc%5Etfw">
                Tweets by Python_SEI
            </a>
        </div>
        <div class="gif-container">
            <img src="{{ asset('images/robo1.gif') }}" alt="GIF2" class="gif-item">
        </div>

        <div class="timeline-item">
            <h1 class="x3txt">~リアルタイム配信~</h1>
            <a class="twitter-timeline" data-width="500" data-height="700" data-tweet-limit="3"
                href="https://twitter.com/Python_SEI?ref_src=twsrc%5Etfw">
                Tweets by Python_SEI
            </a>
        </div>
    </div>
    <!-- Xのウィジェット読み込みスクリプト -->
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

    <script>
        function reloadTwitterWidget() {
            let iframe = document.querySelector("iframe.twitter-timeline");
            if (iframe) {
                iframe.remove(); // 既存のタイムラインを削除
            }
            twttr.widgets.load(); // 再読み込み
        }

        // 30秒ごとに最新の投稿を取得（調整可能）
        setInterval(reloadTwitterWidget, 30000);
    </script>

    <div class="guest-container">
        <div class="guest-title">
            <h1 class="x2txt">☆今月のTaxBar&reg;イチオシのスペシャルゲスト☆</h1>
            <h1 class="x2txt">！！新設法人設立Bar 2025年2月2日 PM20時～21時 要予約！！</h1>
            <button class="guest-button">今すぐ予約する</button>
        </div>

        <div class="guest-list">
            <!-- 1人目のゲスト -->
            <div class="guest-item">
                <h2 class="x2txt">公認会計士◯◯◯◯</h2>
                <div class="image-preview">
                    <img src="{{ asset('images/guest_v1.jpg') }}" alt="ゲストの画像">
                </div>
                <!-- 📌 GIF をゲスト画像の下中央に配置（1つだけ） -->
                <div class="gif-container">
                    <img src="{{ asset('images/robo1.gif') }}" alt="GIF1" class="gif-item">
                </div>
            </div>

            <!-- 2人目のゲスト -->
            <div class="guest-item">
                <h2 class="x2txt">◯◯◯◯税理士</h2>
                <div class="image-preview">
                    <img src="{{ asset('images/guest_v2.jpg') }}" alt="ゲストの画像">
                </div>
                <!-- 📌 GIF をゲスト画像の下中央に配置（1つだけ） -->
                <div class="gif-container">
                    <img src="{{ asset('images/robo2.gif') }}" alt="GIF2" class="gif-item">
                </div>
            </div>
        </div>
    </div>

</body>

</html>
