<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar® | 相続でお困りの方へ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        html {
            font-size: 18px !important;
            /* デフォルトの16pxより大きく */
        }

        body {
            font-size: 1.3rem !important;
            /* 16px × 1.3 = 約20.8px */
            margin: 0 !important;
            padding: 0 !important;
            overflow-x: hidden !important;
        }

        /* 背景動画のスタイル */
        .video-background {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            z-index: -1 !important;
        }

        .content-container {
            position: relative !important;
            z-index: 10 !important;
            color: white !important;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7) !important;
            min-height: 100vh !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: flex-end !important;
            padding: 50px 20px !important;
            text-align: center !important;
        }

        main {
            position: relative !important;
            z-index: 10 !important;
            background: rgba(0, 0, 0, 0.5) !important;
            padding: 50px 20px !important;
            color: white !important;
            max-width: 1800px !important;
            margin: auto !important;
        }

        .spacer {
            height: 300px !important;
            background-color: white !important;
        }

        /* スマホ対応 */
        @media screen and (max-width: 768px) {
            html {
                font-size: 16px !important;
            }

            body {
                font-size: 1.2rem !important;
            }

            .content-container {
                padding: 10px 10px !important;
                text-align: center !important;
                justify-content: center !important;
            }

            main {
                padding: 30px 15px !important;
            }

            .spacer {
                height: 150px !important;
            }
        }
    </style>

</head>

