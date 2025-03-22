<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar®️ | Zoom連携設定</title>
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
    <x-tax-advisor.sidebar :user="$user" />

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
                <div class="max-w-6xl mx-auto">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="p-10 text-xl">
                            <h2 class="text-3xl font-bold text-gray-900 mb-8">Zoom連携設定</h2>

                            @if (session('success'))
                                <div class="bg-green-50 border-l-4 border-green-400 text-green-900 text-xl p-4 mb-6"
                                    role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="bg-red-50 border-l-4 border-red-400 text-red-900 text-xl p-4 mb-6"
                                    role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="mb-8">
                                <h3 class="text-2xl font-medium text-blue-700 mb-2">Zoomアカウント連携</h3>
                                <p class="text-gray-600 mb-4 text-xl">
                                    あなたのZoomアカウントと連携することで、TaxBarの予約時にあなたのZoomアカウントでミーティングが作成されるようになります。
                                    連携前にZoom Marketplaceにて本アプリの権限を承認してください。
                                </p>

                                <div class="mt-6 mb-6 p-4 bg-blue-50 rounded-lg">
                                    <div class="flex items-center mb-3">
                                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="ml-2 text-blue-800 font-medium text-xl">Zoom連携のステータス</span>
                                    </div>

                                    @if ($hasValidZoomConnection)
                                        <div class="flex items-center text-green-700 text-xl">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>Zoomアカウントと連携済みです</span>
                                        </div>
                                        <p class="mt-2 text-base text-gray-600">
                                            連携日時:
                                            {{ $taxAdvisor->zoom_token_expires_at->subHour()->format('Y年m月d日 H:i') }}
                                            <br>
                                            アカウントID: {{ Str::mask($taxAdvisor->zoom_account_id, '*', 5, 5) }}
                                        </p>
                                    @else
                                        <div class="flex items-center text-yellow-700 text-xl">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                </path>
                                            </svg>
                                            <span>Zoomアカウントとの連携が必要です</span>
                                        </div>
                                        <p class="mt-2 text-base text-gray-600">
                                            Zoomとの連携が行われていないため、現在は共有のZoomアカウントでミーティングが作成されます。
                                        </p>
                                    @endif
                                </div>

                                <div class="mt-6">
                                    @if ($hasValidZoomConnection)
                                        <form method="POST" action="{{ route('tax-advisor.zoom.disconnect') }}">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-xl font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                                onclick="return confirm('Zoomアカウントとの連携を解除しますか？');">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                                Zoom連携を解除する
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('tax-advisor.zoom.connect') }}"
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-xl font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                                </path>
                                            </svg>
                                            Zoomアカウントと連携する
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="border-t pt-6">
                                <h3 class="text-2xl font-medium text-purple-700 mb-2">Zoom連携のメリット</h3>
                                <ul class="list-disc pl-5 text-gray-600 space-y-2 text-xl">
                                    <li>お客様との面談が自分のZoomアカウントで行われるため、ブランディングの一貫性が保たれます</li>
                                    <li>Zoomでのすべての設定（待機室、録画など）を自由にカスタマイズできます</li>
                                    <li>Zoomのレポート機能や分析ツールを活用できます</li>
                                    <li>ホストとしての完全な権限を持ちます</li>
                                </ul>
                            </div>

                            <div class="border-t pt-6 mt-6">
                                <h3 class="text-2xl font-medium text-pink-700 mb-2">Zoom連携のよくある質問</h3>
                                <div class="space-y-4">
                                    <div>
                                        <h4 class="font-medium text-gray-800 text-xl">Q: 連携しない場合はどうなりますか？</h4>
                                        <p class="text-gray-600 text-xl">A:
                                            TaxBarのシステムアカウントを使用してミーティングが作成されます。基本的な機能は利用できますが、カスタマイズやホスト権限は制限されます。</p>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800 text-xl">Q: 連携を解除するとどうなりますか？</h4>
                                        <p class="text-gray-600 text-xl">A:
                                            既に作成された予約のZoomリンクは有効ですが、新しい予約はTaxBarのシステムアカウントを使用します。</p>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800 text-xl">Q: 無料のZoomアカウントでも連携できますか？</h4>
                                        <p class="text-gray-600 text-xl">A:
                                            はい、連携自体は可能ですが、無料アカウントの場合40分の時間制限などがありますのでご注意ください。
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t pt-6 mt-6 text-right">
                                <a href="{{ route('dashboard') }}"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-xl font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    ダッシュボードに戻る
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
