<!-- フッター -->
<div class="bg-black text-gray-300 py-10 w-full">
    <!-- px-8 を付けることで、左右に少しだけ余白を確保 -->
    <div class="px-8 w-full">
        <!-- 1列(スマホ) → 6列(PC)に切り替え。縦線仕切り付き。 -->
        <div class="grid grid-cols-1 lg:grid-cols-6 gap-8 divide-x divide-gray-700">

            <!-- 北海道・東北地方 -->
            <div class="p-4">
                <h5 class="text-xl font-semibold mb-3 text-blue-300 text-left">北海道・東北地方</h5>
                <ul class="space-y-2 text-left">
                    @foreach (['北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県'] as $prefecture)
                        <li>
                            <a href="{{ route('tax-advisors.prefecture', ['prefecture' => $prefecture]) }}"
                                class="hover:text-blue-200 hover:underline">{{ $prefecture }}</a>
                            @if (isset($advisorsByPrefecture[$prefecture]) && $advisorsByPrefecture[$prefecture]->count() > 0)
                                <ul class="ml-8">
                                    @foreach ($advisorsByPrefecture[$prefecture] as $advisor)
                                        <li class="flex items-center">
                                            <a href="{{ route('tax-advisors.show', $advisor->id) }}"
                                                class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">{{ $advisor->user->name }}</a>
                                            <img src="{{ asset('images/logotoumei.png') }}" alt="バッチ"
                                                class="h-8 rounded-full w-8">
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- 関東地方 -->
            <div class="p-4">
                <h5 class="text-xl font-semibold mb-3 text-blue-300">関東地方</h5>
                <ul class="space-y-2 text-left">
                    @foreach (['茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県'] as $prefecture)
                        <li>
                            <a href="{{ route('tax-advisors.prefecture', ['prefecture' => $prefecture]) }}"
                                class="hover:text-blue-200 hover:underline">{{ $prefecture }}</a>
                            @if (isset($advisorsByPrefecture[$prefecture]) && $advisorsByPrefecture[$prefecture]->count() > 0)
                                <ul class="ml-8">
                                    @foreach ($advisorsByPrefecture[$prefecture] as $advisor)
                                        <li class="flex items-center">
                                            <a href="{{ route('tax-advisors.show', $advisor->id) }}"
                                                class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">{{ $advisor->user->name }}</a>
                                            <img src="{{ asset('images/logotoumei.png') }}" alt="バッチ"
                                                class="h-8 rounded-full w-8">
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- 中部地方 -->
            <div class="p-4">
                <h5 class="text-xl font-semibold mb-3 text-blue-300">中部地方</h5>
                <ul class="space-y-2 text-left">
                    @foreach (['新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県', '静岡県', '愛知県'] as $prefecture)
                        <li>
                            <a href="{{ route('tax-advisors.prefecture', ['prefecture' => $prefecture]) }}"
                                class="hover:text-blue-200 hover:underline">{{ $prefecture }}</a>
                            @if (isset($advisorsByPrefecture[$prefecture]) && $advisorsByPrefecture[$prefecture]->count() > 0)
                                <ul class="ml-8">
                                    @foreach ($advisorsByPrefecture[$prefecture] as $advisor)
                                        <li class="flex items-center">
                                            <a href="{{ route('tax-advisors.show', $advisor->id) }}"
                                                class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">{{ $advisor->user->name }}</a>
                                            <img src="{{ asset('images/logotoumei.png') }}" alt="バッチ"
                                                class="h-8 rounded-full w-8">
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- 近畿地方 -->
            <div class="p-4">
                <h5 class="text-xl font-semibold mb-3 text-blue-300">近畿地方</h5>
                <ul class="space-y-2 text-left">
                    @foreach (['三重県', '滋賀県', '京都府', '大阪府', '兵庫県', '奈良県', '和歌山県'] as $prefecture)
                        <li>
                            <a href="{{ route('tax-advisors.prefecture', ['prefecture' => $prefecture]) }}"
                                class="hover:text-blue-200 hover:underline">{{ $prefecture }}</a>
                            @if (isset($advisorsByPrefecture[$prefecture]) && $advisorsByPrefecture[$prefecture]->count() > 0)
                                <ul class="ml-8">
                                    @foreach ($advisorsByPrefecture[$prefecture] as $advisor)
                                        <li class="flex items-center">
                                            <a href="{{ route('tax-advisors.show', $advisor->id) }}"
                                                class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">{{ $advisor->user->name }}</a>
                                            <img src="{{ asset('images/logotoumei.png') }}" alt="バッチ"
                                                class="h-8 rounded-full w-8">
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- 中国・四国地方 -->
            <div class="p-4">
                <h5 class="text-xl font-semibold mb-3 text-blue-300">中国地方・四国地方</h5>
                <ul class="space-y-2 text-left">
                    @foreach (['鳥取県', '島根県', '岡山県', '広島県', '山口県', '徳島県', '香川県', '愛媛県', '高知県'] as $prefecture)
                        <li>
                            <a href="{{ route('tax-advisors.prefecture', ['prefecture' => $prefecture]) }}"
                                class="hover:text-blue-200 hover:underline">{{ $prefecture }}</a>
                            @if (isset($advisorsByPrefecture[$prefecture]) && $advisorsByPrefecture[$prefecture]->count() > 0)
                                <ul class="ml-8">
                                    @foreach ($advisorsByPrefecture[$prefecture] as $advisor)
                                        <li class="flex items-center">
                                            <a href="{{ route('tax-advisors.show', $advisor->id) }}"
                                                class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">{{ $advisor->user->name }}</a>
                                            <img src="{{ asset('images/logotoumei.png') }}" alt="バッチ"
                                                class="h-8 rounded-full w-8">
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- 九州・沖縄地方 -->
            <div class="p-4">
                <h5 class="text-xl font-semibold mb-3 text-blue-300">九州・沖縄地方</h5>
                <ul class="space-y-2 text-left">
                    @foreach (['福岡県', '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県'] as $prefecture)
                        <li>
                            <a href="{{ route('tax-advisors.prefecture', ['prefecture' => $prefecture]) }}"
                                class="hover:text-blue-200 hover:underline">{{ $prefecture }}</a>
                            @if (isset($advisorsByPrefecture[$prefecture]) && $advisorsByPrefecture[$prefecture]->count() > 0)
                                <ul class="ml-8">
                                    @foreach ($advisorsByPrefecture[$prefecture] as $advisor)
                                        <li class="flex items-center">
                                            <a href="{{ route('tax-advisors.show', $advisor->id) }}"
                                                class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">{{ $advisor->user->name }}</a>
                                            <img src="{{ $advisor->tax_accountant_photo ? asset('storage/' . $advisor->tax_accountant_photo) : asset('images/logotoumei.png') }}"
                                                alt="{{ $advisor->user->name }}" class="h-12 rounded-full w-12 ml-2">
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- コピーライト表記 -->
        <p class="text-center text-sm mt-8 text-gray-400 w-full">
            &copy; 2025 TaxBar® Tax Minutes®. All rights reserved.
        </p>
    </div>
</div>
