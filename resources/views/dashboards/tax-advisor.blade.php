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
    <x-tax-advisor.sidebar :user="$user" />

    <!-- メインコンテンツ -->
    <div class="flex-1 ml-64">
        <!-- ヘッダー -->
        <header class="bg-transparent fixed top-0 right-0 left-64 z-40">
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
                                <span class="text-sm font-medium text-white">{{ $user->name }}</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>

                    <!-- ドロップダウンメニュー -->
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-[9999]">
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
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <button type="submit" @click.prevent="$el.closest('form').submit()"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                ログアウト
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <x-parallax-header />

        <!-- メインコンテンツのパディング調整 -->
        <div class="relative w-full -mt-24 z-50">
            <main class="container mx-auto px-6 py-8">
                <!-- ダッシュボードの概要 -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">クライアント数</h3>
                        <p class="text-3xl font-bold text-blue-600">0</p>
                        <p class="text-sm text-gray-500">登録済みクライアント</p>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">TaxMinutes® 動画</h3>
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
                                @foreach ($taxMinutesVideos->take(3) as $video)
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            @if ($video->thumbnail_path)
                                                <img src="{{ asset('storage/' . $video->thumbnail_path) }}"
                                                    alt="サムネイル" class="w-16 h-16 object-cover rounded">
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
                                @foreach ($pendingComments->merge($approvedComments)->take(3) as $comment)
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-2 h-2 rounded-full {{ $comment->is_approved ? 'bg-green-500' : 'bg-yellow-500' }}">
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2 min-w-0">
                                            @if (optional($comment->user)->profile_photo)
                                                <img src="{{ asset('storage/' . optional($comment->user)->profile_photo) }}"
                                                    alt="ユーザーの写真" class="w-10 h-10 rounded-full">
                                            @else
                                                <svg class="w-12 h-12 text-gray-400 bg-gray-100 rounded-full border-2 border-gray-200 p-1"
                                                    fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $comment->display_name }}</p>
                                                <p class="text-sm text-gray-500 truncate">
                                                    {{ Str::limit($comment->content, 50) }}</p>
                                                <p class="text-xs text-gray-400">
                                                    {{ $comment->created_at->format('Y/m/d H:i') }}</p>
                                            </div>
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

    @stack('scripts')
</body>

</html>
