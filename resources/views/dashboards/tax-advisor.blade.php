<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar®️ | 税理士ダッシュボード</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="flex h-full bg-gray-100">
    <!-- サイドバー -->
    <aside class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg z-50">
        <div class="flex flex-col h-full">
            <!-- ロゴ -->
            <div class="flex justify-center p-4 border-b">
                <img src="/images/logotoumei.png" alt="ロゴ" class="h-12">
            </div>

            <!-- メニュー -->
            <nav class="flex-1 overflow-y-auto py-4">
                <div class="px-4 space-y-2">
                    <!-- ダッシュボード -->
                    <a href="#" class="flex items-center px-4 py-2 text-gray-700 bg-gray-100 rounded-lg">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        ダッシュボード
                    </a>

                    <!-- クライアント管理 -->
                    <a href="#" class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        クライアント管理
                    </a>

                    <!-- Tax Minutes 動画管理 -->
                    <a href="{{ route('taxminivideos.manage') }}"
                        class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                        Tax Minutes 動画管理
                    </a>

                    <!-- コメント管理 -->
                    <a href="{{ route('comments.received') }}"
                        class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                            </path>
                        </svg>
                        コメント管理
                    </a>

                    <!-- TaxBar予約 -->
                    <a href="#" class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        TaxBar予約
                    </a>

                    <!-- ユーザー設定 -->
                    <a href="#" class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        ユーザー設定
                    </a>

                    <!-- プラン変更 -->
                    <a href="{{ route('pricing.index') }}"
                        class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        プラン変更
                    </a>
                </div>
            </nav>

            <!-- ユーザー情報 -->
            <div class="p-4 border-t">
                <div class="flex items-center">
                    @if ($user->taxAdvisor && $user->taxAdvisor->tax_accountant_photo)
                        <img src="{{ asset('storage/' . $user->taxAdvisor->tax_accountant_photo) }}" alt="プロフィール画像"
                            class="w-10 h-10 rounded-full">
                    @else
                        <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    @endif
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-700">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500">税理士</p>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- メインコンテンツ -->
    <div class="flex-1 ml-64">
        <!-- ヘッダー -->
        <header class="bg-white shadow-sm fixed top-0 right-0 left-64 z-40">
            <div class="flex justify-end items-center h-16 px-6">
                <!-- アカウントメニュー -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                        <div class="flex items-center space-x-4">
                            @if ($user->taxAdvisor && $user->taxAdvisor->tax_accountant_photo)
                                <img src="{{ asset('storage/' . $user->taxAdvisor->tax_accountant_photo) }}"
                                    alt="プロフィール画像" class="w-10 h-10 rounded-full">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-gray-700">{{ $user->name }}</span>
                                <span class="text-xs text-gray-500">税理士</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>

                    <!-- ドロップダウンメニュー -->
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                        <a href="{{ route('tax_advisor.profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            プロフィール編集
                        </a>
                        <a href="{{ route('notifications.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            通知
                            @if (auth()->user()->unreadNotifications->count() > 0)
                                <span
                                    class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                ログアウト
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- メインコンテンツのパディング調整 -->
        <div class="pt-16">
            <main class="container mx-auto px-6 py-8">
                <!-- ダッシュボードの概要 -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">クライアント数</h3>
                        <p class="text-3xl font-bold text-blue-600">0</p>
                        <p class="text-sm text-gray-500">登録済みクライアント</p>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Tax Minutes 動画</h3>
                        <p class="text-3xl font-bold text-green-600">{{ $taxMinutesVideos->count() }}</p>
                        <p class="text-sm text-gray-500">アップロード済み動画</p>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">未承認コメント</h3>
                        <p class="text-3xl font-bold text-yellow-600">{{ count($pendingComments) }}</p>
                        <p class="text-sm text-gray-500">承認待ちのコメント</p>
                    </div>
                </div>

                <!-- メインコンテンツ -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- 最近の動画 -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-800">最近の動画</h2>
                            <a href="{{ route('taxminivideos.manage') }}"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">すべて見る</a>
                        </div>
                        @if ($taxMinutesVideos->isEmpty())
                            <p class="text-gray-500 text-center py-4">動画がありません</p>
                        @else
                            <div class="space-y-4">
                                @foreach ($taxMinutesVideos->take(5) as $video)
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            @if ($video->thumbnail)
                                                <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="サムネイル"
                                                    class="w-16 h-16 object-cover rounded">
                                            @else
                                                <div
                                                    class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $video->title }}
                                            </p>
                                            <p class="text-sm text-gray-500">{{ $video->created_at->format('Y/m/d') }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- 最近のコメント -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-800">最近のコメント</h2>
                            <a href="{{ route('comments.received') }}"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">すべて見る</a>
                        </div>
                        @if (count($pendingComments) === 0 && count($approvedComments) === 0)
                            <p class="text-gray-500 text-center py-4">コメントはありません</p>
                        @else
                            <div class="space-y-4">
                                @foreach ($pendingComments->merge($approvedComments)->take(5) as $comment)
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-2 h-2 rounded-full {{ $comment->is_approved ? 'bg-green-500' : 'bg-yellow-500' }}">
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $comment->display_name }}</p>
                                            <p class="text-sm text-gray-500 truncate">
                                                {{ Str::limit($comment->content, 50) }}</p>
                                            <p class="text-xs text-gray-400">
                                                {{ $comment->created_at->format('Y/m/d H:i') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
