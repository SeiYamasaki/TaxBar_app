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
                        <h3>ダミーリール動画 1</h3>
                    </a>
                </div>

                <!-- 📌 ダミーリール動画 2（9:12） -->
                <div class="video-card">
                    <a href="#">
                        <video controls>
                            <source src="https://samplelib.com/lib/preview/mp4/sample-10s.mp4" type="video/mp4">
                            お使いのブラウザは動画タグをサポートしていません。
                        </video>
                        <h3>ダミーリール動画 2</h3>
                    </a>
                </div>

                <!-- 📌 ダミーリール動画 3（9:12） -->
                <div class="video-card">
                    <a href="#">
                        <video controls>
                            <source src="https://samplelib.com/lib/preview/mp4/sample-15s.mp4" type="video/mp4">
                            お使いのブラウザは動画タグをサポートしていません。
                        </video>
                        <h3>ダミーリール動画 3</h3>
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
        </div>
    </footer>

</body>

</html>
