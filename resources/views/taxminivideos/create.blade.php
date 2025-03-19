<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar®️ | 動画管理</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="flex h-full bg-gray-100">
    <x-tax-advisor.sidebar :user="$user" />

    <main class="flex-1 container mx-auto px-4 py-8">
        <div class="container">
            <h1>TaxMinutes - 動画投稿</h1>

            <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">動画タイトル</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="video" class="form-label">動画ファイル</label>
                    <input type="file" name="video" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">投稿</button>
            </form>
        </div>
    </main>
</body>

</html>
