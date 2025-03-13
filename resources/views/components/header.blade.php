<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ハンバーガーメニュー</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* 🌈 グラデーションアニメーション */
        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }

        }

        .animate-gradient {
            background-size: 800% 800%;
            animation: gradientMove 2.5s infinite linear;
        }
    </style>
</head>

<body class="bg-gray-100">

    <!-- ✅ ヘッダー -->
    <header
        class="bg-white bg-opacity-100 shadow-none fixed w-full top-0 left-0 z-50 min-h-[60px] flex items-center px-6 py-4">
        <div class="w-full max-w-none flex sm:justify-start lg:justify-between items-center px-6 py-4">

            <!-- ✅ ロゴ（左側） -->
            <div class="logo sm:ml-0 lg:ml-auto">
                <a href="/">
                    <img src="{{ asset('images/logo.png') }}" alt="ロゴ" style="height: 75px; width: auto;">
                </a>
            </div>

            <!-- ✅ デスクトップナビゲーション（中央均等配置） -->
            <nav class="hidden lg:flex w-full justify-center">
                <ul class="flex flex-wrap justify-center gap-x-4 gap-y-2 max-w-[80%]">
                    <li><a href="/" class="text-gray-700 hover:text-blue-500 text-lg">HOME</a>
                        </li>
                    <li><a href="/" class="text-gray-700 hover:text-blue-500 text-lg">HOME</a></li>
                    <li><a href="/taxminivideos" class="text-gray-700 hover:text-blue-500 text-lg">Tax Minutes®</a></li>
                    <li><a href="/view/theme" class="text-gray-700 hover:text-blue-500 text-lg">テーマ</a></li>
                    <li><a href="/view/prohibited" class="text-gray-700 hover:text-blue-500 text-lg">禁止事項</a></li>
                    <li><a href="/inquiry" class="text-gray-700 hover:text-blue-500 text-lg">問合せ</a></li>
                    <li><a href="/faq" class="text-gray-700 hover:text-blue-500 text-lg">よくある質問</a></li>
                    <li><a href="/pricing" class="text-gray-700 hover:text-blue-500 text-lg">料金表</a></li>
                    <li><a href="/view/hachimantaishi" class="text-gray-700 hover:text-blue-500 text-lg">八幡平市</a></li>
                    <li><a href="/register/select" class="text-gray-700 hover:text-blue-500 text-lg">登録フォーム</a></li>
                    @guest
                        <li><a href="/login" class="text-gray-700 hover:text-blue-500 text-lg">ログイン</a></li>
                    @else
                        <li>
                            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-500 text-lg">マイページ</a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit"
                                    class="text-gray-700 hover:text-blue-500 text-lg bg-transparent border-none cursor-pointer p-0">
                                    ログアウト
                                </button>
                            </form>
                        </li>
                    @endguest
                    <li><a href="/tax-advisors" class="text-gray-700 hover:text-blue-500 text-lg">税理士の方へ</a></li>
                    <li><a href="/special" class="text-gray-700 hover:text-blue-500 text-lg">特集ページ</a></li>
                    <li><a href="#" class="text-gray-700 hover:text-blue-500 text-lg">相続でお困りの方へ</a></li>
                    <li><a href="#" class="text-gray-700 hover:text-blue-500 text-lg">TaxBar®とは？</a></li>
                </ul>
            </nav>


            <!-- ✅ ハンバーガーメニュー（スマホ用・一番右） -->
            <div x-data="{ open: false }" class="relative lg:hidden ml-auto">
                <!-- 🌈 グラデーション付きハンバーガーボタン -->
                <button @click="open = !open"
                    class="p-2 rounded-md focus:outline-none bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 text-white transition-all duration-500 ease-in-out hover:scale-110 animate-gradient">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>

                <!-- 📌 メニュー（クリックで開閉） -->
                <nav x-show="open" @click.away="open = false" x-transition
                    class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg max-h-[80vh] overflow-y-auto">
                    <ul class="flex flex-col space-y-2 p-4">
                        <li><a href="/"
                                class="block px-4 py-2 text-white bg-gradient-to-r from-red-500 via-yellow-400 via-green-500 via-blue-400 to-purple-500 rounded-md shadow-xl transition-all duration-700 ease-in-out hover:scale-105 hover:brightness-200 animate-gradient">HOME</a>
                        </li>
                        <li><a href="/taxminivideos"
                                class="block px-4 py-2 text-white bg-gradient-to-r from-red-500 via-yellow-400 via-green-500 via-blue-400 to-purple-500 rounded-md shadow-xl transition-all duration-700 ease-in-out hover:scale-105 hover:brightness-200 animate-gradient">Tax
                                Minutes&reg;</a></li>
                        <li><a href="/view/theme"
                                class="block px-4 py-2 text-white bg-gradient-to-r from-red-500 via-yellow-400 via-green-500 via-blue-400 to-purple-500 rounded-md shadow-xl transition-all duration-700 ease-in-out hover:scale-105 hover:brightness-200 animate-gradient">テーマ</a>
                        </li>
                        <li><a href="/view/prohibited"
                                class="block px-4 py-2 text-white bg-gradient-to-r from-red-500 via-yellow-400 via-green-500 via-blue-400 to-purple-500 rounded-md shadow-xl transition-all duration-700 ease-in-out hover:scale-105 hover:brightness-200 animate-gradient">禁止事項</a>
                        </li>
                        <li><a href="/inquiry"
                                class="block px-4 py-2 text-white bg-gradient-to-r from-red-500 via-yellow-400 via-green-500 via-blue-400 to-purple-500 rounded-md shadow-xl transition-all duration-700 ease-in-out hover:scale-105 hover:brightness-200 animate-gradient">問合せ</a>
                        </li>
                        <li><a href="/view/hachimantaishi"
                                class="block px-4 py-2 text-white bg-gradient-to-r from-red-500 via-yellow-400 via-green-500 via-blue-400 to-purple-500 rounded-md shadow-xl transition-all duration-700 ease-in-out hover:scale-105 hover:brightness-200 animate-gradient">八幡平市</a>
                        </li>
                        <li><a href="/faq"
                                class="block px-4 py-2 text-white bg-gradient-to-r from-red-500 via-yellow-400 via-green-500 via-blue-400 to-purple-500 rounded-md shadow-xl transition-all duration-700 ease-in-out hover:scale-105 hover:brightness-200 animate-gradient">よくある質問</a>
                        </li>
                        <li><a href="/pricing"
                                class="block px-4 py-2 text-white bg-gradient-to-r from-red-500 via-yellow-400 via-green-500 via-blue-400 to-purple-500 rounded-md shadow-xl transition-all duration-700 ease-in-out hover:scale-105 hover:brightness-200 animate-gradient">料金表</a>
                        </li>
                        <li><a href="/tax-advisors"
                                class="block px-4 py-2 text-white bg-gradient-to-r from-red-500 via-yellow-400 via-green-500 via-blue-400 to-purple-500 rounded-md shadow-xl transition-all duration-700 ease-in-out hover:scale-105 hover:brightness-200 animate-gradient">税理士の方へ</a>
                        </li>
                        <li><a href="/special"
                                class="block px-4 py-2 text-white bg-gradient-to-r from-red-500 via-yellow-400 via-green-500 via-blue-400 to-purple-500 rounded-md shadow-xl transition-all duration-700 ease-in-out hover:scale-105 hover:brightness-200 animate-gradient">特集ページ</a>
                        </li>
                        <li><a href="#"
                                class="block px-4 py-2 text-white bg-gradient-to-r from-red-500 via-yellow-400 via-green-500 via-blue-400 to-purple-500 rounded-md shadow-xl transition-all duration-700 ease-in-out hover:scale-105 hover:brightness-200 animate-gradient">相続でお困りの方へ</a>
                        </li>
                        <li><a href="/register/select"
                                class="block px-4 py-2 text-white bg-gradient-to-r from-red-500 via-yellow-400 via-green-500 via-blue-400 to-purple-500 rounded-md shadow-xl transition-all duration-700 ease-in-out hover:scale-105 hover:brightness-200 animate-gradient">登録フォーム</a>
                        </li>
                        @guest
                            <li><a href="/login"
                                    class="block px-4 py-2 text-white bg-gradient-to-r from-red-500 via-yellow-400 via-green-500 via-blue-400 to-purple-500 rounded-md shadow-xl transition-all duration-700 ease-in-out hover:scale-105 hover:brightness-200 animate-gradient">ログイン</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('dashboard') }}"
                                    class="block px-4 py-2 text-white bg-gradient-to-r from-red-500 via-yellow-400 via-green-500 via-blue-400 to-purple-500 rounded-md shadow-xl transition-all duration-700 ease-in-out hover:scale-105 hover:brightness-200 animate-gradient">マイページ</a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left block px-4 py-2 text-white bg-gradient-to-r from-red-500 via-yellow-400 via-green-500 via-blue-400 to-purple-500 rounded-md shadow-xl transition-all duration-700 ease-in-out hover:scale-105 hover:brightness-200 animate-gradient">
                                        ログアウト
                                    </button>
                                </form>
                            </li>
                        @endguest
                    </ul>
                </nav>

            </div>
        </div>
    </header>

    <!-- ✅ Alpine.js を追加（ハンバーガーメニューの開閉用） -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</body>

</html>
