<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar&reg | TaxMinutes&reg</title>
    <link rel="stylesheet" href="{{ asset('css/taxministyle.css') }}">
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
                @for ($i = 1; $i <= 6; $i++)
                    <div class="video-card">
                        <a href="#">
                            <video controls>
                                <source src="https://samplelib.com/lib/preview/mp4/sample-5s.mp4" type="video/mp4">
                                お使いのブラウザは動画タグをサポートしていません。
                            </video>
                            <h3>◯◯◯◯会計事務所 TaxMinutes&reg 動画 {{ $i }}</h3>
                        </a>
                    </div>
                @endfor
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
