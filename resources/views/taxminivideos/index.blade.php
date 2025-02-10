<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxMiniVideos</title>
    <link rel="stylesheet" href="{{ asset('css/taxministyle.css') }}">
</head>
<!-- ヘッダー -->
    <header class="header">
        <!-- ロゴ -->
        <div class="logo">
            <a href="/view/login">
                <img src="{{ asset('images/logo.png') }}" alt="ロゴ">
            </a>
        </div>
        <!-- ナビゲーション -->
        <nav class="nav">
            <ul>
                <li><a href="/">HOME</a></li>
                <li><a href="/taxminivideos">Tax Minutes&reg</a></li>
                <li><a href="#TaxBarabout">テーマ</a></li>
                {{-- <li><a href="/view/prohibited">禁止事項</a></li> --}}
                <li><a href="/inquiry">問合せ</a></li>
                <li><a href="/view/hachimantaishi">八幡平市</a></li>
                <li><a href="/faq">よくある質問</a></li>
                <li><a href="/pricing">料金表</a></li>
                <li><a href="/register/select">登録フォーム</a></li>
                <li><a href="/login">ログイン</a></li>
            </ul>
        </nav>
    </header>
<body>
    <header>
        <div class="container">
            <h1><a href="/">Tax Minutes&reg</a></h1>
            <nav>
                <ul>
                    <li><a href="{{ route('taxminivideos.index') }}">動画一覧</a></li>
                    @auth
                        @can('tax-accountant')
                            <li><a href="{{ route('videos.create') }}">動画を投稿</a></li>
                        @endcan
                    @endauth
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <h2>動画一覧</h2>
            <div class="video-grid">
                @foreach ($videos as $video)
                    <div class="video-card">
                        <a href="{{ route('videos.show', $video->id) }}">
                            <img src="{{ asset('storage/' . $video->video_path) }}" alt="動画のサムネイル">
                            <h3>{{ $video->title }}</h3>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="pagination">
                {{ $videos->links() }}
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 TaxBar&reg Tax Minutes&reg. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
