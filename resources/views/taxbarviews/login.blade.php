<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TaxBar®のトップページです。">
    <title>TaxBar® | HOME</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col min-h-full">
    @include('components.header')

    <main class="flex-grow">
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
                <h1 class="x2txt">☆TaxBar&reg;イチオシのスペシャル税理士☆</h1>
                <h1 class="x2txt">！！新設法人設立Bar 2025年2月2日 PM20時～21時 要予約！！</h1>
                <h2 class="x2txt">大手監査法人出身 ! 財務のプロフェッショナル｡ 新設法人ならこの会計士 ！</h2>
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
                    <div>
                        <!-- 📌 GIF をゲスト画像の下中央に配置（1つだけ） -->
                        <div class="gif-container">
                            <img src="{{ asset('images/robo2.gif') }}" alt="GIF2" class="gif-item">
                        </div>
                    </div>
                </div>
            </div>

            <div class="guest-container">
                <div class="guest-title">
                    <h1 class="x2txt">☆TaxBar&reg;イチオシのスペシャル税理士☆</h1>
                    <h1 class="x2txt">！！資金調達Bar 2025年2月2日 PM20時～21時 要予約！！</h1>
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
        </div>
    </main>

    @include('components.footer')
</body>

</html>
