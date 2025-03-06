<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar&reg | お問合わせフォーム</title>
    <link rel="stylesheet" href="{{ asset('css/formstyle.css') }}">
    @vite('resources/css/app.css')
</head>

<body>
    <!-- ヘッダー -->
    @include('components.header')

    <!-- 中央ロゴ -->
    <div class="center-logo">
        <img src="{{ asset('images/logotoumei.png') }}" alt="中央ロゴ">
    </div>

    <!-- お問い合わせフォーム -->
    <div class="container max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">お問い合わせフォーム</h2>

        <form action="{{ route('inquiry.confirm') }}" method="POST">
            @csrf
            <label for="name" class="block text-lg font-semibold mb-2">お名前:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">

            <label for="email" class="block text-lg font-semibold mt-4 mb-2">メールアドレス:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">

            <label for="phone" class="block text-lg font-semibold mt-4 mb-2">電話番号:</label>
            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">

            <label class="block text-lg font-semibold mt-4 mb-2">お問い合わせ種類:</label>
            <select name="inquiry_type" required class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="TaxBar&reg出店について">TaxBar&reg出店について</option>
                <option value="通報の件">通報の件</option>
                <option value="料金について">料金について</option>
                <option value="TaxMinutes&regについて">TaxMinutes&regについて</option>
                <option value="禁止事項について">禁止事項について</option>
                <option value="その他">その他</option>
            </select>

            <label for="message" class="block text-lg font-semibold mt-4 mb-2">お問い合わせ内容:</label>
            <textarea id="message" name="message" rows="5" required class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('message') }}</textarea>

            <button type="submit" class="w-full mt-6 p-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-md transition">確認画面へ</button>
        </form>
    </div>

    

    <!-- フッター -->
    @include('components.footer')

</body>

</html>
