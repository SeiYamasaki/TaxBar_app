<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar®️ | 通知一覧</title>
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

                <!-- 通知ベル -->
                <div class="relative mr-4" x-data="{ notificationOpen: false }">
                    <button @click="notificationOpen = !notificationOpen"
                        class="relative p-2 text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                        @if (auth()->user()->unreadNotifications->count() > 0)
                            <span
                                class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>

                    <!-- 通知ドロップダウン -->
                    <div x-show="notificationOpen" x-cloak @click.away="notificationOpen = false"
                        class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg py-1 z-[9999]">
                        <div class="px-4 py-2 border-b border-gray-100">
                            <h3 class="text-sm font-semibold text-gray-900">通知</h3>
                        </div>
                        @forelse (auth()->user()->notifications->take(5) as $notification)
                            <a href="{{ route('notifications.show', $notification->id) }}"
                                class="block px-4 py-3 hover:bg-gray-50">
                                <div class="flex items-start">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $notification->data['message'] ?? '新しい通知' }}
                                        </p>
                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    @unless ($notification->read_at)
                                        <div class="ml-3 flex-shrink-0">
                                            <span class="inline-block w-2 h-2 bg-blue-500 rounded-full"></span>
                                        </div>
                                    @endunless
                                </div>
                            </a>
                        @empty
                            <div class="px-4 py-3 text-sm text-gray-500 text-center">
                                新しい通知はありません
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- アカウントメニュー -->
                <div class="relative" x-data="{ open: false }">
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
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">プロフィール編集</a>
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
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">通知一覧</h1>
                        @if (auth()->user()->unreadNotifications->count() > 0)
                            <form action="{{ route('notifications.mark-all-as-read') }}" method="POST"
                                class="flex-shrink-0">
                                @csrf
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-md">
                                    すべて既読にする
                                </button>
                            </form>
                        @endif
                    </div>

                    <!-- フラッシュメッセージ -->
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- 通知リスト -->
                    <div class="space-y-4">
                        @forelse ($notifications as $notification)
                            <div
                                class="flex items-start p-4 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }} border rounded-lg">
                                <div class="flex-grow">
                                    @if ($notification->type === 'App\Notifications\InvoiceNotification')
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="font-semibold text-lg text-gray-900">お支払い完了のお知らせ</h3>
                                                <p class="text-gray-600">請求書番号:
                                                    {{ $notification->data['invoice_number'] }}</p>
                                                <p class="text-gray-600">金額:
                                                    {{ number_format($notification->data['amount']) }}円</p>
                                                <p class="text-gray-600">ステータス: {{ $notification->data['status'] }}</p>
                                                <p class="text-gray-600">支払日:
                                                    {{ \Carbon\Carbon::parse($notification->data['paid_at'])->format('Y年m月d日') }}
                                                </p>
                                            </div>
                                            <div class="flex items-center space-x-4">
                                                <a href="{{ route('invoices.show', $notification->data['invoice_id']) }}"
                                                    class="text-blue-600 hover:text-blue-800 text-sm">
                                                    詳細を見る
                                                </a>
                                                @unless ($notification->read_at)
                                                    <form
                                                        action="{{ route('notifications.mark-as-read', $notification->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="text-sm text-blue-600 hover:text-blue-800 bg-white px-3 py-1 rounded-full shadow-sm">
                                                            既読にする
                                                        </button>
                                                    </form>
                                                @endunless
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="font-semibold text-lg text-gray-900">
                                                    {{ $notification->data['message'] ?? '通知' }}</h3>
                                                <p class="text-sm text-gray-500">
                                                    {{ $notification->created_at->format('Y年m月d日 H:i') }}</p>
                                            </div>
                                            @unless ($notification->read_at)
                                                <form
                                                    action="{{ route('notifications.mark-as-read', $notification->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-sm text-blue-600 hover:text-blue-800 bg-white px-3 py-1 rounded-full shadow-sm">
                                                        既読にする
                                                    </button>
                                                </form>
                                            @endunless
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                通知はありません
                            </div>
                        @endforelse
                    </div>

                    <!-- ページネーション -->
                    @if ($notifications->hasPages())
                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
