<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar®️ | プロフィール編集</title>
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
                            <h2 class="text-3xl font-bold text-gray-900 mb-8">プロフィール編集</h2>

                            @if (session('success'))
                                <div class="bg-green-50 border-l-4 border-green-400 text-green-900 text-xl p-4 mb-6"
                                    role="alert">{{ session('success') }}</div>
                            @endif
                            @if (session('error'))
                                <div class="bg-red-50 border-l-4 border-red-400 text-red-900 text-xl p-4 mb-6"
                                    role="alert">{{ session('error') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="bg-red-50 border-l-4 border-red-400 text-red-800 p-4 mb-6" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('tax_advisor.profile.update') }}"
                                enctype="multipart/form-data" class="space-y-6">
                                @csrf
                                @method('PATCH')

                                <!-- 事務所名 -->
                                <div>
                                    <label for="office_name"
                                        class="block text-2xl font-medium text-pink-700">事務所名</label>
                                    <input type="text" name="office_name" id="office_name"
                                        value="{{ old('office_name', $taxAdvisor->office_name ?? '') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-2xl"
                                        required>
                                    @error('office_name')
                                        <p class="mt-1 text-base text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- 郵便番号 -->
                                <div>
                                    <label for="postal_code"
                                        class="block text-2xl font-medium text-yellow-700">郵便番号</label>
                                    <input type="text" name="postal_code" id="postal_code"
                                        value="{{ old('postal_code', $taxAdvisor->postal_code ?? '') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-2xl"
                                        required>
                                    @error('postal_code')
                                        <p class="mt-1 text-base text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- 都道府県 -->
                                <div>
                                    <label for="prefecture"
                                        class="block text-2xl font-medium text-green-700">都道府県</label>
                                    <select name="prefecture" id="prefecture"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-2xl"
                                        required>
                                        <option value="">選択してください</option>
                                        @foreach (['北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県', '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県', '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県', '静岡県', '愛知県', '三重県', '滋賀県', '京都府', '大阪府', '兵庫県', '奈良県', '和歌山県', '鳥取県', '島根県', '岡山県', '広島県', '山口県', '徳島県', '香川県', '愛媛県', '高知県', '福岡県', '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県'] as $pref)
                                            <option value="{{ $pref }}"
                                                {{ old('prefecture', $taxAdvisor->prefecture ?? '') == $pref ? 'selected' : '' }}>
                                                {{ $pref }}</option>
                                        @endforeach
                                    </select>
                                    @error('prefecture')
                                        <p class="mt-1 text-base text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- 住所 -->
                                <div>
                                    <label for="address" class="block text-2xl font-medium text-blue-700">住所</label>
                                    <input type="text" name="address" id="address"
                                        value="{{ old('address', $taxAdvisor->address ?? '') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-2xl"
                                        required>
                                    @error('address')
                                        <p class="mt-1 text-base text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- 事務所電話番号 -->
                                <div>
                                    <label for="office_phone"
                                        class="block text-2xl font-medium text-purple-700">事務所電話番号</label>
                                    <input type="text" name="office_phone" id="office_phone"
                                        value="{{ old('office_phone', $taxAdvisor->office_phone ?? '') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-2xl"
                                        required>
                                    @error('office_phone')
                                        <p class="mt-1 text-base text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- 携帯電話番号 -->
                                <div>
                                    <label for="mobile_phone"
                                        class="block text-2xl font-medium text-indigo-700">携帯電話番号</label>
                                    <input type="text" name="mobile_phone" id="mobile_phone"
                                        value="{{ old('mobile_phone', $taxAdvisor->mobile_phone ?? '') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-2xl">
                                    @error('mobile_phone')
                                        <p class="mt-1 text-base text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- 専門分野 -->
                                <div>
                                    <label for="specialty"
                                        class="block text-2xl font-medium text-rose-700">専門分野</label>
                                    <input type="text" name="specialty" id="specialty"
                                        value="{{ old('specialty', $taxAdvisor->specialty ?? '') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-2xl">
                                    @error('specialty')
                                        <p class="mt-1 text-base text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- プロフィール情報 -->
                                <div>
                                    <label for="profile_info"
                                        class="block text-2xl font-medium text-orange-700">プロフィール情報</label>
                                    <textarea name="profile_info" id="profile_info" rows="4"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-2xl">{{ old('profile_info', $taxAdvisor->profile_info ?? '') }}</textarea>
                                    @error('profile_info')
                                        <p class="mt-1 text-base text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- 税理士写真 -->
                                <div>
                                    <label for="tax_accountant_photo"
                                        class="block text-2xl font-medium text-cyan-700">税理士写真</label>
                                    @if ($taxAdvisor && $taxAdvisor->tax_accountant_photo)
                                        <div class="mt-2 mb-4">
                                            <img src="{{ asset('storage/' . $taxAdvisor->tax_accountant_photo) }}"
                                                alt="税理士写真" class="w-32 h-32 object-cover rounded-lg">
                                        </div>
                                    @endif
                                    <input type="file" name="tax_accountant_photo" id="tax_accountant_photo"
                                        class="mt-1 block w-full" accept="image/*">
                                    <p class="mt-1 text-base text-gray-500">※ 新しい写真をアップロードすると、既存の写真は置き換えられます。</p>
                                    @error('tax_accountant_photo')
                                        <p class="mt-1 text-base text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- TaxMinutes用アイコン -->
                                <div>
                                    <label for="tax_minutes_icon"
                                        class="block text-2xl font-medium text-lime-700">TaxMinutes用アイコン</label>
                                    @if ($taxAdvisor && $taxAdvisor->tax_minutes_icon)
                                        <div class="mt-2 mb-4">
                                            <img src="{{ asset('storage/' . $taxAdvisor->tax_minutes_icon) }}"
                                                alt="TaxMinutes用アイコン" class="w-24 h-24 object-cover rounded-full">
                                        </div>
                                    @endif
                                    <input type="file" name="tax_minutes_icon" id="tax_minutes_icon"
                                        class="mt-1 block w-full" accept="image/*">
                                    <p class="mt-1 text-base text-gray-500">※
                                        TaxMinutesの動画一覧や詳細ページで表示されるアイコンです。設定しない場合は税理士写真が使用されます。</p>
                                    @error('tax_minutes_icon')
                                        <p class="mt-1 text-base text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex justify-end space-x-4">
                                    <a href="{{ route('dashboard') }}"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                        キャンセル
                                    </a>
                                    <button type="submit"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        更新する
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
