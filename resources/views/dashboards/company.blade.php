<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar®️ | 企業ダッシュボード</title>
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

            <h1 class="text-3xl font-bold text-gray-800 mb-2 text-center">企業ダッシュボード</h1>
            <p class="text-xl text-gray-600 mb-6 text-center">企業税務管理</p>

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
                <h2 class="text-2xl font-bold text-gray-800 mb-4">企業情報</h2>
                <p class="py-1"><strong>企業名:</strong> {{ $user->name }}</p>
                <p class="py-1"><strong>メールアドレス:</strong> {{ $user->email }}</p>
                <p class="py-1"><strong>ユーザー種別:</strong> 企業</p>

                <!-- 企業プロフィールの追加情報（実際のデータベース構造に合わせて修正が必要） -->
                @if (isset($user->company))
                    <h3 class="font-bold mt-3 mb-2 border-b pb-1">企業プロフィール</h3>
                    <p class="py-1"><strong>業種:</strong> {{ $user->company->industry ?? '未登録' }}</p>
                    <p class="py-1"><strong>従業員数:</strong> {{ $user->company->employee_count ?? '未登録' }}</p>
                    <p class="py-1"><strong>設立年:</strong> {{ $user->company->founded_year ?? '未登録' }}</p>
                    <p class="py-1"><strong>住所:</strong> {{ $user->company->address ?? '未登録' }}</p>
                    <p class="py-1"><strong>電話番号:</strong> {{ $user->company->phone ?? '未登録' }}</p>
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

            <!-- 税務情報 -->
            <div class="bg-gray-50 border-l-4 border-green-500 p-6 rounded-lg mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">税務情報</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <h3 class="font-bold text-lg mb-2">法人税申告</h3>
                        <p class="text-gray-600 mb-2">次回申告期限: <span class="font-semibold">未設定</span></p>
                        <a href="#" class="text-blue-600 hover:underline">書類を確認</a>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <h3 class="font-bold text-lg mb-2">消費税申告</h3>
                        <p class="text-gray-600 mb-2">次回申告期限: <span class="font-semibold">未設定</span></p>
                        <a href="#" class="text-blue-600 hover:underline">書類を確認</a>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <h3 class="font-bold text-lg mb-2">法定調書</h3>
                        <p class="text-gray-600 mb-2">提出状況: <span class="font-semibold">未提出</span></p>
                        <a href="#" class="text-blue-600 hover:underline">詳細を確認</a>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <h3 class="font-bold text-lg mb-2">源泉徴収</h3>
                        <p class="text-gray-600 mb-2">次回納付期限: <span class="font-semibold">未設定</span></p>
                        <a href="#" class="text-blue-600 hover:underline">詳細を確認</a>
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

            <!-- 税務リソース -->
            <div class="bg-gray-50 border-l-4 border-yellow-500 p-6 rounded-lg mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">税務リソース</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('taxminivideos.index') }}"
                        class="block bg-white p-4 rounded-lg shadow-sm hover:bg-yellow-50 transition duration-200">
                        <h3 class="font-bold text-lg mb-2">Tax Minutes</h3>
                        <p class="text-gray-600">税に関する短い解説動画</p>
                    </a>
                    <a href="#"
                        class="block bg-white p-4 rounded-lg shadow-sm hover:bg-yellow-50 transition duration-200">
                        <h3 class="font-bold text-lg mb-2">税務セミナー</h3>
                        <p class="text-gray-600">オンラインセミナーに参加</p>
                    </a>
                    <a href="#"
                        class="block bg-white p-4 rounded-lg shadow-sm hover:bg-yellow-50 transition duration-200">
                        <h3 class="font-bold text-lg mb-2">税制改正情報</h3>
                        <p class="text-gray-600">最新の税制改正情報</p>
                    </a>
                    <a href="#"
                        class="block bg-white p-4 rounded-lg shadow-sm hover:bg-yellow-50 transition duration-200">
                        <h3 class="font-bold text-lg mb-2">経営サポート</h3>
                        <p class="text-gray-600">企業経営に役立つ情報</p>
                    </a>
                </div>
            </div>

            <!-- ファイル管理 -->
            <div class="bg-gray-50 border-l-4 border-red-500 p-6 rounded-lg mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">ファイル管理</h2>
                <div class="mb-4">
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <p class="mb-4">重要な税務書類を保存・管理できます</p>
                        <div class="flex items-center justify-between">
                            <a href="#" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">
                                ファイルをアップロード
                            </a>
                            <a href="#" class="text-blue-600 hover:underline">
                                すべてのファイルを表示
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('components.footer')
</body>

</html>
