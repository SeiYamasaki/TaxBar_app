<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TaxBar®️は八幡平市から始まりました｡">
    <title>TaxBar® | 八幡平市</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <!-- ヘッダー -->
    @include('components.header')

    <!-- 背景動画 -->
                {{-- <li><a href="/view/hachimantaishi">八幡平市</a></li> --}}
    <div class="video-container">
        <video autoplay muted loop poster="{{ asset('images/fallback.jpg') }}">
            <source src="{{ asset('videos/hachimantai_v7.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <!-- 動画の下のコンテンツ -->
    <div class="content">
        <h1 class="py-10 text-gray-800 text-3xl font-bold">八幡平市初動｡</h1>
        <p class="pb-10 text-gray-800 text-xl">そこには物語があります｡</p>
    </div>
    <!-- フッター -->
    @include('components.footer')

</body>
