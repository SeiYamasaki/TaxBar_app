<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせ確認</title>
</head>

<body>
    <h1>お問い合わせ確認</h1>

    <p><strong>お名前:</strong> {{ $name }}</p>
    <p><strong>メールアドレス:</strong> {{ $email }}</p>
    <p><strong>電話番号:</strong> {{ $phone }}</p>
    <p><strong>お問い合わせ内容の種類:</strong> {{ $inquiry_type }}</p>
    <p><strong>お問い合わせ内容:</strong><br>{{ nl2br(e($message ?? '内容がありません')) }}</p>

    <!-- 送信フォーム -->
    <form action="{{ route('inquiry.send') }}" method="POST">
        @csrf
        <input type="hidden" name="name" value="{{ $name }}">
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="phone" value="{{ $phone }}">
        <input type="hidden" name="inquiry_type" value="{{ $inquiry_type }}">
        <input type="hidden" name="message" value="{{ $message }}">
        <button type="submit">送信</button>
    </form>

    <!-- 戻るボタン -->
    <button onclick="history.back()">戻る</button>
</body>

</html>
