<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>動画を編集 - TaxBar®️</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite('resources/css/app.css')
    <style>
        .video-container {
            position: relative;
            width: 100%;
            max-width: 480px;
            margin: 0 auto;
            background-color: #000;
            border-radius: 0.5rem 0.5rem 0 0;
            overflow: hidden;
        }

        .video-container video {
            width: 100%;
            height: auto;
            aspect-ratio: 9 / 16;
            object-fit: cover;
            background-color: #000;
            position: relative;
            z-index: 10;
            border-radius: 0.5rem 0.5rem 0 0;
        }

        .video-placeholder {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #000;
            color: white;
            z-index: 5;
        }

        .video-placeholder svg {
            width: 64px;
            height: 64px;
            margin-bottom: 16px;
            opacity: 0.7;
        }

        /* 再生ボタンのオーバーレイ */
        #playOverlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(0, 0, 0, 0.3);
            cursor: pointer;
            z-index: 15;
            transition: background-color 0.3s;
            pointer-events: none;
        }

        #playOverlay:hover {
            background-color: rgba(0, 0, 0, 0.2);
        }

        #playOverlay svg {
            width: 64px;
            height: 64px;
            color: white;
            opacity: 0.8;
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

        @media (min-width: 1024px) {
            .video-fullscreen {
                display: flex;
                flex-direction: column;
            }

            .video-container {
                flex: 1;
            }
        }
    </style>
</head>

