<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar®️ | テーマ</title>
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>

<body>
    <!-- ヘッダー -->
    @include('components.header')
    <!-- 背景動画 -->
    <div class="video-container">
        <video autoplay muted loop>
            <source src="{{ asset('videos/themeback.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    
</body>

</html>
