@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 pt-24">
        <div class="flex justify-center">
            <div class="w-full md:w-2/3 lg:w-1/2">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-100 px-6 py-4 border-b border-gray-200 font-semibold text-lg">税理士プロフィール編集</div>

                    <div class="p-6">
                        @if (session('success'))
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('tax_advisor.profile.update') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <!-- 事務所名 -->
                            <div class="mb-4">
                                <label for="office_name" class="block text-gray-700 text-sm font-bold mb-2">事務所名</label>
                                <input type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    name="office_name" value="{{ old('office_name', $taxAdvisor->office_name ?? '') }}"
                                    required>
                                @error('office_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- 郵便番号 -->
                            <div class="mb-4">
                                <label for="postal_code" class="block text-gray-700 text-sm font-bold mb-2">郵便番号</label>
                                <input type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    name="postal_code" value="{{ old('postal_code', $taxAdvisor->postal_code ?? '') }}"
                                    required>
                                @error('postal_code')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- 都道府県 -->
                            <div class="mb-4">
                                <label for="prefecture" class="block text-gray-700 text-sm font-bold mb-2">都道府県</label>
                                <select name="prefecture"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                                    <option value="">選択してください</option>
                                    @foreach (['北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県', '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県', '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県', '静岡県', '愛知県', '三重県', '滋賀県', '京都府', '大阪府', '兵庫県', '奈良県', '和歌山県', '鳥取県', '島根県', '岡山県', '広島県', '山口県', '徳島県', '香川県', '愛媛県', '高知県', '福岡県', '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県'] as $pref)
                                        <option value="{{ $pref }}"
                                            {{ old('prefecture', $taxAdvisor->prefecture ?? '') == $pref ? 'selected' : '' }}>
                                            {{ $pref }}</option>
                                    @endforeach
                                </select>
                                @error('prefecture')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- 住所 -->
                            <div class="mb-4">
                                <label for="address" class="block text-gray-700 text-sm font-bold mb-2">住所</label>
                                <input type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    name="address" value="{{ old('address', $taxAdvisor->address ?? '') }}" required>
                                @error('address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- 事務所電話番号 -->
                            <div class="mb-4">
                                <label for="office_phone" class="block text-gray-700 text-sm font-bold mb-2">事務所電話番号</label>
                                <input type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    name="office_phone" value="{{ old('office_phone', $taxAdvisor->office_phone ?? '') }}"
                                    required>
                                @error('office_phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- 携帯電話番号 -->
                            <div class="mb-4">
                                <label for="mobile_phone" class="block text-gray-700 text-sm font-bold mb-2">携帯電話番号</label>
                                <input type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    name="mobile_phone" value="{{ old('mobile_phone', $taxAdvisor->mobile_phone ?? '') }}">
                                @error('mobile_phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- 専門分野 -->
                            <div class="mb-4">
                                <label for="specialty" class="block text-gray-700 text-sm font-bold mb-2">専門分野</label>
                                <input type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    name="specialty" value="{{ old('specialty', $taxAdvisor->specialty ?? '') }}">
                                @error('specialty')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- プロフィール情報 -->
                            <div class="mb-4">
                                <label for="profile_info"
                                    class="block text-gray-700 text-sm font-bold mb-2">プロフィール情報</label>
                                <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    name="profile_info" rows="4">{{ old('profile_info', $taxAdvisor->profile_info ?? '') }}</textarea>
                                @error('profile_info')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- 税理士写真 -->
                            <div class="mb-4">
                                <label for="tax_accountant_photo"
                                    class="block text-gray-700 text-sm font-bold mb-2">税理士写真</label>
                                @if ($taxAdvisor && $taxAdvisor->tax_accountant_photo)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $taxAdvisor->tax_accountant_photo) }}"
                                            alt="税理士写真" class="w-32 h-32 object-cover rounded-lg">
                                    </div>
                                @endif
                                <input type="file"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    name="tax_accountant_photo" accept="image/*">
                                <p class="text-gray-500 text-xs mt-1">※ 新しい写真をアップロードすると、既存の写真は置き換えられます。</p>
                                @error('tax_accountant_photo')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- TaxMinutes用アイコン -->
                            <div class="mb-4">
                                <label for="tax_minutes_icon"
                                    class="block text-gray-700 text-sm font-bold mb-2">TaxMinutes用アイコン</label>
                                @if ($taxAdvisor && $taxAdvisor->tax_minutes_icon)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $taxAdvisor->tax_minutes_icon) }}"
                                            alt="TaxMinutes用アイコン" class="w-24 h-24 object-cover rounded-full">
                                    </div>
                                @endif
                                <input type="file"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    name="tax_minutes_icon" accept="image/*">
                                <p class="text-gray-500 text-xs mt-1">※
                                    TaxMinutesの動画一覧や詳細ページで表示されるアイコンです。設定しない場合は税理士写真が使用されます。</p>
                                @error('tax_minutes_icon')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-between mt-6">
                                <a href="{{ route('dashboard') }}"
                                    class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                                    戻る
                                </a>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                                    更新する
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
