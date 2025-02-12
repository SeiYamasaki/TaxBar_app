<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar&reg | お問合わせフォーム</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-gray-100">

    <!-- ヘッダー -->
    <header class="bg-black text-white shadow-md">
        <div class="container mx-auto flex justify-center items-center p-6">
            <!-- ナビゲーション -->
            <nav class="nav">
                <ul class="flex gap-8 justify-center items-center w-full">
                    <li><a href="/" class="hover:text-red-500">HOME</a></li>
                    <li><a href="/taxminivideos" class="hover:text-red-500">Tax Minutes&reg;️</a></li>
                    <li><a href="#TaxBarabout" class="hover:text-red-500">TaxBar</a></li>
                    <li><a href="/view/prohibited" class="hover:text-red-500">禁止事項</a></li>
                    <li><a href="/view/hachimantaishi" class="hover:text-red-500">八幡平市</a></li>
                    <li><a href="/pricing" class="hover:text-red-500">料金表</a></li>
                    <li><a href="/faq" class="hover:text-red-500">よくある質問</a></li>
                    <li><a href="register/select" class="hover:text-red-500">登録フォーム</a></li>
                    <li><a href="/login" class="hover:text-red-500">ログイン</a></li>
                </ul>
            </nav>
        </div>
    </header>


    <!-- お問い合わせフォーム -->
    {{-- <div class="flex items-center justify-center min-h-screen p-4"> --}}
    <div class="flex items-center justify-center min-h-screen px-50">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">お問い合わせフォーム</h1>

            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('inquiry.confirm') }}" method="POST" class="space-y-4">
                @csrf

                <!-- 名前 -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">お名前</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- メールアドレス -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">メールアドレス</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 電話番号 -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">電話番号</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required>
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- お問い合わせ内容の選択 -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">お問い合わせ内容</label>
                    <div class="mt-2 space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="inquiry_type" value="通報の件" class="mr-2" required>
                            通報の件
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="inquiry_type" value="TaxBar®️出店について" class="mr-2">
                            TaxBar&reg出店について
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="inquiry_type" value="料金について" class="mr-2">
                            料金について
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="inquiry_type" value="TaxMinutes®️について" class="mr-2">
                            TaxMinutes&regについて
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="inquiry_type" value="禁止事項について" class="mr-2">
                            禁止事項について
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="inquiry_type" value="その他" class="mr-2">
                            その他
                        </label>
                    </div>
                    @error('inquiry_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- お問い合わせ内容 -->
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700">お問い合わせ内容</label>
                    <textarea id="message" name="message" rows="5"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required>{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 送信ボタン -->
                <div>
                    <button type="submit"
                        class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md shadow-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        確認画面へ
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- フッター -->
    <footer>
        <div class="container">
            <p>&copy; 2025 TaxBar® Tax Minutes®. All rights reserved.</p>
            <div class="prefecture-links">
                <ul>
                    <li><a href="#">北海道</a></li>
                    <li><a href="#">青森県</a></li>
                    <li><a href="#">岩手県</a></li>
                    <li><a href="#">宮城県</a></li>
                    <li><a href="#">秋田県</a></li>
                    <li><a href="#">山形県</a></li>
                    <li><a href="#">福島県</a></li>
                    <li><a href="#">茨城県</a></li>
                    <li><a href="#">栃木県</a></li>
                    <li><a href="#">群馬県</a></li>
                    <li><a href="#">埼玉県</a></li>
                    <li><a href="#">千葉県</a></li>
                    <li><a href="#">東京都</a></li>
                    <li><a href="#">神奈川県</a></li>
                    <li><a href="#">新潟県</a></li>
                    <li><a href="#">富山県</a></li>
                    <li><a href="#">石川県</a></li>
                    <li><a href="#">福井県</a></li>
                    <li><a href="#">山梨県</a></li>
                    <li><a href="#">長野県</a></li>
                    <li><a href="#">岐阜県</a></li>
                    <li><a href="#">静岡県</a></li>
                    <li><a href="#">愛知県</a></li>
                    <li><a href="#">三重県</a></li>
                    <li><a href="#">滋賀県</a></li>
                    <li><a href="#">京都府</a></li>
                    <li><a href="#">大阪府</a></li>
                    <li><a href="#">兵庫県</a></li>
                    <li><a href="#">奈良県</a></li>
                    <li><a href="#">和歌山県</a></li>
                    <li><a href="#">鳥取県</a></li>
                    <li><a href="#">島根県</a></li>
                    <li><a href="#">岡山県</a></li>
                    <li><a href="#">広島県</a></li>
                    <li><a href="#">山口県</a></li>
                    <li><a href="#">徳島県</a></li>
                    <li><a href="#">香川県</a></li>
                    <li><a href="#">愛媛県</a></li>
                    <li><a href="#">高知県</a></li>
                    <li><a href="#">福岡県</a></li>
                    <li><a href="#">佐賀県</a></li>
                    <li><a href="#">長崎県</a></li>
                    <li><a href="#">熊本県</a></li>
                    <li><a href="#">大分県</a></li>
                    <li><a href="#">宮崎県</a></li>
                    <li><a href="#">鹿児島県</a></li>
                    <li><a href="#">沖縄県</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>

</html>
