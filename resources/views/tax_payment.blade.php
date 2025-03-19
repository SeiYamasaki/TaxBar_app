<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>相続税の納付</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="flex flex-col items-center min-h-screen bg-gray-100">
    @include('components.header')

    <div class="w-full bg-white p-12 shadow-xl mt-8">
        <h1 class="text-5xl font-bold text-gray-800 text-center mt-20">相続税の納付</h1>
        <p class="mt-8 text-xl text-gray-700 text-center leading-relaxed">
            ここでは、相続税の納付方法について詳しくご案内します。
        </p>

        <!-- 8つの画像を1列でフル幅 & 余白なし -->
        <div class="mt-12 flex flex-col">
            <img src="{{ asset('images/payment_1.png') }}" alt="納付ステップ1" class="w-full">
            <img src="{{ asset('images/payment_2.png') }}" alt="納付ステップ2" class="w-full">
            <img src="{{ asset('images/payment_3.png') }}" alt="納付ステップ3" class="w-full">
            <img src="{{ asset('images/payment_4.png') }}" alt="納付ステップ4" class="w-full">
            <img src="{{ asset('images/payment_5.png') }}" alt="納付ステップ5" class="w-full">
            <img src="{{ asset('images/payment_6.png') }}" alt="納付ステップ6" class="w-full">
            <img src="{{ asset('images/payment_7.png') }}" alt="納付ステップ7" class="w-full">
            <img src="{{ asset('images/payment_8.png') }}" alt="納付ステップ8" class="w-full">
        </div>

        <div class="mt-12 p-8 bg-gray-50 rounded-xl">
            <h2 class="text-3xl font-bold text-gray-800">相続税の納付ステップ</h2>
            <p class="mt-4 text-xl text-gray-700 leading-relaxed">
                以下の手順に従って、相続税の納付を行いましょう。
            </p>

            <ul class="list-disc list-inside mt-6 text-xl leading-relaxed">
                <li class="text-red-500 font-semibold">納付期限の確認</li>
                <li class="text-blue-500 font-semibold">納付方法の選択（銀行・オンライン）</li>
                <li class="text-green-500 font-semibold">分割払いの検討</li>
                <li class="text-purple-500 font-semibold">延納・物納の利用</li>
                <li class="text-orange-500 font-semibold">税務署への申請</li>
                <li class="text-teal-500 font-semibold">納税証明書の取得</li>
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
