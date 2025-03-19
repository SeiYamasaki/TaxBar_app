<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>相続税の節税</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="flex flex-col items-center min-h-screen bg-gray-100">
    @include('components.header')

    <div class="w-full bg-white p-12 shadow-xl mt-8">
        <h1 class="text-5xl font-bold text-gray-800 text-center mt-20">相続税の節税</h1>
        <p class="mt-8 text-xl text-gray-700 text-center leading-relaxed">
            ここでは、相続税の節税対策について詳しくご案内します。
        </p>

        <!-- 8つの画像を1列でフル幅 & 余白なし -->
        <div class="mt-12 flex flex-col">
            <img src="{{ asset('images/saving_1.png') }}" alt="節税ステップ1" class="w-full">
            <img src="{{ asset('images/saving_2.png') }}" alt="節税ステップ2" class="w-full">
            <img src="{{ asset('images/saving_3.png') }}" alt="節税ステップ3" class="w-full">
            <img src="{{ asset('images/saving_4.png') }}" alt="節税ステップ4" class="w-full">
            <img src="{{ asset('images/saving_5.png') }}" alt="節税ステップ5" class="w-full">
            <img src="{{ asset('images/saving_6.png') }}" alt="節税ステップ6" class="w-full">
            <img src="{{ asset('images/saving_7.png') }}" alt="節税ステップ7" class="w-full">
            {{-- <img src="{{ asset('images/saving_8.png') }}" alt="節税ステップ8" class="w-full"> --}}
        </div>

        <div class="mt-12 p-8 bg-gray-50 rounded-xl">
            <h2 class="text-3xl font-bold text-gray-800">相続税の節税ステップ</h2>
            <p class="mt-4 text-xl text-gray-700 leading-relaxed">
                以下のステップに従って、相続税の節税対策を行いましょう。
            </p>

            <ul class="list-disc list-inside mt-6 text-xl leading-relaxed">
                <li class="text-red-500 font-semibold">贈与を活用する</li>
                <li class="text-blue-500 font-semibold">生命保険を活用する</li>
                <li class="text-green-500 font-semibold">小規模宅地の特例を適用</li>
                <li class="text-purple-500 font-semibold">不動産の活用</li>
                <li class="text-orange-500 font-semibold">法人設立による相続税対策</li>
                <li class="text-teal-500 font-semibold">税理士へ相談</li>
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
