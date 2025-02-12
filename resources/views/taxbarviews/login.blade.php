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
    <div class="gif-container">
        <img src="{{ asset('images/robo1.gif') }}" alt="GIF2" class="gif-item">
    </div>
    <div class="guest-container">
        <div class="guest-title">
            <h1 class="x2txt">☆今月のTaxBar&reg;イチオシのスペシャルゲスト☆</h1>
            <h1 class="x2txt">！！新設法人設立Bar 2025年2月2日 PM20時～21時 要予約！！</h1>
            <button class="guest-button">今すぐ予約する</button>
        </div>

        <div class="guest-list">
            <!-- 1人目のゲスト -->
            <div class="guest-item">
                <h2 class="x2txt">酒井雄介税理士事務所</h2>
                <div class="image-preview">
                    <img src="{{ asset('images/guest_v5.png') }}" alt="ゲストの画像">
                </div>
                <!-- 📌 GIF をゲスト画像の下中央に配置（1つだけ） -->
                <div class="gif-container">
                    <img src="{{ asset('images/robo1.gif') }}" alt="GIF1" class="gif-item">
                </div>
            </div>

            <!-- 2人目のゲスト -->
            <div class="guest-item">
                <h2 class="x2txt">公認会計士税理士 酒井雄介</h2>
                <div class="image-preview">
                    <img src="{{ asset('images/guest_v6.png') }}" alt="ゲストの画像">
                </div>
                <!-- 📌 GIF をゲスト画像の下中央に配置（1つだけ） -->
                <div class="gif-container">
                    <img src="{{ asset('images/robo2.gif') }}" alt="GIF2" class="gif-item">
                </div>
            </div>
        </div>
    </div>
    <div class="guest-container">
        <div class="guest-title">
            <h1 class="x2txt">☆今月のTaxBar&reg;イチオシのスペシャルゲスト☆</h1>
            <h1 class="x2txt">！！資金調達Bar 2025年2月2日 PM20時～21時 要予約！！</h1>
            <button class="guest-button">今すぐ予約する</button>
        </div>

        <div class="guest-list">
            <!-- 3人目のゲスト -->
            <div class="guest-item">
                <h2 class="x2txt">黒瀬公認会計士事務所</h2>
                <div class="image-preview">
                    <img src="{{ asset('images/guest_v3.jpg') }}" alt="ゲストの画像">
                </div>
                <!-- 📌 GIF をゲスト画像の下中央に配置（1つだけ） -->
                <div class="gif-container">
                    <img src="{{ asset('images/robo1.gif') }}" alt="GIF1" class="gif-item">
                </div>
            </div>

            <!-- 4人目のゲスト -->
            <div class="guest-item">
                <h2 class="x2txt">公認会計士税理士 黒瀬賢史</h2>
                <div class="image-preview">
                    <img src="{{ asset('images/guest_v4.png') }}" alt="ゲストの画像">
                </div>
                <!-- 📌 GIF をゲスト画像の下中央に配置（1つだけ） -->
                <div class="gif-container">
                    <img src="{{ asset('images/robo2.gif') }}" alt="GIF2" class="gif-item">
                </div>
            </div>
        </div>
    </div>
    <!-- フッター -->
    <footer>
        <div class="container">
            <p>&copy; 2025 TaxBar® Tax Minutes®. All rights reserved.</p>
            <div class="prefecture-links">
                <ul>
                    <li><a href="#">北海道</a></li>
                    <li><a href="#">青森県</a></li>
                    <li><a href="#">岩手県</a></li>
                    <li><a href="#">宮城県</a></li>
                    <li><a href="#">秋田県</a></li>
                    <li><a href="#">山形県</a></li>
                    <li><a href="#">福島県</a></li>
                    <li><a href="#">茨城県</a></li>
                    <li><a href="#">栃木県</a></li>
                    <li><a href="#">群馬県</a></li>
                    <li><a href="#">埼玉県</a></li>
                    <li><a href="#">千葉県</a></li>
                    <li><a href="#">東京都</a></li>
                    <li><a href="#">神奈川県</a></li>
                    <li><a href="#">新潟県</a></li>
                    <li><a href="#">富山県</a></li>
                    <li><a href="#">石川県</a></li>
                    <li><a href="#">福井県</a></li>
                    <li><a href="#">山梨県</a></li>
                    <li><a href="#">長野県</a></li>
                    <li><a href="#">岐阜県</a></li>
                    <li><a href="#">静岡県</a></li>
                    <li><a href="#">愛知県</a></li>
                    <li><a href="#">三重県</a></li>
                    <li><a href="#">滋賀県</a></li>
                    <li><a href="#">京都府</a></li>
                    <li><a href="#">大阪府</a></li>
                    <li><a href="#">兵庫県</a></li>
                    <li><a href="#">奈良県</a></li>
                    <li><a href="#">和歌山県</a></li>
                    <li><a href="#">鳥取県</a></li>
                    <li><a href="#">島根県</a></li>
                    <li><a href="#">岡山県</a></li>
                    <li><a href="#">広島県</a></li>
                    <li><a href="#">山口県</a></li>
                    <li><a href="#">徳島県</a></li>
                    <li><a href="#">香川県</a></li>
                    <li><a href="#">愛媛県</a></li>
                    <li><a href="#">高知県</a></li>
                    <li><a href="#">福岡県</a></li>
                    <li><a href="#">佐賀県</a></li>
                    <li><a href="#">長崎県</a></li>
                    <li><a href="#">熊本県</a></li>
                    <li><a href="#">大分県</a></li>
                    <li><a href="#">宮崎県</a></li>
                    <li><a href="#">鹿児島県</a></li>
                    <li><a href="#">沖縄県</a></li>
                </ul>
            </div>
        </div>
    </footer>

</body>

</html>
