<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar®️ | テーマ</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- FontAwesomeの追加 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* リセットとベーススタイル */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: sans-serif;
            line-height: 1.6;
            color: #333;
        }

        /* コンテナスタイル */
        .custom-container {
            width: 100%;
            max-width: 1261px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 3rem;
            padding-bottom: 5rem;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            margin-top: 5rem;
        }

        /* グリッドレイアウト */
        .theme-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            width: 100%;
        }

        @media (max-width: 1024px) {
            .theme-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .theme-grid {
                grid-template-columns: repeat(1, 1fr);
            }
        }

        /* カードスタイル */
        .theme-card {
            background-color: #f8f8f8;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            padding: 15px;
            width: 100%;
            margin-bottom: 0;
            height: 100%;
        }

        /* 画像コンテナ */
        .theme-image-wrapper {
            background: white;
            border-radius: 6px;
            border: 1px solid #eee;
            width: 100%;
            height: 0;
            padding-bottom: 70%;
            position: relative;
            overflow: hidden;
            margin-bottom: 15px;
        }

        .theme-image-wrapper img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 10px;
        }

        /* テキストスタイル */
        .theme-title {
            font-size: 1.3rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
            color: #333;
        }

        .theme-subtitle {
            font-size: 1rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
            color: #333;
        }

        /* レビューエリア */
        .theme-reviews {
            background: white;
            border-radius: 6px;
            border: 1px solid #eee;
            padding: 10px;
            margin-bottom: 15px;
            max-height: 120px;
            overflow-y: auto;
        }

        .review-item {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .review-item:last-child {
            border-bottom: none;
        }

        .review-item span {
            color: #333;
            font-size: 0.9rem;
            display: block;
        }

        /* ボタンスタイル */
        .theme-button {
            background-color: #ff5a5f;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
            margin: auto auto 0 auto;
            display: block;
            text-align: center;
            width: fit-content;
        }

        .theme-button:hover {
            background-color: #ff3b40;
        }

        /* ヘッダー */
        .page-title-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .page-title {
            color: white;
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .page-subtitle {
            color: white;
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        /* ページネーション */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 30px;
        }

        .pagination-item {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border: 1px solid #ddd;
            background-color: white;
            font-weight: bold;
            color: #333;
            text-decoration: none;
            border-radius: 50%;
        }

        .pagination-item:hover,
        .pagination-item.active {
            background-color: #333;
            color: white;
        }

        /* はみ出し防止 */
        main {
            overflow-x: hidden;
            width: 100%;
        }
    </style>
</head>

<body>
    <!-- ヘッダー -->
    @include('components.header')

    <!-- 背景動画 -->
    <div class="video-container">
        <video autoplay muted loop class="background-video">
            <source src="{{ asset('videos/themeback.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <!-- コンテンツエリア -->
    <main>
        <div class="custom-container">
            <div class="page-title-container">
                <h1 class="page-title">テーマ</h1>
                <p class="page-subtitle">お客様の興味や必要に応じた相談ルームに参加することができます</p>
                <a href="{{ route('themes.detail') }}" class="theme-button">詳細一覧はこちら</a>
            </div>

            <div class="theme-grid">
                <!-- テーマカード1 -->
                <div class="theme-card">
                    <h3 class="theme-title">確定申告</h3>
                    <div class="theme-image-wrapper">
                        <img src="{{ asset('images/確定申告Bar.png') }}" alt="確定申告">
                    </div>
                    <h4 class="theme-subtitle">クチコミ<i class="fa-regular fa-comment"></i></h4>
                    <div class="theme-reviews">
                        <div class="review-item">
                            <span>最高です！とても感謝しています。</span>
                        </div>
                        <div class="review-item">
                            <span>このテーマは素晴らしいです！</span>
                        </div>
                        <div class="review-item">
                            <span>確定申告の疑問が解決しました！</span>
                        </div>
                    </div>
                    <button class="theme-button">予約する</button>
                </div>

                <!-- テーマカード2 -->
                <div class="theme-card">
                    <h3 class="theme-title">起業・法⼈化</h3>
                    <div class="theme-image-wrapper">
                        <img src="{{ asset('images/起業Bar.png') }}" alt="起業・法⼈化">
                    </div>
                    <h4 class="theme-subtitle">クチコミ<i class="fa-regular fa-comment"></i></h4>
                    <div class="theme-reviews">
                        <div class="review-item">
                            <span>起業の相談ができて大変参考になりました。</span>
                        </div>
                        <div class="review-item">
                            <span>法人化について詳しく教えていただきました。</span>
                        </div>
                        <div class="review-item">
                            <span>専門的なアドバイスが役立ちました！</span>
                        </div>
                    </div>
                    <button class="theme-button">予約する</button>
                </div>

                <!-- テーマカード3 -->
                <div class="theme-card">
                    <h3 class="theme-title">節税・資産運⽤</h3>
                    <div class="theme-image-wrapper">
                        <img src="{{ asset('images/節税Bar.png') }}" alt="節税・資産運⽤">
                    </div>
                    <h4 class="theme-subtitle">クチコミ<i class="fa-regular fa-comment"></i></h4>
                    <div class="theme-reviews">
                        <div class="review-item">
                            <span>節税対策が具体的で助かりました。</span>
                        </div>
                        <div class="review-item">
                            <span>資産運用の考え方が変わりました！</span>
                        </div>
                        <div class="review-item">
                            <span>実践的なアドバイスに感謝します。</span>
                        </div>
                    </div>
                    <button class="theme-button">予約する</button>
                </div>

                <!-- テーマカード4 -->
                <div class="theme-card">
                    <h3 class="theme-title">副業・個⼈事業主</h3>
                    <div class="theme-image-wrapper">
                        <img src="{{ asset('images/副業Bar.png') }}" alt="副業・個⼈事業主">
                    </div>
                    <h4 class="theme-subtitle">クチコミ<i class="fa-regular fa-comment"></i></h4>
                    <div class="theme-reviews">
                        <div class="review-item">
                            <span>副業を始める際の注意点が理解できました。</span>
                        </div>
                        <div class="review-item">
                            <span>個人事業主としての税務が明確になりました。</span>
                        </div>
                        <div class="review-item">
                            <span>具体的なアドバイスに感謝します！</span>
                        </div>
                    </div>
                    <button class="theme-button">予約する</button>
                </div>

                <!-- テーマカード5 -->
                <div class="theme-card">
                    <h3 class="theme-title">不動産・投資</h3>
                    <div class="theme-image-wrapper">
                        <img src="{{ asset('images/不動産Bar.png') }}" alt="不動産・投資">
                    </div>
                    <h4 class="theme-subtitle">クチコミ<i class="fa-regular fa-comment"></i></h4>
                    <div class="theme-reviews">
                        <div class="review-item">
                            <span>不動産投資のリスクとリターンが理解できました。</span>
                        </div>
                        <div class="review-item">
                            <span>投資の考え方が参考になりました。</span>
                        </div>
                        <div class="review-item">
                            <span>実際の事例を含めた説明が良かったです。</span>
                        </div>
                    </div>
                    <button class="theme-button">予約する</button>
                </div>

                <!-- テーマカード6 -->
                <div class="theme-card">
                    <h3 class="theme-title">海外・インバウンド</h3>
                    <div class="theme-image-wrapper">
                        <img src="{{ asset('images/海外TaxBar.png') }}" alt="海外・インバウンド">
                    </div>
                    <h4 class="theme-subtitle">クチコミ<i class="fa-regular fa-comment"></i></h4>
                    <div class="theme-reviews">
                        <div class="review-item">
                            <span>海外取引の税務について詳しく教えていただきました。</span>
                        </div>
                        <div class="review-item">
                            <span>インバウンド対応のポイントが参考になりました。</span>
                        </div>
                        <div class="review-item">
                            <span>国際的な視点からのアドバイスが役立ちました。</span>
                        </div>
                    </div>
                    <button class="theme-button">予約する</button>
                </div>
            </div>

            <!-- ページネーション -->
            <div class="pagination">
                <a href="#" class="pagination-item active">1</a>
                <a href="#" class="pagination-item">2</a>
                <a href="#" class="pagination-item">3</a>
            </div>
        </div>
    </main>

    <!-- フッター -->
    @include('components.footer')
</body>

</html>
