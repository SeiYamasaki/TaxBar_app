<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>相続税の計算</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="flex flex-col items-center min-h-screen bg-gray-100">
    @include('components.header')

    <div class="w-full bg-white p-12 shadow-xl mt-8">
        <h1 class="text-5xl font-bold text-gray-800 text-center mt-20">相続税の計算</h1>
        <p class="mt-8 text-xl text-gray-700 text-center leading-relaxed">
            ここでは、相続税の計算方法について詳しくご案内します。
        </p>


        <!-- 8つの画像を1列でフル幅 & 余白なし -->
        <div class="mt-12 flex flex-col">
            <img src="{{ asset('images/souzokucalc_1.png') }}" alt="計算ステップ1" class="w-full">
            <img src="{{ asset('images/souzokucalc_2.png') }}" alt="計算ステップ2" class="w-full">
            <img src="{{ asset('images/souzokucalc_3.png') }}" alt="計算ステップ3" class="w-full">
            <img src="{{ asset('images/souzokucalc_4.png') }}" alt="計算ステップ4" class="w-full">
            <img src="{{ asset('images/souzokucalc_5.png') }}" alt="計算ステップ5" class="w-full">
            <img src="{{ asset('images/souzokucalc_6.png') }}" alt="計算ステップ6" class="w-full">
            <img src="{{ asset('images/souzokucalc_7.png') }}" alt="計算ステップ7" class="w-full">
            <img src="{{ asset('images/souzokucalc_8.png') }}" alt="計算ステップ8" class="w-full">
        </div>

        <div class="mt-12 p-8 bg-gray-50 rounded-xl">
            <h2 class="text-3xl font-bold text-gray-800">相続税の計算ステップ</h2>
            <p class="mt-4 text-xl text-gray-700 leading-relaxed">
                以下のステップに従って、相続税の計算を進めてください。
            </p>

            <ul class="list-disc list-inside mt-6 text-xl leading-relaxed">
                <li class="text-red-500 font-semibold">課税対象の財産評価</li>
                <li class="text-blue-500 font-semibold">基礎控除額の計算</li>
                <li class="text-green-500 font-semibold">法定相続人ごとの税額計算</li>
                <li class="text-purple-500 font-semibold">適用される税率の確認</li>
                <li class="text-orange-500 font-semibold">税額控除の適用</li>
                <li class="text-teal-500 font-semibold">納税スケジュールの確認</li>
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
