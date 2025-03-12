<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar&reg | TaxMinutes&reg</title>
    <link rel="stylesheet" href="{{ asset('css/taxministyle.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <!-- ヘッダー -->
    @include('components.header')
    <!-- 背景動画 -->
    <div class="video-container">
        <video autoplay muted loop>
            <source src="{{ asset('videos/taxminivideoback.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    <!-- メインコンテンツ -->
    <main>
        <div class="container">
            <h2>TaxMinutes&reg動画一覧</h2>
            <div class="video-grid">
                @foreach ($videos as $video)
                    <div class="video-card">
                        <a href="{{ route('taxminivideos.show', $video->id) }}" class="block hover:opacity-90 transition-opacity duration-300">
                            <div class="relative overflow-hidden rounded-lg shadow-md">
                                <video controls class="w-full h-48 object-cover">
                                    <source src="{{ $video->video_url }}" type="video/mp4">
                                    お使いのブラウザは動画タグをサポートしていません。
                                </video>
                            </div>
                            <h3 class="text-lg font-bold text-black mt-3 truncate">{{ $video->title }}</h3>
                            <div class="flex items-center mt-2 bg-gray-50 p-2 rounded-lg">
                                <div class="mr-3">
                                    @if($video->expert_photo_url)
                                        <img src="{{ asset('storage/' . $video->expert_photo_url) }}" alt="専門家の写真" class="user-icon rounded-full w-12 h-12 object-cover border-2 border-gray-200">
                                    @else
                                        <svg class="w-12 h-12 text-gray-400 bg-gray-100 rounded-full border-2 border-gray-200 p-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-color-primary font-medium text-black">投稿者：{{ $video->user->name ?? $video->name }}</p>
                                </div>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('taxminivideos.show', $video->id) }}" class="text-color-primary font-medium text-black">コメントはこちらをクリック♪</a>
                            </div>
                        </a>
                    </div>

                @endforeach
            </div>
            <!-- ページネーション -->
            <!-- ✅ ページネーション（適切に表示） -->
            <div class="pagination">
                @if ($videos->hasPages())
                    {{ $videos->links('pagination::bootstrap-4') }}
                @endif
            </div>
        </div>
    </main>

    <!-- フッター -->
    @include('components.footer')

</body>

</html>
