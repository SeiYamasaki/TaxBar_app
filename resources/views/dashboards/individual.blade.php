<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar®️ | 個人ダッシュボード</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="flex flex-col min-h-full bg-gray-100">
    @include('components.header')

    <!-- ヘッダーの高さ分のスペーサー -->
    <div class="h-16"></div>

    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg p-8 max-w-5xl mx-auto">
            <!-- ロゴの表示 -->
            <div class="flex justify-center mb-6">
                <img src="/images/logotoumei.png" alt="ロゴ" class="h-36">
            </div>

            <h1 class="text-3xl font-bold text-gray-800 mb-2 text-center">個人ダッシュボード</h1>
            <p class="text-xl text-gray-600 mb-6 text-center">個人税務管理</p>

            <!-- フラッシュメッセージ表示 -->
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- ユーザー情報の表示 -->
            <div class="bg-gray-50 border-l-4 border-blue-500 p-6 rounded-lg mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">個人情報</h2>
                <p class="py-1"><strong>氏名:</strong> {{ $user->name }}</p>
                <p class="py-1"><strong>メールアドレス:</strong> {{ $user->email }}</p>
                <p class="py-1"><strong>ユーザー種別:</strong> 個人</p>

                <!-- 個人プロフィールの追加情報（実際のデータベース構造に合わせて修正が必要） -->
                @if (isset($user->individual))
                    <h3 class="font-bold mt-3 mb-2 border-b pb-1">個人プロフィール</h3>
                    <p class="py-1"><strong>生年月日:</strong> {{ $user->individual->birth_date ?? '未登録' }}</p>
                    <p class="py-1"><strong>郵便番号:</strong> {{ $user->individual->postal_code ?? '未登録' }}</p>
                    <p class="py-1"><strong>住所:</strong> {{ $user->individual->address ?? '未登録' }}</p>
                    <p class="py-1"><strong>電話番号:</strong> {{ $user->individual->phone ?? '未登録' }}</p>
                    <p class="py-1"><strong>職業:</strong> {{ $user->individual->occupation ?? '未登録' }}</p>
                @endif

                <div class="mt-4 flex justify-end">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">
                            ログアウト
                        </button>
                    </form>
                </div>
            </div>

            <!-- 確定申告管理 -->
            <div class="bg-gray-50 border-l-4 border-green-500 p-6 rounded-lg mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">確定申告管理</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <h3 class="font-bold text-lg mb-2">所得税申告</h3>
                        <p class="text-gray-600 mb-2">次回申告期限: <span class="font-semibold">2024年3月15日</span></p>
                        <div class="mt-2">
                            <a href="#" class="text-blue-600 hover:underline">申告書を作成</a>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <h3 class="font-bold text-lg mb-2">住民税申告</h3>
                        <p class="text-gray-600 mb-2">状況: <span class="font-semibold">未申告</span></p>
                        <div class="mt-2">
                            <a href="#" class="text-blue-600 hover:underline">詳細を確認</a>
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <h3 class="font-bold text-lg mb-3">過去の申告履歴</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 bg-gray-100 text-left">年度</th>
                                    <th class="py-2 px-4 bg-gray-100 text-left">申告種類</th>
                                    <th class="py-2 px-4 bg-gray-100 text-left">申告日</th>
                                    <th class="py-2 px-4 bg-gray-100 text-left">状況</th>
                                    <th class="py-2 px-4 bg-gray-100 text-left">アクション</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-2 px-4 border-b" colspan="5">
                                        <p class="text-center text-gray-500">申告履歴はありません</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 税理士サービス -->
            <div class="bg-gray-50 border-l-4 border-purple-500 p-6 rounded-lg mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">税理士サービス</h2>
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3">担当税理士</h3>
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <p class="text-center text-gray-500">現在担当の税理士はいません</p>
                        <div class="mt-4 text-center">
                            <a href="#" class="bg-purple-500 hover:bg-purple-600 text-white py-2 px-4 rounded">
                                税理士を探す
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-lg font-semibold mb-3">税務相談</h3>
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <p class="mb-4">税務の専門家に質問や相談ができます</p>
                        <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                            新規相談を作成
                        </a>
                    </div>
                </div>
            </div>

            <!-- 節税アドバイス -->
            <div class="bg-gray-50 border-l-4 border-yellow-500 p-6 rounded-lg mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">節税アドバイス</h2>
                <div class="bg-white p-4 rounded-lg shadow-sm mb-4">
                    <h3 class="font-bold text-lg mb-2">セルフメディケーション税制</h3>
                    <p class="text-gray-600 mb-2">
                        OTC医薬品の購入費用が一定額を超えると所得控除が受けられます。今年の申告対象となる購入費用の記録を管理しましょう。
                    </p>
                    <a href="#" class="text-blue-600 hover:underline">詳細を確認</a>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm mb-4">
                    <h3 class="font-bold text-lg mb-2">ふるさと納税</h3>
                    <p class="text-gray-600 mb-2">
                        今年のふるさと納税枠はまだ残っています。地方自治体への寄付で税控除を受けられます。
                    </p>
                    <a href="#" class="text-blue-600 hover:underline">詳細を確認</a>
                </div>
            </div>

            <!-- 税務リソース -->
            <div class="bg-gray-50 border-l-4 border-red-500 p-6 rounded-lg mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">税務リソース</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('taxminivideos.index') }}"
                        class="block bg-white p-4 rounded-lg shadow-sm hover:bg-red-50 transition duration-200">
                        <h3 class="font-bold text-lg mb-2">Tax Minutes</h3>
                        <p class="text-gray-600">税に関する短い解説動画</p>
                    </a>
                    <a href="#"
                        class="block bg-white p-4 rounded-lg shadow-sm hover:bg-red-50 transition duration-200">
                        <h3 class="font-bold text-lg mb-2">確定申告ガイド</h3>
                        <p class="text-gray-600">確定申告の手順と注意点</p>
                    </a>
                    <a href="#"
                        class="block bg-white p-4 rounded-lg shadow-sm hover:bg-red-50 transition duration-200">
                        <h3 class="font-bold text-lg mb-2">控除ガイド</h3>
                        <p class="text-gray-600">適用可能な控除の一覧と条件</p>
                    </a>
                    <a href="#"
                        class="block bg-white p-4 rounded-lg shadow-sm hover:bg-red-50 transition duration-200">
                        <h3 class="font-bold text-lg mb-2">お役立ち計算ツール</h3>
                        <p class="text-gray-600">税金の簡易計算ができるツール</p>
                    </a>
                </div>
            </div>
        </div>
    </main>

    @include('components.footer')
</body>

</html>
