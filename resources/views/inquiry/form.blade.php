<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar&reg | お問合わせフォーム</title>
    <link rel="stylesheet" href="{{ asset('css/formstyle.css') }}">
</head>

<body>
    <!-- ヘッダー -->
    @include('components.header')

    <!-- 中央ロゴ -->
    <div class="center-logo">
        <img src="{{ asset('images/logotoumei.png') }}" alt="中央ロゴ">
    </div>

    <!-- お問い合わせフォーム -->
    <div class="container">
        <div class="form-wrapper">
            <h1>お問い合わせフォーム</h1>

            <form action="{{ route('inquiry.confirm') }}" method="POST">
                @csrf
                <label for="name">お名前:</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>

                <label for="email">メールアドレス:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>

                <label for="phone">電話番号:</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required>

                <label>お問い合わせ種類:</label>
                <select name="inquiry_type" required>
                    <option value="TaxBar&reg出店について">TaxBar&reg出店について</option>
                    <option value="通報の件">通報の件</option>
                    <option value="料金について">料金について</option>
                    <option value="TaxMinutes&regについて">TaxMinutes&regについて</option>
                    <option value="禁止事項について">禁止事項について</option>
                    <option value="その他">その他</option>
                </select>

                <label for="message">お問い合わせ内容:</label>
                <textarea id="message" name="message" rows="5" required>{{ old('message') }}</textarea>

                <button type="submit">確認画面へ</button>
            </form>
        </div>
    </div>

    <!-- フッター -->
    @include('components.footer')

</body>

</html>
