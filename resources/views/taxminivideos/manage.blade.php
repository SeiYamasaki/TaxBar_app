<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar®️ | 動画管理</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .dropdown-menu {
            display: none;
        }

        .dropdown-menu.show {
            display: block;
        }
    </style>
</head>

<body class="flex h-full bg-gray-100">
    <!-- サイドバー -->
    <x-tax-advisor.sidebar :user="$user" />

    <!-- メインコンテンツ -->
    <div class="flex-1 ml-64">
        <!-- ヘッダー -->
        <header class="bg-transparent fixed top-0 right-0 left-64 z-40">
            <div class="flex justify-end items-center h-16 px-6">
                <!-- アカウントメニュー -->
                <div class="relative" id="accountMenu">
                    <button id="menuToggle" class="flex items-center space-x-3 focus:outline-none">
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
                                    d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </div>
                    </button>

                    <!-- ドロップダウンメニュー -->
                    <div id="dropdownMenu"
                        class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
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

        <x-parallax-header />

        <div class="relative w-full -mt-24 z-50">
            <main class="container mx-auto px-6 py-8">
                <div class="bg-white shadow-md rounded-lg p-8 max-w-6xl mx-auto">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-3xl font-bold text-gray-800">動画管理</h1>
                        <a href="{{ route('dashboard') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            ダッシュボードに戻る
                        </a>
                    </div>

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

                    <!-- 動画一覧 -->
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-yellow-500 pb-2 inline-block">
                            アップロード済み動画一覧
                            <span class="text-sm font-normal text-gray-500 ml-2">({{ $videos->total() }}件)</span>
                        </h2>

                        <div class="bg-white border rounded-lg overflow-hidden shadow-sm">
                            @if ($videos->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white">
                                        <thead>
                                            <tr class="bg-gray-100 text-gray-700">
                                                <th class="py-3 px-4 border-b text-left">サムネイル</th>
                                                <th class="py-3 px-4 border-b text-left">タイトル</th>
                                                <th class="py-3 px-4 border-b text-left">説明</th>
                                                <th class="py-3 px-4 border-b text-left">投稿日</th>
                                                <th class="py-3 px-4 border-b text-left">再生数</th>
                                                <th class="py-3 px-4 border-b text-left">コメント数</th>
                                                <th class="py-3 px-4 border-b text-left">アクション</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($videos as $video)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="py-3 px-4 border-b">
                                                        <div class="w-24 h-16 bg-gray-200 rounded overflow-hidden">
                                                            @if ($video->thumbnail_path)
                                                                <img src="{{ asset('storage/' . $video->thumbnail_path) }}"
                                                                    alt="サムネイル" class="w-full h-full object-cover">
                                                            @else
                                                                <div
                                                                    class="w-full h-full flex items-center justify-center bg-gray-300 text-gray-500">
                                                                    <svg class="w-8 h-8" fill="currentColor"
                                                                        viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd"
                                                                            d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z"
                                                                            clip-rule="evenodd"></path>
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-4 border-b">
                                                        <div class="font-medium">{{ $video->title }}</div>
                                                    </td>
                                                    <td class="py-3 px-4 border-b">
                                                        <div class="max-w-xs truncate">{{ $video->description }}</div>
                                                    </td>
                                                    <td class="py-3 px-4 border-b">
                                                        {{ $video->created_at->format('Y/m/d') }}
                                                    </td>
                                                    <td class="py-3 px-4 border-b">
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 text-gray-400 mr-1"
                                                                fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                                <path fill-rule="evenodd"
                                                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                            {{ $video->views }}
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-4 border-b">
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 text-gray-400 mr-1"
                                                                fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                            {{ $video->comments->count() }}
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-4 border-b">
                                                        <div class="flex space-x-2">
                                                            <a href="{{ route('taxminivideos.edit', $video->id) }}"
                                                                class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded-lg text-sm flex items-center">
                                                                <svg class="w-4 h-4 mr-1" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                                    </path>
                                                                </svg>
                                                                編集
                                                            </a>
                                                            <form method="POST"
                                                                action="{{ route('taxminivideos.destroy', $video->id) }}"
                                                                onsubmit="return confirm('この動画を削除してもよろしいですか？');"
                                                                class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-lg text-sm flex items-center">
                                                                    <svg class="w-4 h-4 mr-1" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                        </path>
                                                                    </svg>
                                                                    削除
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- ページネーション -->
                                <div class="p-4 border-t">
                                    {{ $videos->links() }}
                                </div>
                            @else
                                <div class="p-8 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <p class="text-lg">アップロードした動画はありません</p>
                                    <p class="mt-2">ダッシュボードから新しい動画をアップロードしましょう</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- 新規動画アップロードボタン -->
                    <div class="flex justify-center mt-8">
                        <a href="{{ route('taxminivideos.create') }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-lg flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            新しい動画をアップロード
                        </a>
                    </div>
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
    <script>
        // ドロップダウンメニューの表示/非表示を切り替える
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('dropdownMenu').classList.toggle('show');
        });

        // 画面の他の部分をクリックするとメニューが閉じる
        document.addEventListener('click', function(event) {
            const accountMenu = document.getElementById('accountMenu');
            const dropdownMenu = document.getElementById('dropdownMenu');

            if (!accountMenu.contains(event.target) && dropdownMenu.classList.contains('show')) {
                dropdownMenu.classList.remove('show');
            }
        });
    </script>
</body>

</html>
