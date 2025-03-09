<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar®️ | 税理士ダッシュボード</title>
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

            <h1 class="text-3xl font-bold text-gray-800 mb-2 text-center">税理士ダッシュボード</h1>
            <p class="text-xl text-gray-600 mb-6 text-center">税理士サービス管理</p>

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
                <h2 class="text-2xl font-bold text-gray-800 mb-4">税理士情報</h2>
                <p class="py-1"><strong>名前:</strong> {{ $user->name }}</p>
                <p class="py-1"><strong>メールアドレス:</strong> {{ $user->email }}</p>
                <p class="py-1"><strong>ユーザー種別:</strong> 税理士</p>

                @if ($user->taxAdvisor)
                    <!-- 税理士の場合の追加情報 -->
                    <h3 class="font-bold mt-3 mb-2 border-b pb-1">税理士プロフィール</h3>
                    <p class="py-1"><strong>事務所名:</strong> {{ $user->taxAdvisor->office_name ?? '未登録' }}</p>
                    <p class="py-1"><strong>郵便番号:</strong> {{ $user->taxAdvisor->postal_code ?? '未登録' }}</p>
                    <p class="py-1"><strong>都道府県:</strong> {{ $user->taxAdvisor->prefecture ?? '未登録' }}</p>
                    <p class="py-1"><strong>住所:</strong> {{ $user->taxAdvisor->address ?? '未登録' }}</p>
                    <p class="py-1"><strong>事務所電話番号:</strong> {{ $user->taxAdvisor->office_phone ?? '未登録' }}</p>
                    <p class="py-1"><strong>携帯電話番号:</strong> {{ $user->taxAdvisor->mobile_phone ?? '未登録' }}</p>
                    <p class="py-1"><strong>専門分野:</strong> {{ $user->taxAdvisor->specialty ?? '未登録' }}</p>
                    @if ($user->taxAdvisor->subscriptionPlan)
                        <p class="py-1"><strong>料金プラン:</strong>
                            {{ $user->taxAdvisor->subscriptionPlan->name ?? '未登録' }}</p>
                        <p class="py-1"><strong>プラン期間:</strong>
                            {{ $user->taxAdvisor->subscription_start_date ? $user->taxAdvisor->subscription_start_date->format('Y年m月d日') : '未設定' }}
                            から
                            {{ $user->taxAdvisor->subscription_end_date ? $user->taxAdvisor->subscription_end_date->format('Y年m月d日') : '未設定' }}
                        </p>
                    @endif
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

            <!-- クライアント管理 -->
            <div class="bg-gray-50 border-l-4 border-green-500 p-6 rounded-lg mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">クライアント管理</h2>
                <div class="mb-4">
                    <p class="text-gray-600 mb-4">登録されているクライアント一覧</p>
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <p class="text-center text-gray-500">現在クライアントはいません</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="#" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">
                        クライアントを追加
                    </a>
                </div>
            </div>

            <!-- Tax Minutes リール動画管理 -->
            <div class="bg-gray-50 border-l-4 border-yellow-500 p-6 rounded-lg mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Tax Minutes リール動画</h2>

                <!-- 動画アップロードフォーム -->
                <div class="mb-6 p-4 bg-white rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold mb-3">新しい動画をアップロード</h3>
                    <form action="{{ route('taxminivideos.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-4">
                        @csrf
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">タイトル</label>
                            <input type="text" name="title" id="title" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">説明</label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        <div>
                            <label for="prefecture" class="block text-sm font-medium text-gray-700 mb-1">都道府県</label>
                            <select name="prefecture" id="prefecture"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">選択してください</option>
                                <option value="全国">全国</option>
                                <option value="東京都">東京都</option>
                                <option value="大阪府">大阪府</option>
                                <!-- 他の都道府県 -->
                            </select>
                        </div>
                        <div>
                            <label for="video" class="block text-sm font-medium text-gray-700 mb-1">動画ファイル</label>
                            <input type="file" name="video" id="video" accept="video/*" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="thumbnail"
                                class="block text-sm font-medium text-gray-700 mb-1">サムネイル画像（オプション）</label>
                            <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                                アップロード
                            </button>
                        </div>
                    </form>
                </div>

                <!-- アップロード済み動画一覧 -->
                <div>
                    <h3 class="text-lg font-semibold mb-3">アップロード済み動画</h3>
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <p class="text-center text-gray-500">アップロードした動画はありません</p>
                    </div>
                </div>
            </div>

            <!-- サービス提供 -->
            <div class="bg-gray-50 border-l-4 border-purple-500 p-6 rounded-lg mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">サービス提供</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="#"
                        class="block bg-white p-4 rounded-lg shadow-sm hover:bg-purple-50 transition duration-200">
                        <h3 class="font-bold text-lg mb-2">税務相談</h3>
                        <p class="text-gray-600">クライアントからの税務相談を管理</p>
                    </a>
                    <a href="#"
                        class="block bg-white p-4 rounded-lg shadow-sm hover:bg-purple-50 transition duration-200">
                        <h3 class="font-bold text-lg mb-2">確定申告サポート</h3>
                        <p class="text-gray-600">確定申告のサポート情報</p>
                    </a>
                    <a href="#"
                        class="block bg-white p-4 rounded-lg shadow-sm hover:bg-purple-50 transition duration-200">
                        <h3 class="font-bold text-lg mb-2">税務書類作成</h3>
                        <p class="text-gray-600">各種税務書類の作成サポート</p>
                    </a>
                    <a href="#"
                        class="block bg-white p-4 rounded-lg shadow-sm hover:bg-purple-50 transition duration-200">
                        <h3 class="font-bold text-lg mb-2">税務セミナー</h3>
                        <p class="text-gray-600">オンラインセミナーの管理</p>
                    </a>
                </div>
            </div>
        </div>
    </main>

    @include('components.footer')
</body>

</html>
