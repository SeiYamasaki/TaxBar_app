<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar®️ | テーマ</title>
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- FontAwesomeの追加 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* テーマページ専用のスタイル */
        .theme-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        @media (min-width: 640px) {
            .theme-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .theme-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .theme-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 0.5rem;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            padding: 1rem;
            margin-bottom: 1rem;
            color: #333;
        }

        .theme-card:hover {
            transform: translateY(-5px);
        }

        .theme-image {
            height: auto;
            width: 100%;
            aspect-ratio: 9 / 12;
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.25rem;
        }

        .theme-title {
            font-size: 1.1rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 0.75rem;
            color: #333;
        }

        .theme-button {
            background-color: #ff5a5f;
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            margin: 0 auto;
            display: block;
            font-weight: bold;
            margin-bottom: 0.75rem;
            transition: background-color 0.3s;
            width: 50%;
        }

        .theme-button:hover {
            background-color: #ff3b40;
        }

        .theme-description {
            text-align: center;
            color: #666;
            font-size: 0.9rem;
        }

        .page-header {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
        }

        .page-title {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .page-subtitle {
            color: white;
            text-align: center;
            font-size: 1rem;
            opacity: 0.8;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .pagination-item {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            border: 1px solid #ddd;
            background-color: rgba(255, 255, 255, 0.8);
            font-weight: bold;
            color: #333;
            text-decoration: none;
        }

        .pagination-item:hover,
        .pagination-item.active {
            background-color: #333;
            color: white;
        }

        .review-item {
            display: flex;
            justify-content: space-between;
            background-color: #f0f0f0;
            padding: 0.5rem;
            border-radius: 0.25rem;
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
        <div class="container mx-auto px-10 py-20" style="max-width: 1261px;">
            <div class="page-header">
                <h1 class="page-title">テーマ</h1>
                <p class="page-subtitle">お客様の興味や必要に応じた相談ルームに参加することができます</p>
            </div>

            <div class="theme-grid">
                <!-- テーマカード1 -->
                <div>
                    <div class="theme-card">
                        <h3 class="theme-title">確定申告</h3>
                        <div class="theme-image">
                            IMAGE
                        </div>
                        <h4 class="theme-subtitle text-gray-900">クチコミ<i class="fa-regular fa-comment"></i></h4>
                        <div class="theme-reviews" style="max-height: 100px; overflow-y: auto;">
                            <div class="review-item">
                                <span class="text-gray-900">最高です！とても感謝しています。もっとお話を聞きたいです。</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">このテーマは素晴らしいです！</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">最高です！</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">最高です！</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">最高です！</span>
                            </div>
                        </div>
                    </div>
                    <p class="theme-button">予約ボタン</p>
                </div>

                <!-- テーマカード2 -->
                <div>
                    <div class="theme-card">
                        <h3 class="theme-title">起業・法⼈化</h3>
                        <div class="theme-image">
                            IMAGE
                        </div>
                        <h4 class="theme-subtitle text-gray-900">口コミ</h4>
                        <div class="theme-reviews" style="max-height: 100px; overflow-y: auto;">
                            <div class="review-item">
                                <span class="text-gray-900">最高です！とても感謝しています。もっとお話を聞きたいです。</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">このテーマは素晴らしいです！</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">最高です！</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">最高です！</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">最高です！</span>
                            </div>
                        </div>
                    </div>
                    <p class="theme-button">予約ボタン</p>
                </div>

                <!-- テーマカード3 -->
                <div>
                    <div class="theme-card">
                        <h3 class="theme-title">節税・資産運⽤</h3>
                        <div class="theme-image">
                            IMAGE
                        </div>
                        <h4 class="theme-subtitle text-gray-900">口コミ</h4>
                        <div class="theme-reviews" style="max-height: 100px; overflow-y: auto;">
                            <div class="review-item">
                                <span class="text-gray-900">最高です！とても感謝しています。もっとお話を聞きたいです。</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">このテーマは素晴らしいです！</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">最高です！</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">最高です！</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">最高です！</span>
                            </div>
                        </div>
                    </div>
                    <p class="theme-button">予約ボタン</p>
                </div>

                <!-- テーマカード4 -->
                <div>
                    <div class="theme-card">
                        <h3 class="theme-title">副業・個⼈事業主</h3>
                        <div class="theme-image">
                            IMAGE
                        </div>
                        <h4 class="theme-subtitle text-gray-900">口コミ</h4>
                        <div class="theme-reviews" style="max-height: 100px; overflow-y: auto;">
                            <div class="review-item">
                                <span class="text-gray-900">最高です！とても感謝しています。もっとお話を聞きたいです。</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">このテーマは素晴らしいです！</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">最高です！</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">最高です！</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">最高です！</span>
                            </div>
                        </div>
                    </div>
                    <p class="theme-button">予約ボタン</p>
                </div>

                <!-- テーマカード5 -->
                <div>
                    <div class="theme-card">
                        <h3 class="theme-title">不動産・投資</h3>
                        <div class="theme-image">
                            IMAGE
                        </div>
                        <h4 class="theme-subtitle text-gray-900">口コミ</h4>
                        <div class="theme-reviews" style="max-height: 100px; overflow-y: auto;">
                            <div class="review-item">
                                <span class="text-gray-900">最高です！とても感謝しています。もっとお話を聞きたいです。</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">このテーマは素晴らしいです！</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">最高です！</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">最高です！</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">最高です！</span>
                            </div>
                        </div>
                    </div>
                    <p class="theme-button">予約ボタン</p>
                </div>

                <!-- テーマカード6 -->
                <div>
                    <div class="theme-card">
                        <h3 class="theme-title">海外・インバウンド</h3>
                        <div class="theme-image">
                            IMAGE
                        </div>
                        <h4 class="theme-subtitle text-gray-900">口コミ</h4>
                        <div class="theme-reviews" style="max-height: 100px; overflow-y: auto;">
                            <div class="review-item">
                                <span class="text-gray-900">最高です！とても感謝しています。もっとお話を聞きたいです。</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">このテーマは素晴らしいです！</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">最高です！</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">最高です！</span>
                            </div>
                            <hr>
                            <div class="review-item">
                                <span class="text-gray-900">最高です！</span>
                            </div>
                        </div>
                    </div>
                    <p class="theme-button">予約ボタン</p>
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
