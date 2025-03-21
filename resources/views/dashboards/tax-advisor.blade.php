<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar® | 税理士ダッシュボード</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="dashboard-body flex h-full bg-gray-100 relative">
    <!-- サイドバーコンポーネント：z-indexを60に変更 -->
    <x-tax-advisor.sidebar :user="$user" />

    <!-- メインコンテンツ -->
    <div class="flex-1 md:ml-64 transition-all duration-300 ease-in-out">
        <!-- プラン契約モーダル -->
        <div x-data="{ showModal: {{ !$user->taxAdvisor->subscription_plan_id ? 'true' : 'false' }} }" x-show="showModal" class="fixed inset-0 z-[9999] overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity z-[9999]" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-[10000]">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    プラン契約が必要です
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        この機能を利用するには、専門家プランの契約が必要です。料金プランをご確認ください。
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <a href="{{ route('pricing.index') }}"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            料金プランを見る
                        </a>
                        <button type="button" @click="window.location.href='{{ url('/') }}'"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            閉じる
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ヘッダー：スマホ表示のときだけ有色に -->
        <header class="fixed top-0 right-0 left-0 md:left-64 z-[999] bg-white md:bg-transparent shadow md:shadow-none">
            <div class="flex justify-between items-center h-16 px-4 md:px-6">
                <!-- モバイル用のハンバーガーメニューのスペース -->
                <div class="w-10 md:hidden"></div>

                <!-- アカウントメニュー - 右寄せ -->
                <div class="relative ml-auto" x-data="{ open: false }">
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
                                <span class="text-sm font-medium text-gray-700 md:text-white">{{ $user->name }}</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>

                    <!-- ドロップダウンメニュー -->
                    <div x-show="open" x-cloak @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-[10000]">
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

        <!-- パララックスヘッダー -->
        <x-parallax-header />

        <!-- メインコンテンツのパディング調整：z-indexを上げる -->
        <div class="relative w-full -mt-24 z-[50]">
            <main class="container mx-auto px-4 sm:px-6 py-8">
                <!-- ダッシュボードの概要 -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 lg:gap-8 mb-8">
                    <div class="bg-white rounded-lg shadow p-8">
                        <h3 class="text-2xl font-bold text-gray-700 mb-2">参加者数</h3>
                        <p class="text-5xl font-extrabold text-blue-600">0</p>
                        <p class="text-base text-gray-500">登録済み参加者</p>
                    </div>

                    <div class="bg-white rounded-lg shadow p-8">
                        <h3 class="text-2xl font-bold text-gray-700 mb-2">TaxMinutes® 動画</h3>
                        <p class="text-5xl font-extrabold text-green-600">{{ $taxMinutesVideos->count() }}</p>
                        <p class="text-base text-gray-500">アップロード済み動画</p>
                    </div>


                    <div class="bg-white rounded-lg shadow p-8">
                        <h3 class="text-2xl font-bold text-gray-700 mb-2">未承認コメント</h3>
                        <p class="text-5xl font-extrabold text-yellow-600">{{ count($pendingComments) }}</p>
                        <p class="text-base text-gray-500">承認待ちのコメント</p>
                    </div>
                </div>

                <!-- メインコンテンツ -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                    <!-- 最近の動画 -->
                    <div class="bg-white rounded-lg shadow p-8">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">最近の動画</h2>
                            <a href="{{ route('taxminivideos.manage') }}"
                                class="text-blue-600 hover:text-blue-800 text-base font-semibold">すべて見る</a>
                        </div>

                        @if ($taxMinutesVideos->isEmpty())
                            <p class="text-gray-500 text-center py-6 text-xl font-semibold">動画がありません</p>
                        @else
                            <div class="space-y-6">
                                @foreach ($taxMinutesVideos->take(3) as $video)
                                    <div class="flex items-center space-x-6">
                                        <div class="flex-shrink-0">
                                            @if ($video->thumbnail_path)
                                                <img src="{{ asset('storage/' . $video->thumbnail_path) }}"
                                                    alt="サムネイル" class="w-40 h-40 object-cover rounded-lg">
                                            @else
                                                <div
                                                    class="w-40 h-40 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <svg class="w-10 h-10 text-gray-400" fill="none"
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
                                            <p class="text-2xl font-bold text-gray-900 truncate">
                                                {{ $video->title }}
                                            </p>
                                            <p class="text-lg text-gray-500">
                                                {{ $video->created_at->format('Y/m/d') }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>


                    <!-- 最近のコメント -->
                    <div class="bg-white rounded-lg shadow p-8">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">最近のコメント</h2>
                            <a href="{{ route('comments.received') }}"
                                class="text-blue-600 hover:text-blue-800 text-base font-semibold">すべて見る</a>
                        </div>

                        @if (count($pendingComments) === 0 && count($approvedComments) === 0)
                            <p class="text-gray-500 text-center py-6 text-xl font-semibold">コメントはありません</p>
                        @else
                            <div class="space-y-6">
                                @foreach ($pendingComments->merge($approvedComments)->take(3) as $comment)
                                    <div class="flex items-center space-x-6">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-3 h-3 rounded-full {{ $comment->is_approved ? 'bg-green-500' : 'bg-yellow-500' }}">
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4 min-w-0">
                                            @if (optional($comment->user)->profile_photo)
                                                <img src="{{ asset('storage/' . optional($comment->user)->profile_photo) }}"
                                                    alt="ユーザーの写真" class="w-14 h-14 rounded-full">
                                            @else
                                                <svg class="w-14 h-14 text-gray-400 bg-gray-100 rounded-full border-2 border-gray-200 p-1"
                                                    fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <p class="text-lg font-semibold text-gray-900 truncate">
                                                    {{ $comment->display_name }}</p>
                                                <p class="text-lg text-gray-500 truncate">
                                                    {{ Str::limit($comment->content, 50) }}</p>
                                                <p class="text-base text-gray-400">
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
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('modalData', () => ({
                showModal: {{ !$user->taxAdvisor->subscription_plan_id ? 'true' : 'false' }}
            }))
        })
    </script>
</body>

</html>
