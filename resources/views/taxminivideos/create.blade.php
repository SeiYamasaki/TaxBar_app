<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar®️ | 動画管理</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="flex h-full bg-gray-100">
    <x-tax-advisor.sidebar :user="$user" />

    <!-- メインコンテンツ -->
    <div class="flex-1 ml-64">
        <!-- ヘッダー -->
        <header class="bg-transparent fixed top-0 right-0 left-64 z-40">
            <div class="flex justify-end items-center px-6">
                <!-- アカウントメニュー -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                        <div class="flex items-center space-x-4">
                            @if ($user->taxAdvisor && $user->taxAdvisor->tax_accountant_photo)
                                <img src="{{ asset('storage/' . $user->taxAdvisor->tax_accountant_photo) }}"
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
                                <span class="text-sm font-medium text-white">{{ $user->name }}</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>

                    <!-- ドロップダウンメニュー -->
                    <div x-show="open" @click.away="open = false"
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
        <div class="relative w-full -mt-24 z-50">
            <main class="container mx-auto px-6 py-8">
                <!-- コンテンツヘッダー -->

                <!-- 投稿フォーム -->
                <div class="bg-white rounded-lg shadow p-6">
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-800">TaxMinutes®️ - 動画投稿</h1>
                    <p class="text-gray-600">クライアント向けの動画を投稿します</p>
                </div>
                    <form x-data="{ showModal: false, title: '', description: '', visibility: 'public', videoSelected: false }" x-ref="form" action="{{ route('taxminivideos.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf

                        <!-- 動画タイトル -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">動画タイトル <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" x-model="title"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                                required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 動画説明 -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">動画説明</label>
                            <textarea name="description" id="description" rows="4" x-model="description"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"></textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- サムネイル画像 -->
                        <div>
                            <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1">サムネイル画像</label>
                            <div class="flex items-center space-x-4">
                                <div class="w-32 h-32 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex flex-col items-center justify-center"
                                    id="thumbnailPreview">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <p class="text-xs text-gray-500 mt-1">プレビュー</p>
                                </div>
                                <div class="flex-1">
                                    <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('thumbnail') border-red-500 @enderror">
                                    <p class="mt-1 text-xs text-gray-500">推奨サイズ: 1280x720px (16:9), 最大5MB</p>
                                    @error('thumbnail')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 動画ファイル -->
                        <div>
                            <label for="video" class="block text-sm font-medium text-gray-700 mb-1">動画ファイル <span
                                    class="text-red-500">*</span></label>
                            <input type="file" name="video" id="video" accept="video/*" x-on:change="videoSelected = $event.target.files.length > 0"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('video') border-red-500 @enderror"
                                required>
                            <p class="mt-1 text-xs text-gray-500">対応形式: MP4, MOV, AVI, 最大サイズ: 100MB</p>
                            @error('video')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 公開設定 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">公開設定</label>
                            <div class="flex items-center space-x-6">
                                <div class="flex items-center">
                                    <input type="radio" name="visibility" id="visibility_public" value="public" x-model="visibility"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" checked>
                                    <label for="visibility_public" class="ml-2 block text-sm text-gray-700">公開</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" name="visibility" id="visibility_private" value="private" x-model="visibility"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <label for="visibility_private"
                                        class="ml-2 block text-sm text-gray-700">非公開</label>
                                </div>
                            </div>
                        </div>

                        <!-- 送信ボタン -->
                        <div class="flex justify-end">
                            <a href="{{ route('taxminivideos.manage') }}"
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">キャンセル</a>
                            <button type="button" @click.prevent="showModal = true" x-bind:disabled="title === '' || !videoSelected"
                                class="ml-3 px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">動画を投稿</button>
                        </div>

                        <!-- Confirmation Modal -->
                        <div x-show="showModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50" style="display: none;">
                            <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full mx-4">
                                <p class="mb-4">この内容でいいですか？</p>
                                <div class="mb-4">
                                    <p class="font-semibold">登録情報:</p>
                                    <p>タイトル: <span x-text="title"></span></p>
                                    <p>動画説明: <span x-text="description"></span></p>
                                    <p>公開設定: <span x-text="visibility"></span></p>
                                </div>
                                <div class="flex justify-end">
                                    <button @click="showModal = false" class="px-4 py-2 bg-gray-300 rounded-md mr-2">キャンセル</button>
                                    <button @click="$refs.form.submit()" class="px-4 py-2 bg-blue-600 text-white rounded-md">確認</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <!-- サムネイルプレビューのスクリプト -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const thumbnailInput = document.getElementById('thumbnail');
            const thumbnailPreview = document.getElementById('thumbnailPreview');

            thumbnailInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        thumbnailPreview.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-full object-cover rounded-lg" />
                        `;
                    }

                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
