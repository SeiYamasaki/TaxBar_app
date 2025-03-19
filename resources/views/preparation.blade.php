<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>相続の準備</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="flex flex-col items-center min-h-screen bg-gray-100">
    @include('components.header')

    <div class="w-3/4 bg-white p-12 rounded-xl shadow-xl mt-8">
        <h1 class="text-5xl font-bold text-gray-800 text-center mt-20">相続の準備</h1>
        <p class="mt-8 text-xl text-gray-700 text-center leading-relaxed">
            ここでは、相続の準備に関する詳細を確認できます。
        </p>

        <!-- 8つの画像を1列でフル幅 & 余白なし -->
        <div class="mt-12 flex flex-col">
            <img src="{{ asset('images/junbi_1.png') }}" alt="準備ステップ1" class="w-full">
            <img src="{{ asset('images/junbi_2.png') }}" alt="準備ステップ2" class="w-full">
            <img src="{{ asset('images/junbi_3.png') }}" alt="準備ステップ3" class="w-full">
            <img src="{{ asset('images/junbi_4.png') }}" alt="準備ステップ4" class="w-full">
            <img src="{{ asset('images/junbi_5.png') }}" alt="準備ステップ5" class="w-full">
            <img src="{{ asset('images/junbi_6.png') }}" alt="準備ステップ6" class="w-full">
            <img src="{{ asset('images/junbi_7.png') }}" alt="準備ステップ7" class="w-full">
            <img src="{{ asset('images/junbi_8.png') }}" alt="準備ステップ8" class="w-full">
        </div>

        <div class="mt-12 p-8 bg-gray-50 rounded-xl">
            <h2 class="text-3xl font-bold text-gray-800">準備のステップ</h2>
            <p class="mt-4 text-xl text-gray-700 leading-relaxed">
                以下の準備を順番に進めてください。
            </p>

            <ul class="list-disc list-inside mt-6 text-xl leading-relaxed">
                <li class="text-red-500 font-semibold">財産リストの作成</li>
                <li class="text-blue-500 font-semibold">遺言書の準備</li>
                <li class="text-green-500 font-semibold">相続人の確認</li>
                <li class="text-purple-500 font-semibold">税金対策</li>
                <li class="text-orange-500 font-semibold">遺産分割のシミュレーション</li>
                <li class="text-teal-500 font-semibold">専門家への相談</li>
            </ul>
        </div>

        <!-- 戻るボタン -->
        <div class="mt-14 text-center">
            <a href="/souzoku-tax"
                class="px-10 py-5 bg-gray-600 text-white text-xl rounded-xl hover:bg-gray-700 transition shadow-lg">
                ← 戻る
            </a>
        </div>
    </div>
</body>

</html>
