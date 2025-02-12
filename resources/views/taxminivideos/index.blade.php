<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar&reg | TaxMinutes&reg</title>
    <link rel="stylesheet" href="{{ asset('css/taxministyle.css') }}">
</head>

<body>

    <!-- ヘッダー -->
    <header class="header">
        <!-- ロゴ -->
        <div class="logo">
            <a href="/view/login">
                <img src="{{ asset('images/logo.png') }}" alt="ロゴ">
            </a>
        </div>

        <!-- ナビゲーションメニュー -->
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


    <!-- メインコンテンツ -->
    <main>
        <div class="container">
            <h2>動画一覧</h2>
            <div class="video-grid">
                <!-- 📌 ダミーリール動画 1（9:12） -->
                <div class="video-card">
                    <a href="#">
                        <video controls>
                            <source src="https://samplelib.com/lib/preview/mp4/sample-5s.mp4" type="video/mp4">
                            お使いのブラウザは動画タグをサポートしていません。
                        </video>
                        <h3>◯◯◯◯会計事務所TaxMinutes&reg動画 1</h3>
                    </a>
                </div>

                <!-- 📌 ダミーリール動画 2（9:12） -->
                <div class="video-card">
                    <a href="#">
                        <video controls>
                            <source src="https://samplelib.com/lib/preview/mp4/sample-10s.mp4" type="video/mp4">
                            お使いのブラウザは動画タグをサポートしていません。
                        </video>
                        <h3>◯◯◯◯会計事務所TaxMinutes&reg動画 2</h3>
                    </a>
                </div>

                <!-- 📌 ダミーリール動画 3（9:12） -->
                <div class="video-card">
                    <a href="#">
                        <video controls>
                            <source src="https://samplelib.com/lib/preview/mp4/sample-15s.mp4" type="video/mp4">
                            お使いのブラウザは動画タグをサポートしていません。
                        </video>
                        <h3>◯◯◯◯会計事務所TaxMinutes&reg動画 3</h3>
                    </a>
                </div>
            </div>

            <!-- ページネーション -->
            <div class="pagination">
                {{ $videos->links() }}
            </div>
        </div>
    </main>

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
