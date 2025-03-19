<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>相続手続きの詳細</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="flex flex-col items-center min-h-screen bg-gray-100">
    @include('components.header')

    <div class="w-3/4 bg-white p-12 rounded-xl shadow-xl mt-8">
        <h1 class="text-5xl font-bold text-gray-800 text-center mt-20">相続手続きの確認</h1>
        <p class="mt-8 text-xl text-gray-700 text-center leading-relaxed">
            ここでは、相続手続きの詳細を確認できます。
        </p>

        <!-- メインの流れ画像 -->
        <div class="mt-10 flex justify-center">
            <img src="{{ asset('images/souzoku_10.jpeg') }}" alt="相続手続きの流れ" class="w-full rounded-xl shadow-md">
        </div>

        <!-- 8つの画像を1列でフル幅 & 余白なし -->
        <div class="mt-12 flex flex-col">
            <img src="{{ asset('images/tetsuduki_1.png') }}" alt="ステップ1" class="w-full">
            <img src="{{ asset('images/tetsuduki_2.png') }}" alt="ステップ2" class="w-full">
            <img src="{{ asset('images/tetsuduki_3.png') }}" alt="ステップ3" class="w-full">
            <img src="{{ asset('images/tetsuduki_4.png') }}" alt="ステップ4" class="w-full">
            <img src="{{ asset('images/tetsuduki_5.png') }}" alt="ステップ5" class="w-full">
            <img src="{{ asset('images/tetsuduki_6.png') }}" alt="ステップ6" class="w-full">
            <img src="{{ asset('images/tetsuduki_7.png') }}" alt="ステップ7" class="w-full">
            <img src="{{ asset('images/tetsuduki_8.png') }}" alt="ステップ8" class="w-full">
        </div>

        <div class="mt-12 p-8 bg-gray-50 rounded-xl">
            <h2 class="text-3xl font-bold text-gray-800">手続きのステップ</h2>
            <p class="mt-4 text-xl text-gray-700 leading-relaxed">
                以下の手続きを順番に進めてください。
            </p>

            <ul class="list-disc list-inside mt-6 text-xl leading-relaxed">
                <li class="text-red-500 font-semibold">死亡届の提出（7日以内）</li>
                <li class="text-blue-500 font-semibold">火葬許可証の取得（14日以内）</li>
                <li class="text-green-500 font-semibold">相続人の調査（3か月以内）</li>
                <li class="text-purple-500 font-semibold">財産調査（3か月以内）</li>
                <li class="text-orange-500 font-semibold">相続税申告（10か月以内）</li>
                <li class="text-teal-500 font-semibold">不動産名義変更（順次）</li>
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
