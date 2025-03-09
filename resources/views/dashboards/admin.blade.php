<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar®️ | 管理者ダッシュボード</title>
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

            <h1 class="text-3xl font-bold text-gray-800 mb-2 text-center">管理者ダッシュボード</h1>
            <p class="text-xl text-gray-600 mb-6 text-center">システム管理</p>

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
                <h2 class="text-2xl font-bold text-gray-800 mb-4">管理者情報</h2>
                <p class="py-1"><strong>名前:</strong> {{ auth()->user()->name }}</p>
                <p class="py-1"><strong>メールアドレス:</strong> {{ auth()->user()->email }}</p>
                <p class="py-1"><strong>ユーザー種別:</strong> 管理者</p>

                <div class="mt-4 flex justify-end">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">
                            ログアウト
                        </button>
                    </form>
                </div>
            </div>

            <!-- ユーザー統計 -->
            <div class="bg-gray-50 border-l-4 border-purple-500 p-6 rounded-lg mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">ユーザー統計</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <h3 class="font-bold text-lg mb-2">税理士</h3>
                        <p class="text-3xl font-semibold text-purple-600">{{ $userCounts['tax_advisor'] }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <h3 class="font-bold text-lg mb-2">企業</h3>
                        <p class="text-3xl font-semibold text-purple-600">{{ $userCounts['company'] }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <h3 class="font-bold text-lg mb-2">個人</h3>
                        <p class="text-3xl font-semibold text-purple-600">{{ $userCounts['individual'] }}</p>
                    </div>
                </div>
            </div>

            <!-- 管理機能 -->
            <div class="bg-gray-50 border-l-4 border-yellow-500 p-6 rounded-lg mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">管理機能</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="#"
                        class="block bg-white p-4 rounded-lg shadow-sm hover:bg-yellow-50 transition duration-200">
                        <h3 class="font-bold text-lg mb-2">ユーザー管理</h3>
                        <p class="text-gray-600">ユーザーアカウントの管理、編集、削除</p>
                    </a>
                    <a href="#"
                        class="block bg-white p-4 rounded-lg shadow-sm hover:bg-yellow-50 transition duration-200">
                        <h3 class="font-bold text-lg mb-2">コンテンツ管理</h3>
                        <p class="text-gray-600">サイトコンテンツの管理と更新</p>
                    </a>
                    <a href="#"
                        class="block bg-white p-4 rounded-lg shadow-sm hover:bg-yellow-50 transition duration-200">
                        <h3 class="font-bold text-lg mb-2">料金プラン管理</h3>
                        <p class="text-gray-600">料金プランの設定と管理</p>
                    </a>
                    <a href="#"
                        class="block bg-white p-4 rounded-lg shadow-sm hover:bg-yellow-50 transition duration-200">
                        <h3 class="font-bold text-lg mb-2">システム設定</h3>
                        <p class="text-gray-600">アプリケーション全体の設定</p>
                    </a>
                </div>
            </div>

            <!-- システム統計 -->
            <div class="bg-gray-50 border-l-4 border-green-500 p-6 rounded-lg mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">システム統計</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 bg-gray-100 text-left">項目</th>
                                <th class="py-2 px-4 bg-gray-100 text-right">値</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 border-b">総ユーザー数</td>
                                <td class="py-2 px-4 border-b text-right">{{ array_sum($userCounts) + 1 }}</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b">Tax Minutes動画数</td>
                                <td class="py-2 px-4 border-b text-right">0</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b">今月の新規登録者数</td>
                                <td class="py-2 px-4 border-b text-right">0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    @include('components.footer')
</body>

</html>
