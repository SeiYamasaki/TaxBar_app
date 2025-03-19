<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>相続税の申告 - 解説</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="flex flex-col items-center min-h-screen bg-gray-100">
    @include('components.header')

    <div class="w-3/4 bg-white p-12 rounded-xl shadow-xl mt-8">
        <!-- タイトル -->
        <h1 class="text-5xl font-bold text-gray-800 text-center mt-20">相続税の申告、本当に不要？</h1>
        <p class="mt-8 text-xl text-gray-700 text-center leading-relaxed">
            相続税の申告が不要だと思っていたら、実は申告しなければならなかった……。そんなケースは意外と多くあります。
            相続財産が基礎控除額以下であれば、原則として相続税はかかりません。そのため、多くの人が「申告も不要」と考えがちです。しかし、相続税がかからなくても申告が必要になるケースがあるため注意が必要といわれています。
            本記事では、相続税の申告が不要なケースと必要なケースについて仮定事例を交えて解説します。また、申告が必要となった場合の手続きの流れや必要書類についても述べています｡ぜひ最後までご覧ください。
        </p>

        <!-- 画像スペース -->
        <div class="mt-10 flex justify-center gap-8">
            <img src="{{ asset('images/souzoku_12.jpeg') }}" alt="相続税のガイド" class="w-1/3 rounded-xl shadow-md">
            <img src="{{ asset('images/souzoku_7.jpeg') }}" alt="相続手続き" class="w-1/3 rounded-xl shadow-md">
            <img src="{{ asset('images/TaxBar_10.jpeg') }}" alt="税理士のアドバイス" class="w-1/3 rounded-xl shadow-md">
        </div>

        <!-- 相続税がかからないケース -->
        <div class="mt-12 p-8 bg-gray-50 rounded-xl">
            <h2 class="text-3xl font-bold text-gray-800">相続税がかからないケース</h2>
            <p class="mt-4 text-xl text-gray-700 leading-relaxed">
                相続税の課税対象となる遺産総額が基礎控除額以下であれば、相続税は発生しないといわれています｡
            </p>

            <h3 class="mt-6 text-2xl font-bold text-gray-800">1. 課税価格が基礎控除額以下の場合</h3>
            <p class="mt-2 text-xl text-gray-700 leading-relaxed">
                <strong>基礎控除額の計算式：</strong> 3,000万円＋（600万円×法定相続人の数）
            </p>

            <h3 class="mt-6 text-2xl font-bold text-gray-800">2. 配偶者の税額軽減が適用される場合</h3>
            <p class="mt-2 text-xl text-gray-700 leading-relaxed">
                配偶者の法定相続分相当額 または 1億6,000万円まで相続税が非課税となるケースがあります。
            </p>
        </div>

        <!-- 相続税がかからなくても申告が必要なケース -->
        <div class="mt-12 p-8 bg-gray-50 rounded-xl">
        <h2 class="text-3xl font-bold text-gray-800">相続税がかからなくても申告が必要なケース</h2>
            <p class="text-xl text-gray-700 leading-relaxed">
                「相続税がかからない＝申告不要」と考えてしまうと、思わぬトラブルに巻き込まれることがあります。
            </p>

            <h3 class="mt-6 text-2xl font-bold text-red-500">1. 配偶者の税額軽減を適用する場合</h3>
            <p class="mt-2 text-xl text-gray-700 leading-relaxed">
                配偶者の税額軽減を受けるためには、申告期限（相続発生後10ヵ月以内）までに相続税申告を行う必要があるといわれています。
            </p>
            <p class="mt-2 text-xl text-gray-700 leading-relaxed">
                仮に申告をしなかった場合、税務署からの問い合わせがある可能性があるため注意が必要です。
            </p>

            <h3 class="mt-6 text-2xl font-bold text-blue-500">2. 小規模宅地等の特例を適用する場合</h3>
            <p class="mt-2 text-xl text-gray-700 leading-relaxed">
                小規模宅地等の特例を適用すれば、相続財産に含まれる土地の評価額を最大80％減額できます。
                しかし、特例を受けるためには相続税申告を行わなければならないとされているようです。
            </p>

            <h3 class="mt-6 text-2xl font-bold text-green-500">3. 相続財産を公益法人等に寄付した場合</h3>
            <p class="mt-2 text-xl text-gray-700 leading-relaxed">
                相続税の申告期限までに相続財産を国や地方公共団体、公益法人に寄付した場合、
                その寄付財産は相続税の対象外となります。しかし、寄付を行ったことを税務署に申告しなければならないそうです。
            </p>
        </div>


        <!-- 相続税申告の流れ -->
        <div class="mt-12 p-8 bg-gray-50 rounded-xl">
            <h2 class="text-3xl font-bold text-gray-800">相続税申告の流れと必要書類</h2>
            <table class="mt-6 w-full border-collapse border border-gray-300 text-xl">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 p-4">期限</th>
                        <th class="border border-gray-300 p-4">手続き内容</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 p-4">7日以内</td>
                        <td class="border border-gray-300 p-4">死亡届の提出</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 p-4">14日以内</td>
                        <td class="border border-gray-300 p-4">国民年金の受給停止手続き</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 p-4">3ヵ月以内</td>
                        <td class="border border-gray-300 p-4">相続放棄・限定承認の申請</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 p-4">10ヵ月以内</td>
                        <td class="border border-gray-300 p-4">相続税の申告・納税</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- 必要書類一覧 -->
        <div class="mt-12 p-8 bg-gray-50 rounded-xl">
            <h2 class="text-3xl font-bold text-gray-800">必要書類一覧</h2>
            <p class="mt-4 text-xl text-gray-700 leading-relaxed">
                申告には以下のような書類が必要とされています。
            </p>

            <ul class="list-disc list-inside mt-6 text-xl leading-relaxed">
                <li class="text-red-500 font-semibold">戸籍謄本</li>
                <li class="text-blue-500 font-semibold">遺産分割協議書の写し</li>
                <li class="text-green-500 font-semibold">印鑑証明書</li>
                <li class="text-purple-500 font-semibold">預貯金・借入金の残高証明書</li>
                <li class="text-orange-500 font-semibold">生命保険金・退職金の支払証明書</li>
                <li class="text-teal-500 font-semibold">不動産の登記簿謄本</li>
                <li class="text-pink-500 font-semibold">固定資産税評価証明書</li>
            </ul>


            <p class="mt-4 text-xl text-gray-700 leading-relaxed">
                これらの書類は取得に時間がかかるものもあるため、早めに準備を始めることをおすすめします。
            </p>
        </div>

        <!-- 申告が必要なのに申告しなかったらどうなる？ -->
        <div class="mt-12 p-8 bg-gray-50 rounded-xl">
            <h2 class="text-3xl font-bold text-gray-800">申告が必要なのに申告しなかったらどうなる？</h2>
            <p class="mt-4 text-xl text-gray-700 leading-relaxed">
                もし申告義務があるのに申告しなかった場合、税務署からの問い合わせが来ることがあります。
                また、申告が遅れると以下のペナルティが発生する可能性があります。
            </p>

            <h3 class="mt-6 text-2xl font-bold text-red-500">延滞税・加算税のリスク</h3>
            <table class="mt-6 w-full border-collapse border border-gray-300 text-xl">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 p-4">ペナルティ</th>
                        <th class="border border-gray-300 p-4">内容</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 p-4 text-red-500 font-semibold">無申告加算税</td>
                        <td class="border border-gray-300 p-4">50万円以下の納税額：15％、50万円超の納税額：20％</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 p-4 text-blue-500 font-semibold">延滞税</td>
                        <td class="border border-gray-300 p-4">納期限後2ヵ月以内：年率7.3%、2ヵ月超：年率14.6%</td>
                    </tr>
                </tbody>
            </table>

            <p class="mt-4 text-xl text-gray-700 leading-relaxed">
                これらのペナルティを回避するためにも、申告の要否を早めに確認し、
                必要な場合は期限内に申告を済ませたほうが良いと思われます。
            </p>
        </div>

        <!-- まとめ：早めの準備がカギ -->
        <div class="mt-12 p-8 bg-gray-50 rounded-xl">
            <h2 class="text-3xl font-bold text-gray-800">まとめ：早めの準備がカギ</h2>
            <p class="mt-4 text-xl text-gray-700 leading-relaxed">
                相続税の申告が必要かどうかを判断するためには、まず基礎控除額を確認し、
                特例を適用する場合には申告が必要かどうかを検討することが重要です。
            </p>
            <p class="mt-4 text-xl text-gray-700 leading-relaxed">
                また、相続発生後は多くの手続きを並行して進めなければならず、
                10ヵ月という期間は意外と短いものです。
                申告期限直前になって慌てることがないよう、
                早めに相続財産のリストアップと必要書類の準備を進めておくことをおすすめします。
            </p>
            <p class="mt-4 text-xl text-gray-700 leading-relaxed">
                相続税の申告について不安がある場合は、<span class="text-blue-500 font-bold">TaxBar®</span> 所属の税理士に相談しましょう。
                経験豊富な専門家が、あなたの状況に応じた最適なアドバイスを提供します。
                早めに準備を進め、相続税申告をスムーズに完了させましょう。
            </p>
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
