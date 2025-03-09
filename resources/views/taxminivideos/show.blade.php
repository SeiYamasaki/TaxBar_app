<!-- ✅ ヘッダー -->
<header class="bg-white bg-opacity-100 shadow-none fixed w-full top-0 left-0 z-50 min-h-[60px]">
    <div class="container mx-auto sm:flex sm:justify-start lg:justify-between items-center px-6 py-4">
        <!-- ✅ ロゴを左端に配置（スマホでも確実に左寄せ） -->
        <div class="logo flex-shrink-0 ml-0 lg:ml-auto">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" alt="ロゴ" class="h-10">
            </a>
        </div>

        <!-- ✅ デスクトップナビゲーション（中央均等配置） -->
        <nav class="hidden lg:flex flex-1 justify-center">
            <ul class="flex space-x-8">
                <li><a href="/" class="text-gray-700 hover:text-blue-500 text-lg">HOME</a></li>
                <li><a href="/taxminivideos" class="text-gray-700 hover:text-blue-500 text-lg">Tax Minutes&reg;</a></li>
                <li><a href="/view/theme" class="text-gray-700 hover:text-blue-500 text-lg">テーマ</a></li>
                <li><a href="/view/prohibited" class="text-gray-700 hover:text-blue-500 text-lg">禁止事項</a></li>
                <li><a href="/inquiry" class="text-gray-700 hover:text-blue-500 text-lg">問合せ</a></li>
                <li><a href="/view/hachimantaishi" class="text-gray-700 hover:text-blue-500 text-lg">八幡平市</a></li>
                <li><a href="/faq" class="text-gray-700 hover:text-blue-500 text-lg">よくある質問</a></li>
                <li><a href="/pricing" class="text-gray-700 hover:text-blue-500 text-lg">料金表</a></li>
                <li><a href="/register/select" class="text-gray-700 hover:text-blue-500 text-lg">登録フォーム</a></li>
                <li><a href="/login" class="text-gray-700 hover:text-blue-500 text-lg">ログイン</a></li>
            </ul>
        </nav>

        <!-- ✅ ハンバーガーメニュー（スマホ用・一番右） -->
        <div x-data="{ open: false }" class="relative lg:hidden ml-auto">
            <button @click="open = !open" class="p-2 rounded-md focus:outline-none">
                <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>

            <nav x-show="open" @click.away="open = false" x-transition
                class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg">
                <ul class="flex flex-col space-y-2 p-4">
                    <li><a href="/" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">HOME</a></li>
                    <li><a href="/taxminivideos" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Tax Minutes&reg;</a></li>
                    <li><a href="/view/theme" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">テーマ</a></li>
                    <li><a href="/view/prohibited" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">禁止事項</a></li>
                    <li><a href="/inquiry" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">問合せ</a></li>
                    <li><a href="/view/hachimantaishi" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">八幡平市</a></li>
                    <li><a href="/faq" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">よくある質問</a></li>
                    <li><a href="/pricing" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">料金表</a></li>
                    <li><a href="/register/select" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">登録フォーム</a></li>
                    <li><a href="/login" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">ログイン</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>
