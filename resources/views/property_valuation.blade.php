<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>財産評価の方法</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="flex flex-col items-center min-h-screen bg-gray-100">
    @include('components.header')

    <div class="w-full bg-white p-12 shadow-xl mt-8">
        <h1 class="text-5xl font-bold text-gray-800 text-center mt-20">財産評価の方法</h1>
        <p class="mt-8 text-xl text-gray-700 text-center leading-relaxed">
            ここでは、相続財産の評価方法について詳しくご案内します。
        </p>

        
        <!-- 8つの画像を1列でフル幅 & 余白なし -->
        <div class="mt-12 flex flex-col">
            <img src="{{ asset('images/valuation_1.png') }}" alt="評価ステップ1" class="w-full">
            <img src="{{ asset('images/valuation_2.png') }}" alt="評価ステップ2" class="w-full">
            <img src="{{ asset('images/valuation_3.png') }}" alt="評価ステップ3" class="w-full">
            <img src="{{ asset('images/valuation_4.png') }}" alt="評価ステップ4" class="w-full">
            <img src="{{ asset('images/valuation_5.png') }}" alt="評価ステップ5" class="w-full">
            <img src="{{ asset('images/valuation_6.png') }}" alt="評価ステップ6" class="w-full">
            <img src="{{ asset('images/valuation_7.png') }}" alt="評価ステップ7" class="w-full">
            {{-- <img src="{{ asset('images/valuation_8.png') }}" alt="評価ステップ8" class="w-full"> --}}
        </div>

        <div class="mt-12 p-8 bg-gray-50 rounded-xl">
            <h2 class="text-3xl font-bold text-gray-800">財産評価のステップ</h2>
            <p class="mt-4 text-xl text-gray-700 leading-relaxed">
                以下の方法を活用し、財産の適正な評価を行いましょう。
            </p>

            <ul class="list-disc list-inside mt-6 text-xl leading-relaxed">
                <li class="text-red-500 font-semibold">土地・不動産の評価</li>
                <li class="text-blue-500 font-semibold">預貯金の評価</li>
                <li class="text-green-500 font-semibold">株式・投資信託の評価</li>
                <li class="text-purple-500 font-semibold">生命保険の評価</li>
                <li class="text-orange-500 font-semibold">未公開株の評価</li>
                <li class="text-teal-500 font-semibold">専門家（税理士・鑑定士）への相談</li>
            </ul>
        </div>
        <!-- 戻るボタン -->
        <div class="mt-8 text-center">
            <a href="/souzoku-tax" class="px-10 py-5 bg-gray-600 text-white text-xl rounded-xl hover:bg-gray-700 transition shadow-lg">
                ← 戻る
            </a>
        </div>
    </div>
</body>
</html>
