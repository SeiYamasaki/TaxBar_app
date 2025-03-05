<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>テーマ詳細 | TaxBar®️</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans">
    <!-- ヘッダー -->
    @include('components.header')

    <!-- コンテンツエリア -->
    <main class="container mt-20 mx-auto px-4 py-10">
        <!-- タイトルと説明 -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">テーマ別相談</h1>
            <p class="text-lg text-gray-600">ユーザーは自分の興味や課題に応じた相談テーマに参加することができます。</p>
        </div>

        <!-- テーマセクション -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- 確定申告 -->
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b-2 border-indigo-500 pb-2">確定申告</h2>
                <ul class="space-y-2">
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">確定申告</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">リモートタスクその他確定申告</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">源泉出し個人事業主</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">海外収入確定申告</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">医療費控除解説</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">ふるさと納税申告</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">住宅ローン控除申告</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">起業収入・控除確定申告</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">初めての確定申告</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">副業YouTubeの控除申告</a>
                    </li>
                </ul>
            </div>

            <!-- 起業・法人化系 -->
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b-2 border-indigo-500 pb-2">起業・法人化系</h2>
                <ul class="space-y-2">
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">起業・法人化系</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">法人向けシェアション</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">1円起業</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">合同会社 vs
                            株式会社</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">法人設立用出費の作り方</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">飲食店開業</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">ECサイト起業</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">美容室・サロン開業</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">クリエイター開業</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">パーソナルジム起業</a>
                    </li>
                </ul>
            </div>

            <!-- 節税・資産運用系 -->
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b-2 border-indigo-500 pb-2">節税・資産運用系</h2>
                <ul class="space-y-2">
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">節税・資産運用系</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">個人事業主の節税</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">不動産オーナー節税</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">投資知識</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">株知識</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">NISA・iDeCo攻略</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">先程の投資</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">経営者あたおつ節税</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">不動産投資</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">投資資金運用</a></li>
                </ul>
            </div>

            <!-- 副業・個人事業主系 -->
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b-2 border-indigo-500 pb-2">副業・個人事業主系</h2>
                <ul class="space-y-2">
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">副業・個人事業主系</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">SNS運用者・初心者</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">クリエイター初心者</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">イラストレーター攻略</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">ライター作家攻略</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">コンテンツ作家攻略</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">カメラマン・映像制作者</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">エンジニア開業攻略</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">カウチング・コンサル攻略</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">データサイエンティスト攻略</a>
                    </li>
                </ul>
            </div>

            <!-- 不動産・投資系 -->
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b-2 border-indigo-500 pb-2">不動産・投資系</h2>
                <ul class="space-y-2">
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">不動産売買</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">不動産オーナー向け</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">不動産投資</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">不動産資料データ</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">不動産用語</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">不動産カテゴリ</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">不動産オーナー攻略</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">不動産投資</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">不動産カテゴリ攻略</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">不動産売却攻略</a>
                    </li>
                </ul>
            </div>

            <!-- 海外・インバウンド系 -->
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b-2 border-indigo-500 pb-2">海外・インバウンド系</h2>
                <ul class="space-y-2">
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">海外外居住</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">海外外起業</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">インバウンド</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">外資系雇用</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">外資系人間</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">国際取引</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">海外外居住者</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">海外外法人</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">海外外人設立</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">外資系ビジネス攻略</a>
                    </li>
                </ul>
            </div>

            <!-- 相談・購入・保険系 -->
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b-2 border-indigo-500 pb-2">相談・購入・保険系</h2>
                <ul class="space-y-2">
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">黒字へ転生</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">株決済</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">不動産用語</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">不動産資料データ</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">不動産用語</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">不動産カテゴリ</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">法人保険</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">事業承継</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">生命保険</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">退職金と保険</a>
                    </li>
                </ul>
            </div>

            <!-- 業種別特化系 -->
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b-2 border-indigo-500 pb-2">業種別特化系</h2>
                <ul class="space-y-2">
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">美容サロン攻略</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">飲食店経営攻略</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">飲食店後継者</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">美容室経営</a></li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">美容室カテゴリ</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">飲食店オーナー攻略</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">福祉施設経営</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">カフェオーナー攻略</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">教育系ビジネス攻略</a>
                    </li>
                    <li><a href="#"
                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">観光業経営</a></li>
                </ul>
            </div>
        </div>
    </main>

    <!-- フッター -->
    @include('components.footer')
</body>


</html>