<body class="flex h-screen bg-gray-100 font-sans">
    <!-- サイドバー -->
    @include('components.tax-advisor.sidebar')
    <!-- パララックスヘッダー -->
    @include('components.parallax-header')  
    <!-- メインコンテンツ -->
    <main class="flex-1 container mt-12 mx-auto px-4 py-16 animate-fade-in">
        <!-- 動画タイトル -->
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-10 text-center">動画編集</h1>

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 w-full max-w-4xl">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
            <!-- 左側：動画プレイヤー -->
            <div class="lg:col-span-3 flex justify-center">
                <div class="video-container bg-white rounded-lg shadow-lg overflow-hidden relative">
                    <!-- 動画が読み込めない場合のプレースホルダー -->
                    <div id="videoPlaceholder" class="video-placeholder">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <p>動画を読み込み中...</p>
                    </div>

                    <video id="videoPlayer" playsinline preload="metadata" class="w-full h-full" controls>
                        <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                        お使いのブラウザは動画再生に対応していません。
                    </video>

                    <!-- 再生ボタンのオーバーレイ -->
                    <div id="playOverlay"
                        class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30 hover:bg-opacity-20 transition-all duration-300">
                        <svg class="w-12 h-12 text-white opacity-80" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z" />
                        </svg>
                    </div>
                </div>
            </div>
            <!-- 右側：動画詳細情報 -->
            <div class="lg:col-span-2">
                <form action="{{ route('taxminivideos.update', $video->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-lg font-semibold text-gray-800 mb-5 border-b-2 border-indigo-500 pb-3">
                            動画詳細</h2>
                        <div class="space-y-5 text-gray-700 text-base">
                            <div>
                                <label for="title" class="flex items-center font-medium text-gray-900 mb-2">
                                    <svg class="w-5 h-5 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                        </path>
                                    </svg>
                                    タイトル:
                                </label>
                                <input type="text" name="title" id="title"
                                    value="{{ old('title', $video->title) }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="description" class="flex items-center font-medium text-gray-900 mb-2">
                                    <svg class="w-5 h-5 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M2 3h16a2 2 0 012 2v10a2 2 0 01-2-2H2a2 2 0 01-2-2V5a2 2 0 012-2zm1 2v10h14V5H3z" />
                                    </svg>
                                    説明:
                                </label>
                                <textarea name="description" id="description" rows="4"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $video->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- サムネイル画像の設定 -->
                            <div>
                                <label for="thumbnail" class="flex items-center font-medium text-gray-900 mb-2">
                                    <svg class="w-5 h-5 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    サムネイル画像:
                                </label>

                                <!-- 現在のサムネイル表示 -->
                                @if ($video->thumbnail_path)
                                    <div class="mb-3 flex items-center">
                                        <img src="{{ asset('storage/' . $video->thumbnail_path) }}" alt="現在のサムネイル"
                                            class="w-24 h-16 object-cover rounded border">
                                        <span class="ml-3 text-sm text-gray-600">現在設定されているサムネイル</span>
                                    </div>
                                @endif

                                <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <p class="text-xs text-gray-500 mt-1">推奨サイズ: 720×1280px（9:16）。設定しない場合は現在のサムネイルが維持されます。
                                </p>
                                @error('thumbnail')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 12a4 4 0 100-8 4 4 0 000 8zm0-10a6 6 0 016 6c0 2.22-1.21 4.16-3 5.2V15a1 1 0 01-1 1h-4a1 1 0 01-1-1v-1.8C5.21 12.16 4 10.22 4 8a6 6 0 016-6z" />
                                </svg>
                                <span class="font-medium text-gray-900">閲覧数:</span>
                                <span class="ml-2">{{ $video->views }} 回</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 12a4 4 0 100-8 4 4 0 000 8zm0-10a6 6 0 016 6c0 2.22-1.21 4.16-3 5.2V15a1 1 0 01-1 1h-4a1 1 0 01-1-1v-1.8C5.21 12.16 4 10.22 4 8a6 6 0 016-6z" />
                                </svg>
                                コメント一覧
                            </div>
                            @foreach ($video->comments as $comment)
                                <div class="mb-2">
                                    @if (
                                        $comment->user &&
                                            $comment->user->isTaxAdvisor() &&
                                            $comment->user->taxAdvisor &&
                                            $comment->user->taxAdvisor->expert_photo_url)
                                        <img src="{{ asset('storage/' . $comment->user->taxAdvisor->expert_photo_url) }}"
                                            alt="ユーザーアイコン" class="w-8 h-8 rounded-full">
                                    @else
                                        <svg class="w-8 h-8 text-gray-400 bg-gray-100 rounded-full border-2 border-gray-200 p-1 mr-2"
                                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                    <span
                                        class="font-medium text-gray-900">{{ $comment->display_name ?? ($comment->user ? $comment->user->name : '一般') }}</span>
                                    <span class="ml-2">{{ $comment->content }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- アクションボタン -->
                    <div class="mt-8 flex justify-between">
                        <div class="flex space-x-2">
                            <a href="{{ route('dashboard') }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-all duration-300">
                                キャンセル
                            </a>
                            <button type="submit" name="action" value="update"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-all duration-300">
                                更新する
                            </button>
                        </div>
                    </div>
            </div>
            </form>

            <form action="{{ route('taxminivideos.destroy', $video->id) }}" method="POST" class="mt-4"
                onsubmit="return confirm('この動画を削除してもよろしいですか？');">
                @csrf
                @method('DELETE')
                <button type="submit" name="action" value="delete"
                    class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-all duration-300">
                    削除
                </button>
            </form>
        </div>
        </div>

        <!-- アクションボタン -->
        <div class="mt-10 text-center">
            <a href="{{ route('dashboard') }}"
                class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-5 rounded-lg shadow-md transition-all duration-300">
                一覧に戻る
            </a>
        </div>
    </main>

    <!-- フッター -->
    @include('components.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('videoPlayer');
            const videoPlaceholder = document.getElementById('videoPlaceholder');
            const playOverlay = document.getElementById('playOverlay');

            // 動画のエラーハンドリング
            video.addEventListener('error', function(e) {
                console.error('動画の読み込みエラー:', e);
                videoPlaceholder.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p>動画の読み込みに失敗しました</p>
                `;
                videoPlaceholder.style.display = 'flex';
            });

            // 動画のURLを直接設定
            const videoSrc = "{{ asset('storage/' . $video->video_path) }}";
            video.querySelector('source').src = videoSrc;
            video.load();

            // 動画の読み込み完了イベント
            video.addEventListener('loadeddata', function() {
                videoPlaceholder.style.display = 'none';
            });

            // 再生ボタンのオーバーレイ制御
            video.addEventListener('play', function() {
                playOverlay.style.display = 'none';
            });

            video.addEventListener('pause', function() {
                playOverlay.style.display = 'flex';
            });

            // 念のために5秒後にプレースホルダーを強制的に非表示にする
            setTimeout(function() {
                videoPlaceholder.style.display = 'none';
            }, 5000);
        });
    </script>
</body>

</html>
