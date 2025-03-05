<!-- フッター -->
<footer class="bg-black text-gray-300 py-10 w-full">
    <!-- px-8 を付けることで、左右に少しだけ余白を確保 -->
    <div class="px-8 w-full">
        <!-- 1列(スマホ) → 6列(PC)に切り替え。縦線仕切り付き。 -->
        <div class="grid grid-cols-1 lg:grid-cols-6 gap-8 divide-x divide-gray-700">

            <!-- 北海道・東北地方 -->
            <div class="p-4">
                <h5 class="text-xl font-semibold mb-3 text-blue-300">北海道・東北地方</h5>
                <ul class="space-y-2">
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">北海道</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">青森県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">岩手県</a>
                        <ul class="ml-8">
                            <li class="flex items-center">
                                <a href="#"
                                    class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">沖野匠吾</a>
                                <img src="{{ asset('images/logo.png') }}" alt="Logo"
                                    class="h-10 ml-2 rounded-full w-10">
                            </li>
                            <li class="flex items-center">
                                <a href="#"
                                    class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">大垣由騎</a>
                                <img src="{{ asset('images/logo.png') }}" alt="Logo"
                                    class="h-10 ml-2 rounded-full w-10">
                            </li>
                        </ul>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">宮城県</a>
                        <ul class="ml-8">
                            <li class="flex items-center">
                                <a href="#"
                                    class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">佐藤
                                    幸久</a>
                                <img src="{{ asset('images/logo.png') }}" alt="Logo"
                                    class="h-10 ml-2 rounded-full w-10">
                            </li>
                        </ul>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">秋田県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">山形県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">福島県</a>
                    </li>
                </ul>
            </div>

            <!-- 関東地方 -->
            <div class="p-4">
                <h5 class="text-xl font-semibold mb-3 text-blue-300">関東地方</h5>
                <ul class="space-y-2">
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">茨城県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">栃木県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">群馬県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">埼玉県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">千葉県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">東京都</a>
                        <ul class="ml-8">
                            <li class="flex items-center">
                                <a href="#"
                                    class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">山崎
                                    聖</a>
                                <img src="{{ asset('images/logo.png') }}" alt="Logo"
                                    class="h-10 ml-2 rounded-full w-10">
                            </li>
                        </ul>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">神奈川県</a>
                    </li>
                </ul>
            </div>

            <!-- 中部地方 -->
            <div class="p-4">
                <h5 class="text-xl font-semibold mb-3 text-blue-300">中部地方</h5>
                <ul class="space-y-2">
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">新潟県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">富山県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">石川県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">福井県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">山梨県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">長野県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">岐阜県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">静岡県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">愛知県</a>
                    </li>
                </ul>
            </div>

            <!-- 近畿地方 -->
            <div class="p-4">
                <h5 class="text-xl font-semibold mb-3 text-blue-300">近畿地方</h5>
                <ul class="space-y-2">
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">三重県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">滋賀県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">京都府</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">大阪府</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">兵庫県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">奈良県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">和歌山県</a>
                    </li>
                </ul>
            </div>

            <!-- 中国・四国地方 -->
            <div class="p-4">
                <h5 class="text-xl font-semibold mb-3 text-blue-300">中国地方・四国地方</h5>
                <ul class="space-y-2">
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">鳥取県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">島根県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">岡山県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">広島県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">山口県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">徳島県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">香川県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">愛媛県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">高知県</a>
                    </li>
                </ul>
            </div>

            <!-- 九州・沖縄地方 -->
            <div class="p-4">
                <h5 class="text-xl font-semibold mb-3 text-blue-300">九州・沖縄地方</h5>
                <ul class="space-y-2">
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">福岡県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">佐賀県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">長崎県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">熊本県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">大分県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">宮崎県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">鹿児島県</a>
                    </li>
                    <li><a href="#"
                            class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">沖縄県</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- コピーライト表記 -->
        <p class="text-center text-sm mt-8 text-gray-400 w-full">
            &copy; 2025 TaxBar® Tax Minutes®. All rights reserved.
        </p>
    </div>
</footer>