<body class="bg-gray-100">
    <video autoplay muted loop class="video-background">
        <source src="{{ asset('videos/souzoku_pv.mp4') }}" type="video/mp4">
        お使いのブラウザは動画タグをサポートしていません。
    </video>

    @include('components.header')

    <div class="content-container">
        <h1 class="text-3xl font-bold">相続税のページへようこそ</h1>
    </div>

    <main class="bg-white text-gray-900">
        <section class="max-w-4xl mx-auto text-center">
            <p class="text-lg">相続税に関するお悩みを解決するための情報をご提供します。</p>
            <p class="mt-4">公認会計士･税理士によるTaxBar®相談を受け付けています。</p>
        </section>

        <div class="flex justify-center items-center w-full">
            <div class="max-w-7xl flex justify-center">
                <img src="{{ asset('images/souzoku_10.jpeg') }}" alt="メッセージ画像"
                    class="w-full h-auto rounded-lg shadow-lg opacity-50">
            </div>
        </div>


        <section class="max-w-6xl w-full mx-auto mt-10 bg-white text-gray-900 p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold">相続税とは？</h2>
            <p class="mt-2">相続税は、亡くなった方（被相続人）の財産を相続した際に発生する税金です。<br>主に現金、土地、建物、株式などの資産が課税対象となります。</p>
            <p class="mt-2">相続税の計算は、基礎控除額（3,000万円＋600万円×法定相続人の数）を超えた金額に対して税率が適用されます。</p>
        </section>

        {{-- <div class="flex justify-center items-center mt-10">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-6xl w-full text-center">
                <h2 class="text-2xl font-bold text-gray-800">相続税についてもっと知りたい方へ</h2>
                <p class="mt-2 text-gray-700">相続税の仕組みや節税対策について、詳しく解説した無料ガイドブックを配布しています。</p>
                <p class="mt-2 text-gray-700">お気軽にダウンロードし、必要な情報を得てください。</p>
                <div class="mt-4">
                    <a href="/download"
                        class="px-6 py-3 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                        無料ガイドをダウンロード
                    </a>
                </div>
            </div>
        </div> --}}

        <!-- ここからコンテンツ -->
        <section class="max-w-6xl w-full mx-auto mt-10 flex items-center gap-6">
            <div class="w-1/3 flex-shrink-0">
                <img src="{{ asset('images/souzoku_1.jpeg') }}" alt="メッセージ画像"
                    class="w-full h-auto rounded-lg shadow-lg">
            </div>
            <div class="w-2/3 bg-white p-6 rounded-lg shadow-lg flex flex-col justify-center">
                <h2 class="text-xl font-bold text-gray-800">相続に関する重要なメッセージ</h2>
                <p class="mt-2 text-gray-700">相続手続きには多くの法的要件が関わります。適切なアドバイスを受けることで、スムーズに進めることが可能です。</p>
                <p class="mt-2 text-gray-700">TaxBar®の相続専門の税理士や専門家が、あなたのサポートを実現します｡相続税の申告が本当に不要なのか､必要なのかまずは徹底解決します｡</p>
                <div class="mt-4">
                    <a href="{{ route('inheritance_tax') }}"
                        class="px-6 py-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                        解説
                    </a>
                </div>
            </div>
        </section>

        <section class="max-w-6xl w-full mx-auto mt-10 flex items-center gap-10">
            <!-- 左側のテキストコンテンツ -->
            <div class="w-2/3 bg-white p-6 rounded-lg shadow-lg flex flex-col justify-center">
                <h2 class="text-2xl font-bold text-gray-800">相続手続きの流れ</h2>
                <p class="mt-4 text-lg text-gray-700 leading-relaxed">
                    相続には複雑な手続きが伴いますが、専門家のサポートを受けることでスムーズに進めることが可能です。
                </p>
                <p class="mt-4 text-lg text-gray-700 leading-relaxed">
                    相続財産の調査、遺産分割協議、税務申告など、一連の流れを詳しくご案内します。
                </p>
                <div class="mt-6">
                    <a href="/inheritance-process"
                        class="px-6 py-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                        確認
                    </a>
                </div>
            </div>

            <!-- 右側の画像 -->
            <div class="w-1/3 flex-shrink-0">
                <img src="{{ asset('images/souzoku_2.jpeg') }}" alt="手続きの流れ"
                    class="w-full h-auto rounded-lg shadow-lg">
            </div>
        </section>

        <section class="max-w-6xl w-full mx-auto mt-10 flex items-center gap-6">
            <div class="w-1/3 flex-shrink-0">
                <img src="{{ asset('images/souzoku_3.jpeg') }}" alt="相続の準備"
                    class="w-full h-auto rounded-lg shadow-lg">
            </div>
            <div class="w-2/3 bg-white p-6 rounded-lg shadow-lg flex flex-col justify-center">
                <h2 class="text-xl font-bold text-gray-800">相続の準備</h2>
                <p class="mt-2 text-gray-700">相続の準備を進めることで、将来的なトラブルを回避できます。遺言書の作成や財産の整理について詳しくご案内します。</p>
                <div class="mt-4">
                    <a href="/inheritance-preparation"
                        class="px-6 py-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">確認</a>
                </div>
            </div>
        </section>

        <section class="max-w-6xl w-full mx-auto mt-10 flex items-center gap-6">
            <div class="w-2/3 bg-white p-6 rounded-lg shadow-lg flex flex-col justify-center">
                <h2 class="text-xl font-bold text-gray-800">相続税の計算方法</h2>
                <p class="mt-2 text-gray-700">相続税の計算方法を正しく理解し、納税計画を立てることが重要です。基本的な計算式と控除の仕組みをご紹介します。</p>
                <div class="mt-4">
                    <a href="/tax-calculation"
                        class="px-6 py-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">確認</a>
                </div>
            </div>
            <div class="w-1/3 flex-shrink-0">
                <img src="{{ asset('images/souzoku_4.jpeg') }}" alt="相続税の計算方法"
                    class="w-full h-auto rounded-lg shadow-lg">
            </div>
        </section>



        <section class="max-w-6xl w-full mx-auto mt-10 flex items-center gap-6">
            <div class="w-1/3 flex-shrink-0">
                <img src="{{ asset('images/souzoku_5.jpeg') }}" alt="節税対策"
                    class="w-full h-auto rounded-lg shadow-lg">
            </div>
            <div class="w-2/3 bg-white p-6 rounded-lg shadow-lg flex flex-col justify-center">
                <h2 class="text-xl font-bold text-gray-800">相続税の節税対策</h2>
                <p class="mt-2 text-gray-700">相続税を最小限に抑えるための節税対策をご紹介します。生前贈与や保険の活用など、具体的な方法を解説します。</p>
                <div class="mt-4">
                    <a href="/tax-saving"
                        class="px-6 py-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">確認</a>
                </div>
            </div>
        </section>

        <section class="max-w-6xl w-full mx-auto mt-10 flex items-center gap-6">
            <div class="w-2/3 bg-white p-6 rounded-lg shadow-lg flex flex-col justify-center">
                <h2 class="text-xl font-bold text-gray-800">相続トラブルを防ぐ</h2>
                <p class="mt-2 text-gray-700">相続に関するトラブルを未然に防ぐためのポイントを解説します。円満な相続を実現するための方法を学びましょう。</p>
                <div class="mt-4">
                    <a href="/trouble-prevention"
                        class="px-6 py-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">確認</a>
                </div>
            </div>
            <div class="w-1/3 flex-shrink-0">
                <img src="{{ asset('images/souzoku_6.jpeg') }}" alt="相続トラブル防止"
                    class="w-full h-auto rounded-lg shadow-lg">
            </div>
        </section>

        <section class="max-w-6xl w-full mx-auto mt-10 flex items-center gap-6">
            <div class="w-1/3 flex-shrink-0">
                <img src="{{ asset('images/souzoku_7.jpeg') }}" alt="相続相談"
                    class="w-full h-auto rounded-lg shadow-lg">
            </div>
            <div class="w-2/3 bg-white p-6 rounded-lg shadow-lg flex flex-col justify-center">
                <h2 class="text-xl font-bold text-gray-800">TaxBar®で税理士に相談する</h2>
                <p class="mt-2 text-gray-700">相続の悩みを専門家に相談し、最適なアドバイスを受けることで、安心して相続手続きを進められます。</p>
                <div class="mt-4">
                    <a href="/view/theme"
                        class="px-6 py-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">相談する</a>
                </div>
            </div>
        </section>

        <section class="max-w-6xl w-full mx-auto mt-10 flex items-center gap-6">
            <div class="w-2/3 bg-white p-6 rounded-lg shadow-lg flex flex-col justify-center">
                <h2 class="text-xl font-bold text-gray-800">相続財産の評価</h2>
                <p class="mt-2 text-gray-700">相続財産の評価は、税額計算の基礎となります。評価方法を正しく理解し、適正な申告を行いましょう。</p>
                <div class="mt-4">
                    <a href="/property-valuation"
                        class="px-6 py-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">確認</a>
                </div>
            </div>
            <div class="w-1/3 flex-shrink-0">
                <img src="{{ asset('images/souzoku_8.jpeg') }}" alt="相続財産の評価"
                    class="w-full h-auto rounded-lg shadow-lg">
            </div>
        </section>

        <section class="max-w-6xl w-full mx-auto mt-10 flex items-center gap-6">
            <div class="w-1/3 flex-shrink-0">
                <img src="{{ asset('images/souzoku_9.jpeg') }}" alt="相続税の納税方法"
                    class="w-full h-auto rounded-lg shadow-lg">
            </div>
            <div class="w-2/3 bg-white p-6 rounded-lg shadow-lg flex flex-col justify-center">
                <h2 class="text-xl font-bold text-gray-800">相続税の納税方法</h2>
                <p class="mt-2 text-gray-700">相続税の納付にはいくつかの方法があります。延納や物納などの選択肢を知り、計画的に納税を行いましょう。</p>
                <div class="mt-4">
                    <a href="/tax-payment"
                        class="px-6 py-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">確認</a>
                </div>
            </div>
        </section>
        <div class="flex justify-center items-center w-full">
            <div class="max-w-7xl flex justify-center">
                <img src="{{ asset('images/souzoku_11.jpeg') }}" alt="メッセージ画像"
                    class="w-full h-auto rounded-lg shadow-lg opacity-60">
            </div>
        </div>
    </main>
    @include('components.footer')
</body>

</html>
