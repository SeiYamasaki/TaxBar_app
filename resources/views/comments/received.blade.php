<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>受信コメント一覧 - TaxBar®️</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="flex h-full bg-gray-100 relative">
    <x-tax-advisor.sidebar :user="auth()->user()" />

    <!-- メインコンテンツ -->
    <div class="flex-1 md:ml-64 transition-all duration-300 ease-in-out">
        <!-- ヘッダー -->
        <header class="fixed top-0 right-0 left-0 md:left-64 z-[999] bg-white md:bg-transparent shadow md:shadow-none">
            <div class="flex justify-between items-center h-16 px-4 md:px-6">
                <!-- モバイル用のハンバーガーメニューのスペース -->
                <div class="w-10 md:hidden"></div>

                <!-- アカウントメニュー - 右寄せ -->
                <div class="relative ml-auto" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                        <div class="flex items-center space-x-4">
                            @if (auth()->user()->taxAdvisor && auth()->user()->taxAdvisor->tax_accountant_photo)
                                <img src="{{ asset('storage/' . auth()->user()->taxAdvisor->tax_accountant_photo) }}"
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
                                <span
                                    class="text-sm font-medium text-gray-700 md:text-white">{{ auth()->user()->name }}</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>

                    <!-- ドロップダウンメニュー -->
                    <div x-show="open" x-cloak @click.away="open = false"
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
            <main class="container mx-auto px-4 sm:px-6 py-8">

                <!-- フィルタリングオプション -->
                <div class="mb-8 bg-white p-6 rounded-lg shadow-md">
                    <h1 class="text-3xl font-bold text-center mb-10">受信コメント一覧</h1>
                    <form action="{{ route('comments.received') }}" method="GET"
                        class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm font-medium text-gray-700 mb-1">ステータス</label>
                            <select name="status"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">すべて</option>
                                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>承認済み
                                </option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>承認待ち
                                </option>
                            </select>
                        </div>
                        <div>
                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                フィルター
                            </button>
                        </div>
                    </form>
                </div>

                <!-- コメント一覧 -->
                <div class="space-y-6">
                    @if (count($comments) > 0)
                        @foreach ($comments as $comment)
                            <div
                                class="bg-white p-6 rounded-lg shadow-md border-l-4 {{ $comment->is_approved ? 'border-green-500' : 'border-yellow-500' }}">
                                <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                                    <div class="flex-1 flex items-center gap-4">
                                        @if (optional($comment->user)->profile_photo)
                                            <img src="{{ asset('storage/' . optional($comment->user)->profile_photo) }}"
                                                alt="ユーザーの写真" class="w-10 h-10 rounded-full">
                                        @else
                                            <svg class="w-12 h-12 text-gray-400 bg-gray-100 rounded-full border-2 border-gray-200 p-1"
                                                fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                            </svg>
                                        @endif

                                        <!-- コメント情報 -->
                                        <div class="flex items-center mb-2">
                                            <span
                                                class="font-bold text-gray-800 mr-2">{{ $comment->display_name }}</span>
                                            <span
                                                class="text-gray-500 text-sm">{{ $comment->created_at->format('Y年m月d日 H:i') }}</span>
                                            <span
                                                class="ml-2 {{ $comment->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} text-xs px-2 py-1 rounded-full">
                                                {{ $comment->is_approved ? '承認済み' : '承認待ち' }}
                                            </span>
                                        </div>

                                        <!-- コメント対象 -->
                                        <div class="text-sm text-gray-600 mb-3">
                                            @if ($comment->commentable_type === 'App\Models\TaxMinutesVideo')
                                                <span
                                                    class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1">動画</span>
                                                <a href="{{ route('taxminivideos.show', $comment->commentable_id) }}"
                                                    class="text-indigo-600 hover:underline">
                                                    {{ $comment->commentable->title ?? '削除された動画' }}
                                                </a>
                                            @elseif($comment->commentable_type === 'App\Models\Theme')
                                                <span
                                                    class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded mr-1">テーマ</span>
                                                <a href="#" class="text-indigo-600 hover:underline">
                                                    {{ $comment->commentable->title ?? '削除されたテーマ' }}
                                                </a>
                                            @endif
                                        </div>

                                        <!-- コメント本文 -->
                                        <div class="bg-gray-50 p-4 rounded-lg text-gray-700">
                                            {{ $comment->content }}
                                        </div>
                                    </div>

                                    <!-- 操作ボタン -->
                                    <div class="flex flex-col gap-2 min-w-[120px]">
                                        @if (!$comment->is_approved)
                                            <form action="{{ route('comments.approve', $comment->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded">
                                                    承認する
                                                </button>
                                            </form>
                                            <form action="{{ route('comments.reject', $comment->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded">
                                                    拒否する
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                                onsubmit="return confirm('このコメントを削除しますか？');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-full bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded">
                                                    削除する
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- ページネーション -->
                        <div class="mt-6">
                            {{ $comments->links() }}
                        </div>
                    @else
                        <div class="bg-white p-8 rounded-lg shadow-md text-center">
                            <p class="text-gray-500 text-lg">受信したコメントはありません</p>
                        </div>
                    @endif
                </div>

                <!-- 戻るボタン -->
                <div class="mt-10 text-center">
                    <a href="{{ route('dashboard') }}"
                        class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                        ダッシュボードに戻る
                    </a>
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
