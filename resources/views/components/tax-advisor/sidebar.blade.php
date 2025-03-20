<!-- モバイルハンバーガーボタン -->
<div class="fixed top-4 left-4 z-[1000] block md:hidden">
    <button id="sidebar-toggle" class="p-2 rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none shadow">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>
</div>

<!-- サイドバー -->
<aside id="sidebar"
    class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg z-[950] transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out overflow-y-auto">
    <div class="flex flex-col h-full">
        <!-- ロゴ -->
        <div class="flex justify-center p-4 border-b">
            <img src="/images/logotoumei.png" alt="ロゴ" class="h-12">
        </div>

        <!-- 閉じるボタン（モバイル用） -->
        <div class="absolute top-4 right-4 md:hidden">
            <button id="sidebar-close" class="p-2 rounded-md text-gray-700 hover:bg-gray-100 focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- メニュー -->
        <nav class="flex-1 overflow-y-auto py-4">
            <div class="px-4 space-y-2">
                <!-- ダッシュボード -->
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-4 py-2 text-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-100' : '' }} hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    ダッシュボード
                </a>
                <!-- TaxBar®️ 予約 -->
                <a href="{{ route('calendar') }}"
                    class="flex items-center px-4 py-2 text-gray-600 {{ request()->routeIs('calendar') ? 'bg-gray-100' : '' }} hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    TaxBar® 予約
                </a>

                <!-- Tax Minutes® 動画管理 -->
                <a href="{{ route('taxminivideos.manage') }}"
                    class="flex items-center px-4 py-2 text-gray-600 {{ request()->routeIs('taxminivideos.manage') ? 'bg-gray-100' : '' }} hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                        </path>
                    </svg>
                    Tax Minutes® 管理
                </a>

                <!-- コメント管理 -->
                <a href="{{ route('comments.received') }}"
                    class="flex items-center px-4 py-2 text-gray-600 {{ request()->routeIs('comments.received') ? 'bg-gray-100' : '' }} hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                        </path>
                    </svg>
                    コメント管理
                </a>

                <!-- クライアント管理 -->
                <a href="#"
                    class="flex items-center px-4 py-2 text-gray-600 {{ request()->routeIs('clients') ? 'bg-gray-100' : '' }} hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    参加者リスト
                </a>

                <!-- ユーザー設定 -->
                <a href="{{ route('tax_advisor.profile.edit') }}"
                    class="flex items-center px-4 py-2 text-gray-600 {{ request()->routeIs('tax_advisor.profile.edit') ? 'bg-gray-100' : '' }} hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    プロフィール編集
                </a>

                <!-- プラン変更 -->
                <a href="{{ route('pricing.index') }}"
                    class="flex items-center px-4 py-2 text-gray-600 {{ request()->routeIs('pricing.index') ? 'bg-gray-100' : '' }} hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    プラン変更
                </a>

                <!-- ログアウト -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex items-center px-4 py-2 text-gray-600 {{ request()->routeIs('logout') ? 'bg-gray-100' : '' }} hover:bg-gray-100 rounded-lg">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v2a2 2 0 01-2 2H9a2 2 0 01-2-2v-2">
                            </path>
                        </svg>
                        ログアウト
                    </button>
                </form>
            </div>
        </nav>

        <!-- 契約プラン -->
        <p class="text-center text-sm font-medium text-gray-700">
            ご契約中プラン
        </p>
        <div class="p-4 border-t">
            <div class="flex items-center">
                <div class="flex-1">
                    @if ($user->taxAdvisor && $user->taxAdvisor->subscriptionPlan)
                        @php
                            $plan = $user->taxAdvisor->subscriptionPlan;
                            $colors = [
                                'ゴールドプラン' => [
                                    'bg' => 'bg-gradient-to-r from-yellow-500 to-yellow-600',
                                    'badge' => 'bg-yellow-300 text-yellow-800',
                                    'label' => 'おすすめ',
                                ],
                                'プラチナプラン' => [
                                    'bg' => 'bg-gradient-to-r from-blue-500 to-blue-600',
                                    'badge' => 'bg-blue-300 text-blue-800',
                                    'label' => '人気',
                                ],
                                'VIPプラン' => [
                                    'bg' => 'bg-gradient-to-r from-purple-600 to-purple-700',
                                    'badge' => 'bg-purple-300 text-purple-800',
                                    'label' => '最上級',
                                ],
                            ];
                            $planColor = $colors[$plan->name] ?? [
                                'bg' => 'bg-gray-500',
                                'badge' => 'bg-gray-300 text-gray-800',
                                'label' => '契約中',
                            ];
                        @endphp
                        <div class="rounded-lg overflow-hidden shadow-sm">
                            <div class="p-3 {{ $planColor['bg'] }} text-white">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-bold">{{ $plan->name }}</p>
                                    <span class="text-xs {{ $planColor['badge'] }} px-2 py-1 rounded-full font-bold">
                                        {{ $planColor['label'] }}
                                    </span>
                                </div>

                            </div>
                        </div>
                    @else
                        <div class="rounded-lg overflow-hidden shadow-sm">
                            <div class="p-3 bg-gray-500 text-white">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-bold">契約プランなし</p>
                                </div>
                                <p class="text-xs mt-1">プランを選択してください</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- オーバーレイ（モバイル用） -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-[949] hidden"></div>

<script>
    // サイドバーの開閉機能
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarClose = document.getElementById('sidebar-close');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        // 初期状態の設定
        if (window.innerWidth < 768) {
            sidebar.classList.add('-translate-x-full');
        } else {
            sidebar.classList.remove('-translate-x-full');
        }

        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        });

        sidebarClose.addEventListener('click', function() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });

        overlay.addEventListener('click', function() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });

        // ウィンドウサイズ変更時の処理
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) { // md breakpoint
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        });
    });
</script>
