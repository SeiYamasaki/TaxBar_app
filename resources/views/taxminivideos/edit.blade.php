<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>動画を編集 - TaxBar®️</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/taxministyle.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col min-h-full bg-gray-100">
    @include('components.header')

    <!-- ヘッダーの高さ分のスペーサー -->
    <div class="h-16"></div>

    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg p-8 max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">動画を編集</h1>

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('taxminivideos.update', $video->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">タイトル</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $video->title) }}"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">説明</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $video->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="prefecture" class="block text-sm font-medium text-gray-700 mb-1">関連都道府県</label>
                    <select name="prefecture" id="prefecture"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">選択してください</option>
                        <option value="北海道" {{ old('prefecture', $video->prefecture) == '北海道' ? 'selected' : '' }}>
                            北海道</option>
                        <option value="青森県" {{ old('prefecture', $video->prefecture) == '青森県' ? 'selected' : '' }}>
                            青森県</option>
                        <option value="岩手県" {{ old('prefecture', $video->prefecture) == '岩手県' ? 'selected' : '' }}>
                            岩手県</option>
                        <!-- 他の都道府県もここに追加 -->
                        <option value="東京都" {{ old('prefecture', $video->prefecture) == '東京都' ? 'selected' : '' }}>
                            東京都</option>
                        <option value="大阪府" {{ old('prefecture', $video->prefecture) == '大阪府' ? 'selected' : '' }}>
                            大阪府</option>
                        <option value="沖縄県" {{ old('prefecture', $video->prefecture) == '沖縄県' ? 'selected' : '' }}>
                            沖縄県</option>
                    </select>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">現在の動画</h3>
                    <div class="bg-gray-50 p-4 rounded">
                        <video controls class="w-full max-h-64 rounded">
                            <source src="{{ $video->video_url }}" type="video/mp4">
                            お使いのブラウザは動画再生に対応していません。
                        </video>
                    </div>

                    <div class="mt-4">
                        <label for="video"
                            class="block text-sm font-medium text-gray-700 mb-1">新しい動画ファイル（変更する場合のみ）</label>
                        <input type="file" name="video" id="video"
                            accept="video/mp4,video/quicktime,video/x-msvideo,video/x-flv,video/x-ms-wmv"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-sm text-gray-500 mt-1">最大ファイルサイズ: 100MB</p>
                        @error('video')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">サムネイル</h3>

                    @if ($video->thumbnail_path)
                        <div class="bg-gray-50 p-4 rounded mb-4">
                            <img src="{{ $video->thumbnail_url }}" alt="現在のサムネイル" class="max-h-40 rounded mx-auto">
                        </div>
                    @else
                        <p class="text-gray-500 mb-4">サムネイルはまだ設定されていません</p>
                    @endif

                    <div>
                        <label for="thumbnail"
                            class="block text-sm font-medium text-gray-700 mb-1">新しいサムネイル画像（変更する場合のみ）</label>
                        <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-sm text-gray-500 mt-1">最大ファイルサイズ: 20MB</p>
                        @error('thumbnail')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-between pt-6">
                    <a href="{{ route('dashboard') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                        キャンセル
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                        更新する
                    </button>
                </div>
            </form>
        </div>
    </main>

    @include('components.footer')
</body>

</html>
