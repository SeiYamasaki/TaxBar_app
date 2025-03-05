<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせ確認</title>
    <link rel="stylesheet" href="{{ asset('css/formstyle.css') }}">
    @vite('resources/css/app.css')
</head>

<body>
    @include('components.header')

        <!-- 中央ロゴ -->
    <div class="center-logo">
        <img src="{{ asset('images/logotoumei.png') }}" alt="中央ロゴ" class="h-24 ">
    </div>

    <div class=" justify-center container max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">お問い合わせ確認</h1>

        <p class="mb-2"><strong>お名前:</strong> {{ $name }}</p>
        <p class="mb-2"><strong>メールアドレス:</strong> {{ $email }}</p>
        <p class="mb-2"><strong>電話番号:</strong> {{ $phone }}</p>
        <p class="mb-2"><strong>お問い合わせ内容の種類:</strong> {{ $inquiry_type }}</p>
        <p class="mb-4"><strong>お問い合わせ内容:</strong><br>{{ nl2br(e($message ?? '内容がありません')) }}</p>

        <!-- 送信フォーム -->
        <form action="{{ route('inquiry.send') }}" method="POST" class="mb-4">
            @csrf
            <input type="hidden" name="name" value="{{ $name }}">
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="phone" value="{{ $phone }}">
            <input type="hidden" name="inquiry_type" value="{{ $inquiry_type }}">
            <input type="hidden" name="message" value="{{ $message }}">
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">送信</button>
        </form>

        <!-- 戻るボタン -->
        <button onclick="history.back()" class="text-blue-500 hover:underline hover:text-white">戻る</button>
    </div>
</body>

@include('components.footer')

</html>
