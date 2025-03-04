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
            background: rgba(255, 255, 255, 0.8);
            border-radius: 0.5rem;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
        }

        .theme-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .theme-card .card-image-container {
            position: relative;
            overflow: hidden;
        }

        .theme-card .card-image {
            transition: transform 0.5s ease;
        }

        .theme-card:hover .card-image {
            transform: scale(1.1);
        }

        .theme-tag {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 4px 12px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: white;
            font-size: 0.75rem;
            font-weight: bold;
            border-radius: 20px;
            z-index: 1;
            box-shadow: 0 2px 10px rgba(99, 102, 241, 0.3);
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin: 2rem 0;
        }

        .pagination-item {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-weight: 600;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.7);
            color: #4b5563;
        }

        .pagination-item:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .pagination-item.active {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .pagination-arrow {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.7);
            color: #4b5563;
            transition: all 0.3s ease;
        }

        .pagination-arrow:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .pagination-arrow.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination-arrow.disabled:hover {
            transform: none;
            box-shadow: none;
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
        <div class="container mx-auto px-4 py-20">
            <div class="bg-black bg-opacity-60 p-6 rounded-lg backdrop-blur-sm text-center text-white mb-10">
                <h1 class="text-3xl sm:text-4xl font-bold mb-3">さまざまなテーマ</h1>
                <p class="mt-2 text-lg opacity-90">目的に合わせて最適なテーマをお選びください</p>
            </div>

            <div class="theme-grid">
                <!-- テーマカード1 -->
                <div class="theme-card">
                    <span class="theme-tag">人気</span>
                    <div
                        class="card-image-container h-48 w-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center overflow-hidden">
                        <div class="card-image text-white text-4xl font-bold">
                            <i class="fas fa-chart-line text-5xl mb-2"></i>
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="font-bold text-gray-800 text-xl mb-3">ビジネス分析</h3>
                        <p class="text-gray-600 mb-4">事業分析に特化したテーマです。グラフやデータ表示に最適化されています。</p>
                        <a href="#"
                            class="group inline-flex items-center justify-center space-x-2 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white py-2 px-6 rounded-full text-sm font-medium transition-all duration-300 shadow-md hover:shadow-lg">
                            <span>詳細を見る</span>
                            <i
                                class="fas fa-arrow-right transition-transform duration-300 group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>

                <!-- テーマカード2 -->
                <div class="theme-card">
                    <span class="theme-tag">新着</span>
                    <div
                        class="card-image-container h-48 w-full bg-gradient-to-r from-green-500 to-teal-500 flex items-center justify-center overflow-hidden">
                        <div class="card-image text-white text-4xl font-bold">
                            <i class="fas fa-leaf text-5xl mb-2"></i>
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="font-bold text-gray-800 text-xl mb-3">環境重視</h3>
                        <p class="text-gray-600 mb-4">環境に配慮した事業のためのテーマです。持続可能性を強調したデザイン。</p>
                        <a href="#"
                            class="group inline-flex items-center justify-center space-x-2 bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-600 hover:to-teal-600 text-white py-2 px-6 rounded-full text-sm font-medium transition-all duration-300 shadow-md hover:shadow-lg">
                            <span>詳細を見る</span>
                            <i
                                class="fas fa-arrow-right transition-transform duration-300 group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>

                <!-- テーマカード3 -->
                <div class="theme-card">
                    <div
                        class="card-image-container h-48 w-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center overflow-hidden">
                        <div class="card-image text-white text-4xl font-bold">
                            <i class="fas fa-store text-5xl mb-2"></i>
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="font-bold text-gray-800 text-xl mb-3">小売業向け</h3>
                        <p class="text-gray-600 mb-4">小売業に最適化されたテーマです。商品管理や販売分析に便利な機能を搭載。</p>
                        <a href="#"
                            class="group inline-flex items-center justify-center space-x-2 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white py-2 px-6 rounded-full text-sm font-medium transition-all duration-300 shadow-md hover:shadow-lg">
                            <span>詳細を見る</span>
                            <i
                                class="fas fa-arrow-right transition-transform duration-300 group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>

                <!-- テーマカード4 -->
                <div class="theme-card">
                    <div
                        class="card-image-container h-48 w-full bg-gradient-to-r from-red-500 to-orange-500 flex items-center justify-center overflow-hidden">
                        <div class="card-image text-white text-4xl font-bold">
                            <i class="fas fa-utensils text-5xl mb-2"></i>
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="font-bold text-gray-800 text-xl mb-3">飲食店向け</h3>
                        <p class="text-gray-600 mb-4">飲食業に特化したテーマです。メニュー管理や顧客情報の分析に役立ちます。</p>
                        <a href="#"
                            class="group inline-flex items-center justify-center space-x-2 bg-gradient-to-r from-red-500 to-orange-500 hover:from-red-600 hover:to-orange-600 text-white py-2 px-6 rounded-full text-sm font-medium transition-all duration-300 shadow-md hover:shadow-lg">
                            <span>詳細を見る</span>
                            <i
                                class="fas fa-arrow-right transition-transform duration-300 group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>

                <!-- テーマカード5 -->
                <div class="theme-card">
                    <div
                        class="card-image-container h-48 w-full bg-gradient-to-r from-yellow-400 to-amber-500 flex items-center justify-center overflow-hidden">
                        <div class="card-image text-white text-4xl font-bold">
                            <i class="fas fa-building text-5xl mb-2"></i>
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="font-bold text-gray-800 text-xl mb-3">不動産業向け</h3>
                        <p class="text-gray-600 mb-4">不動産業のための専用テーマです。物件管理や契約管理に特化しています。</p>
                        <a href="#"
                            class="group inline-flex items-center justify-center space-x-2 bg-gradient-to-r from-yellow-400 to-amber-500 hover:from-yellow-500 hover:to-amber-600 text-white py-2 px-6 rounded-full text-sm font-medium transition-all duration-300 shadow-md hover:shadow-lg">
                            <span>詳細を見る</span>
                            <i
                                class="fas fa-arrow-right transition-transform duration-300 group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>

                <!-- テーマカード6 -->
                <div class="theme-card">
                    <div
                        class="card-image-container h-48 w-full bg-gradient-to-r from-cyan-500 to-blue-500 flex items-center justify-center overflow-hidden">
                        <div class="card-image text-white text-4xl font-bold">
                            <i class="fas fa-briefcase-medical text-5xl mb-2"></i>
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="font-bold text-gray-800 text-xl mb-3">医療機関向け</h3>
                        <p class="text-gray-600 mb-4">医療機関向けのテーマです。患者管理や予約システムと連携可能です。</p>
                        <a href="#"
                            class="group inline-flex items-center justify-center space-x-2 bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white py-2 px-6 rounded-full text-sm font-medium transition-all duration-300 shadow-md hover:shadow-lg">
                            <span>詳細を見る</span>
                            <i
                                class="fas fa-arrow-right transition-transform duration-300 group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- ページネーション（改良版） -->
            <div class="pagination-container">
                <a href="#" class="pagination-arrow" aria-label="前のページ">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <a href="#" class="pagination-item active">1</a>
                <a href="#" class="pagination-item">2</a>
                <a href="#" class="pagination-item">3</a>
                <span class="text-white mx-1">...</span>
                <a href="#" class="pagination-item">10</a>
                <a href="#" class="pagination-arrow" aria-label="次のページ">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
    </main>

    <!-- フッター -->
    @include('components.footer')
</body>

</html>
