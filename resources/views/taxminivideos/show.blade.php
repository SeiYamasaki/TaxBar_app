<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $video->title }} - TaxBar®️</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite('resources/css/app.css')
    <style>
        .video-container {
            position: relative;
            width: 100%;
            max-width: 480px;
            /* 動画の幅を少し広げる（9:16 の場合でも自然なサイズに） */
            margin: 0 auto;
            /* 中央揃え */
        }

        .video-container video {
            width: 100%;
            height: auto;
            aspect-ratio: 9 / 16;
            /* 9:16 のアスペクト比を設定 */
            object-fit: cover;
            /* 動画がコンテナにフィットするように調整 */
            border-radius: 0.5rem 0.5rem 0 0;
            /* Tailwind の rounded-t-lg を再現 */
        }

        .video-container>div {
            pointer-events: none;
            /* オーバーレイがクリックイベントを受け取らない */
        }

        .container {
            margin-top: 100px !important;
        }

        /* フェードインアニメーション */
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <!-- ヘッダー -->
    @include('components.header')

    <!-- メインコンテンツ -->
    <main class="container mt-12 mx-auto px-4 py-16 animate-fade-in">
        <!-- 動画タイトル -->
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-10 text-center">{{ $video->title }}</h1>

        <!-- 動画と詳細情報のコンテナ -->
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
            <!-- 動画プレイヤー -->
            <div class="lg:col-span-3 flex justify-center">
                <div class="video-container bg-white rounded-lg shadow-lg overflow-hidden relative">
                    <video controls class="w-full h-auto">
                        <source src="{{ $video->video_url }}" type="video/mp4">
                        お使いのブラウザは動画再生に対応していません。
                    </video>
                    <!-- 再生ボタンのオーバーレイ -->
                    <div
                        class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30 hover:bg-opacity-20 transition-all duration-300">
                        <svg class="w-12 h-12 text-white opacity-80" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- 動画詳細情報 -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-5 border-b-2 border-indigo-500 pb-3">動画詳細</h2>
                    <div class="space-y-5 text-gray-700 text-base">
                        <p class="flex items-center">
                            <svg class="w-5 h-5 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 10a4 4 0 100-8 4 4 0 000 8zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                            <span class="font-medium text-gray-900">投稿者:</span>
                            <span>{{ $video->user->name }}</span>
                        </p>
                        <p class="flex items-center">
                            <svg class="w-5 h-5 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M2 3h16a2 2 0 012 2v10a2 2 0 01-2 2H2a2 2 0 01-2-2V5a2 2 0 012-2zm1 2v10h14V5H3z" />
                            </svg>
                            <span class="font-medium text-gray-900">説明:</span>
                            <span>{{ $video->description }}</span>
                        </p>
                        <p class="flex items-center">
                            <svg class="w-5 h-5 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 12a4 4 0 100-8 4 4 0 000 8zm0-10a6 6 0 016 6c0 2.22-1.21 4.16-3 5.2V15a1 1 0 01-1 1h-4a1 1 0 01-1-1v-1.8C5.21 12.16 4 10.22 4 8a6 6 0 016-6z" />
                            </svg>
                            <span class="font-medium text-gray-900">閲覧数:</span>
                            <span>{{ $video->views }} 回</span>
                        </p>
                    </div>
                    <!-- コメント投稿エリア -->
                    <div class="mt-10 text-center">
                        <h3 class="text-lg font-semibold text-gray-800 mb-5 border-b-2 border-indigo-500 pb-3">コメント投稿
                        </h3>
                        <form action="{{ route('comments.store.video', $video->id) }}" method="POST">
                            @csrf
                            <textarea name="content" class="w-full p-2 border rounded-lg" placeholder="コメントを入力"></textarea>
                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-5 rounded-lg shadow-md transition-all duration-300">投稿</button>
                        </form>
                    </div>

                    <div class="mt-10 text-center">
                        <!-- コメント一覧 -->
                        <h3 class="text-lg font-semibold text-gray-800 mb-5 border-b-2 border-indigo-500 pb-3">コメント</h3>
                        <div class="space-y-5 text-gray-700 text-base">
                            @forelse ($video->approvedComments as $comment)
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <span class="font-medium text-gray-900 mr-2">{{ $comment->user->name }}</span>
                                        <span
                                            class="text-xs text-gray-500">{{ $comment->created_at->format('Y/m/d H:i') }}</span>
                                    </div>
                                    <p class="text-gray-700">{{ $comment->content }}</p>
                                </div>
                            @empty
                                <p class="text-gray-500 italic">コメントはまだありません</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- アクションボタン -->
        <div class="mt-10 text-center">
            <a href="{{ route('taxminivideos.index') }}"
                class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-5 rounded-lg shadow-md transition-all duration-300">
                戻る
            </a>
        </div>
    </main>

    <!-- フッター -->
    @include('components.footer')

    <script>
        const video = document.querySelector('video');
        const overlay = document.querySelector('.video-container > div');

        video.addEventListener('play', () => {
            overlay.style.display = 'none'; // 動画が再生されるとオーバーレイを非表示に
        });

        video.addEventListener('pause', () => {
            overlay.style.display = 'flex'; // 動画が一時停止するとオーバーレイを表示
        });
    </script>
</body>

</html>
