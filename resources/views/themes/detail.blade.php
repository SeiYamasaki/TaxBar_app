<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>テーマ詳細 | TaxBar®</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* ✅ ヘッダーの背景を完全な白に固定 */
        .header {
            background-color: white !important;
            box-shadow: none !important;
            opacity: 1 !important;
            z-index: 100 !important;
        }

        /* ✅ body の背景を完全な白に */
        body {
            background-color: white !important;
            z-index: 0;
        }

        /* ✅ メインコンテンツの適切な位置調整 */
        main {
            padding-top: 20rem;
        }

        /* ✅ `video-container` の影響を排除 */
        .video-container {
            position: fixed !important;
            z-index: -100 !important;
            background: black !important;
            opacity: 0.8 !important;
        }
    

        /* ✅ テーマのカードのホバーエフェクト */
        .theme-card:hover {
            box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-3px);
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>

<body class="min-h-screen">
    @include('components.header')

    <!-- ✅ メインコンテンツ -->
    <main class="container mx-auto px-4 py-10 pt-24">
        <!-- タイトルと説明 -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">テーマ別相談</h1>
            <p class="text-lg text-gray-600">ユーザーは自分の興味や課題に応じた相談テーマに参加することができます。</p>
        </div>

        <!-- ✅ テーマ一覧 -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ($themes as $theme)
                <div class="bg-white rounded-lg shadow-lg p-6 theme-card">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b-2 border-indigo-500 pb-2">
                        {{ $theme->title }}
                    </h2>
                    <div class="theme-image-wrapper">
                        <img src="{{ asset($theme->image) }}" alt="{{ $theme->title }}" class="w-full">
                    </div>
                    <h4 class="text-center text-indigo-600 font-bold mt-4">
                        クチコミ <i class="fa-regular fa-comment"></i>
                    </h4>
                    <div class="theme-reviews bg-white border rounded-lg p-3 max-h-24 overflow-y-auto">
                        @foreach ($theme->reviews as $review)
                            <div class="review-item border-b last:border-none pb-2">
                                <span>{{ $review->content }}</span>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('theme.detail', $theme->id) }}"
                        class="block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-5 rounded-lg text-center mt-4">
                        相談する
                    </a>
                </div>
            @endforeach
        </div>

        <!-- ✅ ページネーション -->
        <div class="pagination mt-10 flex justify-center space-x-2">
            {{ $themes->links() }}
        </div>
    </main>

    <!-- ✅ フッター -->
    @include('components.footer')

</body>

</html>
