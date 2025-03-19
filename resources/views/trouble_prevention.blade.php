<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>相続トラブル防止策</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="flex flex-col items-center min-h-screen bg-gray-100">
    @include('components.header')

    <div class="w-full bg-white p-12 shadow-xl mt-8">
        <h1 class="text-5xl font-bold text-gray-800 text-center mt-20">相続トラブル防止策</h1>
        <p class="mt-8 text-xl text-gray-700 text-center leading-relaxed">
            ここでは、相続におけるトラブルを防ぐための方法について詳しくご案内します。
        </p>

        <!-- 8つの画像を1列でフル幅 & 余白なし -->
        <div class="mt-12 flex flex-col">
            <img src="{{ asset('images/torabule_1.png') }}" alt="トラブル防止ステップ1" class="w-full">
            <img src="{{ asset('images/torabule_2.png') }}" alt="トラブル防止ステップ2" class="w-full">
            <img src="{{ asset('images/torabule_3.png') }}" alt="トラブル防止ステップ3" class="w-full">
            <img src="{{ asset('images/torabule_4.png') }}" alt="トラブル防止ステップ4" class="w-full">
            <img src="{{ asset('images/torabule_5.png') }}" alt="トラブル防止ステップ5" class="w-full">
            <img src="{{ asset('images/torabule_6.png') }}" alt="トラブル防止ステップ6" class="w-full">
            <img src="{{ asset('images/torabule_7.png') }}" alt="トラブル防止ステップ7" class="w-full">
            <img src="{{ asset('images/torabule_8.png') }}" alt="トラブル防止ステップ8" class="w-full">
        </div>

        <div class="mt-12 p-8 bg-gray-50 rounded-xl">
            <h2 class="text-3xl font-bold text-gray-800">相続トラブルを防ぐためのステップ</h2>
            <p class="mt-4 text-xl text-gray-700 leading-relaxed">
                以下の方法を活用し、円滑な相続を実現しましょう。
            </p>

            <ul class="list-disc list-inside mt-6 text-xl leading-relaxed">
                <li class="text-red-500 font-semibold">遺言書の作成</li>
                <li class="text-blue-500 font-semibold">家族会議の開催</li>
                <li class="text-green-500 font-semibold">相続財産の明確化</li>
                <li class="text-purple-500 font-semibold">専門家（税理士・弁護士）への相談</li>
                <li class="text-orange-500 font-semibold">信託の活用</li>
                <li class="text-teal-500 font-semibold">生前贈与の検討</li>
            </ul>
        </div>

        <!-- 戻るボタン -->
        <div class="mt-8 text-center">
            <a href="/souzoku-tax"
                class="px-10 py-5 bg-gray-600 text-white text-xl rounded-xl hover:bg-gray-700 transition shadow-lg">
                ← 戻る
            </a>
        </div>
    </div>
</body>

</html>
