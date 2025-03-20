<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar®️ | 動画を編集</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite('resources/css/app.css')
    <style>
        [x-cloak] {
            display: none !important;
        }

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

<body class="flex h-full bg-gray-100 relative">
    <!-- サイドバー -->
    <x-tax-advisor.sidebar :user="auth()->user()" />

    <!-- メインコンテンツ -->
    <div class="flex-1 md:ml-64 transition-all duration-300 ease-in-out">
        <!-- ヘッダー -->
        <header class="fixed top-0 right-0 left-0 md:left-64 z-[999] bg-white md:bg-transparent shadow md:shadow-none">
            <div class="flex justify-between items-center h-16 px-4 md:px-6">
                <!-- モバイル用のハンバーガーメニューのスペース -->
                <div class="w-10 md:hidden"></div>

                <!-- アカウントメニュー - 右寄せ -->
                <div class="relative ml-auto" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                        <div class="flex items-center space-x-4">
                            @if (auth()->user()->taxAdvisor && auth()->user()->taxAdvisor->tax_accountant_photo)
                                <img src="{{ asset('storage/' . auth()->user()->taxAdvisor->tax_accountant_photo) }}"
                                    alt="プロフィール画像" class="w-10 h-10 rounded-full">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex flex-col">
                                <span
                                    class="text-sm font-medium text-gray-700 md:text-white">{{ auth()->user()->name }}</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>

                    <!-- ドロップダウンメニュー -->
                    <div x-show="open" x-cloak @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-[9999]">
                        <a href="{{ route('tax_advisor.profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            プロフィール編集
                        </a>
                        <a href="{{ route('notifications.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            通知
                            @if (auth()->user()->unreadNotifications->count() > 0)
                                <span
                                    class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <button type="submit" @click.prevent="$el.closest('form').submit()"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                ログアウト
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <x-parallax-header />

        <!-- メインコンテンツのパディング調整 -->
        <div class="relative w-full z-50">
            <main class="container mx-auto px-4 sm:px-6 py-8">

                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-800">Tax Minutes® - 動画編集</h1>
                    <p class="text-gray-600">動画を編集します</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- 左側：動画プレイヤー -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-lg p-4">
                            <div class="video-container bg-black rounded-lg overflow-hidden relative">
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
                                    <svg class="w-12 h-12 text-white opacity-80" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </div>
                            </div>

                            <div class="mt-4 text-center">
                                <p class="text-sm text-gray-500">閲覧数: {{ $video->views }} 回</p>
                            </div>
                        </div>
                    </div>

                    <!-- 右側：動画詳細情報 -->
                    <div class="lg:col-span-2">
                        <form action="{{ route('taxminivideos.update', $video->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="bg-white rounded-lg shadow-lg p-6">
                                <h2 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-2">動画詳細情報</h2>

                                <div class="space-y-4">
                                    <div>
                                        <label for="title"
                                            class="block text-sm font-medium text-gray-700 mb-1">タイトル</label>
                                        <input type="text" name="title" id="title"
                                            value="{{ old('title', $video->title) }}" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @error('title')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="description"
                                            class="block text-sm font-medium text-gray-700 mb-1">説明</label>
                                        <textarea name="description" id="description" rows="4"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $video->description) }}</textarea>
                                        @error('description')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- サムネイル画像の設定 -->
                                    <div>
                                        <label for="thumbnail"
                                            class="block text-sm font-medium text-gray-700 mb-1">サムネイル画像</label>

                                        <!-- 現在のサムネイル表示 -->
                                        @if ($video->thumbnail_path)
                                            <div class="mb-3 flex items-center">
                                                <img src="{{ asset('storage/' . $video->thumbnail_path) }}"
                                                    alt="現在のサムネイル" class="w-24 h-16 object-cover rounded border">
                                                <span class="ml-3 text-sm text-gray-600">現在設定されているサムネイル</span>
                                            </div>
                                        @endif

                                        <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <p class="text-xs text-gray-500 mt-1">推奨サイズ:
                                            720×1280px（9:16）。設定しない場合は現在のサムネイルが維持されます。</p>
                                        @error('thumbnail')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- コメント一覧 -->
                                    @if ($video->comments->count() > 0)
                                        <div class="mt-6">
                                            <h3 class="text-lg font-medium text-gray-800 mb-2">コメント一覧</h3>
                                            <div class="space-y-3 max-h-60 overflow-y-auto p-2">
                                                @foreach ($video->comments as $comment)
                                                    <div class="bg-gray-50 p-3 rounded">
                                                        <div class="flex items-start">
                                                            @if (
                                                                $comment->user &&
                                                                    $comment->user->isTaxAdvisor() &&
                                                                    $comment->user->taxAdvisor &&
                                                                    $comment->user->taxAdvisor->expert_photo_url)
                                                                <img src="{{ asset('storage/' . $comment->user->taxAdvisor->expert_photo_url) }}"
                                                                    alt="ユーザーアイコン" class="w-8 h-8 rounded-full mr-2">
                                                            @else
                                                                <div
                                                                    class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-2">
                                                                    <svg class="w-4 h-4 text-gray-500"
                                                                        fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd"
                                                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                                            clip-rule="evenodd"></path>
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <p class="font-medium text-sm">
                                                                    {{ $comment->display_name ?? ($comment->user ? $comment->user->name : '一般') }}
                                                                </p>
                                                                <p class="text-gray-700 text-sm">
                                                                    {{ $comment->content }}</p>
                                                                <p class="text-xs text-gray-500 mt-1">
                                                                    {{ $comment->created_at->format('Y/m/d H:i') }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- アクションボタン -->
                                <div class="mt-8 flex flex-col sm:flex-row sm:justify-between gap-4">
                                    <button type="submit" name="action" value="update"
                                        class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">
                                        更新する
                                    </button>

                                    <a href="{{ route('dashboard') }}"
                                        class="w-full sm:w-auto text-center bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-6 rounded-lg transition-colors">
                                        キャンセル
                                    </a>
                                </div>
                            </div>
                        </form>

                        <!-- 削除ボタン -->
                        <div class="mt-4">
                            <form action="{{ route('taxminivideos.destroy', $video->id) }}" method="POST"
                                onsubmit="return confirm('この動画を削除してもよろしいですか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" name="action" value="delete"
                                    class="w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                    動画を削除
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 一覧に戻るボタン -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
                    <a href="{{ route('taxminivideos.manage') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded flex items-center justify-center md:justify-start w-full md:w-auto">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        一覧に戻る
                    </a>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('scroll', function() {
                const parallax = document.querySelector('#parallax-bg');
                if (parallax) {
                    const scrolled = window.pageYOffset;
                    parallax.style.transform = 'translateY(' + (scrolled * 0.5) + 'px)';
                }
            });
        });
    </script>

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
