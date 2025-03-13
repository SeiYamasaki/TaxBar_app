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

                @if ($user->tax_advisor)
                    <!-- 税理士の場合の追加情報 -->
                    <h3 class="font-bold mt-3 mb-2 border-b pb-1">税理士プロフィール</h3>
                    <p class="py-1"><strong>事務所名:</strong> {{ $user->tax_advisor->office_name ?? '未登録' }}</p>
                    <p class="py-1"><strong>郵便番号:</strong> {{ $user->tax_advisor->postal_code ?? '未登録' }}</p>
                    <p class="py-1"><strong>都道府県:</strong> {{ $user->tax_advisor->prefecture ?? '未登録' }}</p>
                    <p class="py-1"><strong>住所:</strong> {{ $user->tax_advisor->address ?? '未登録' }}</p>
                    <p class="py-1"><strong>事務所電話番号:</strong> {{ $user->tax_advisor->office_phone ?? '未登録' }}</p>
                    <p class="py-1"><strong>携帯電話番号:</strong> {{ $user->tax_advisor->mobile_phone ?? '未登録' }}</p>
                    <p class="py-1"><strong>専門分野:</strong> {{ $user->tax_advisor->specialty ?? '未登録' }}</p>
                    @if ($user->tax_advisor->subscriptionPlan)
                        <p class="py-1"><strong>料金プラン:</strong>
                            {{ $user->tax_advisor->subscriptionPlan->name ?? '未登録' }}</p>
                        <p class="py-1"><strong>プラン期間:</strong>
                            {{ $user->tax_advisor->subscription_start_date ? $user->tax_advisor->subscription_start_date->format('Y年m月d日') : '未設定' }}
                            から
                            {{ $user->tax_advisor->subscription_end_date ? $user->tax_advisor->subscription_end_date->format('Y年m月d日') : '未設定' }}
                        </p>
                    @endif
                @endif

                <div class="mt-4 flex justify-between">
                    <a href="{{ route('tax_advisor.profile.edit') }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                        プロフィール編集
                    </a>
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
                <div id="upload-video" class="mb-6 p-4 bg-white rounded-lg shadow-sm">
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
                            <label for="video" class="block text-sm font-medium text-gray-700 mb-1">動画ファイル</label>
                            <input type="file" name="video" id="video" accept="video/*" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1">サムネイル画像
                                (任意)</label>
                            <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">推奨サイズ: 720×1280px（9:16）。設定しない場合はデフォルト画像が使用されます。</p>
                        </div>
                        <div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                                アップロード
                            </button>
                        </div>
                    </form>
                </div>

                <!-- 動画管理ボタン -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex flex-col items-center justify-center">
                        <p class="text-gray-600 mb-4">アップロードした動画の一覧を表示して管理します</p>
                        <a href="{{ route('taxminivideos.manage') }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-lg flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                </path>
                            </svg>
                            動画を管理する
                        </a>
                        <p class="text-sm text-gray-500 mt-2">{{ $taxMinutesVideos->count() }}件の動画がアップロードされています</p>
                    </div>
                </div>
            </div>

            <!-- コメント管理セクション -->
            <div class="bg-gray-50 border-l-4 border-indigo-500 p-6 rounded-lg mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">コメント管理</h2>

                <!-- 承認待ちコメント -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 flex items-center">
                        <span
                            class="bg-yellow-500 text-white rounded-full w-6 h-6 inline-flex items-center justify-center mr-2 text-sm">
                            {{ count($pendingComments) }}
                        </span>
                        承認待ちコメント
                    </h3>

                    @if (count($pendingComments) > 0)
                        <div class="space-y-4">
                            @foreach ($pendingComments as $comment)
                                <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-yellow-400">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="font-medium">{{ $comment->display_name }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $comment->created_at->format('Y/m/d H:i') }}</div>

                                            <!-- コメント対象の情報 -->
                                            <div class="text-sm text-gray-600 mt-1">
                                                @if ($comment->commentable_type === 'App\Models\TaxMinutesVideo')
                                                    <span
                                                        class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">動画</span>
                                                    {{ $comment->commentable->title ?? '削除された動画' }}
                                                @elseif($comment->commentable_type === 'App\Models\Theme')
                                                    <span
                                                        class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">テーマ</span>
                                                    {{ $comment->commentable->title ?? '削除されたテーマ' }}
                                                @endif
                                            </div>

                                            <p class="mt-2">{{ $comment->content }}</p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <form action="{{ route('comments.approve', $comment->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded text-sm">
                                                    承認
                                                </button>
                                            </form>
                                            <form action="{{ route('comments.reject', $comment->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-sm">
                                                    拒否
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white p-4 rounded-lg shadow-sm text-center text-gray-500">
                            承認待ちのコメントはありません
                        </div>
                    @endif
                </div>

                <!-- 承認済みの最新コメント -->
                <div>
                    <h3 class="text-lg font-semibold mb-3">最近の承認済みコメント</h3>

                    @if (count($approvedComments) > 0)
                        <div class="space-y-4">
                            @foreach ($approvedComments as $comment)
                                <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-green-400">
                                    <div class="font-medium">{{ $comment->display_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $comment->created_at->format('Y/m/d H:i') }}
                                    </div>

                                    <!-- コメント対象の情報 -->
                                    <div class="text-sm text-gray-600 mt-1">
                                        @if ($comment->commentable_type === 'App\Models\TaxMinutesVideo')
                                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">動画</span>
                                            {{ $comment->commentable->title ?? '削除された動画' }}
                                        @elseif($comment->commentable_type === 'App\Models\Theme')
                                            <span
                                                class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">テーマ</span>
                                            {{ $comment->commentable->title ?? '削除されたテーマ' }}
                                        @endif
                                    </div>

                                    <p class="mt-2">{{ $comment->content }}</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 text-center">
                            <a href="{{ route('comments.received') }}"
                                class="text-indigo-600 hover:text-indigo-800 font-medium">
                                すべての受信コメントを見る
                            </a>
                        </div>
                    @else
                        <div class="bg-white p-4 rounded-lg shadow-sm text-center text-gray-500">
                            承認済みのコメントはありません
                        </div>
                    @endif
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
