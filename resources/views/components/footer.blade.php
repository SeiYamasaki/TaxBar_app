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
                    <li>北海道</li>
                    <li>青森県</li>
                    <li>岩手県</li>
                        <ul class="ml-8">
                            <li class="flex items-center">
                                <a href="#"
                                    class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">沖野匠吾</a>
                                <img src="{{ asset('images/logotoumei.png') }}" alt="Logo"
                                    class="h-12 rounded-full w-12">
                            </li>
                            <li class="flex items-center">
                                <a href="#"
                                    class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">大垣由騎</a>
                                <img src="{{ asset('images/logotoumei.png') }}" alt="Logo"
                                    class="h-12 rounded-full w-12">
                            </li>
                        </ul>
                    <li>宮城県</li>
                        <ul class="ml-8">
                            <li class="flex items-center">
                                <a href="#"
                                    class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">佐藤
                                    幸久</a>
                                <img src="{{ asset('images/logotoumei.png') }}" alt="Logo"
                                    class="h-12 rounded-full w-12">
                            </li>
                        </ul>
                    <li>秋田県</li>
                    <li>山形県</li>
                    <li>福島県</li>
                </ul>
            </div>

            <!-- 関東地方 -->
            <div class="p-4">
                <h5 class="text-xl font-semibold mb-3 text-blue-300">関東地方</h5>
                <ul class="space-y-2 text-left">
                    <li>茨城県</li>
                    <li>栃木県</li>
                    <li>群馬県</li>
                    <li>埼玉県</li>
                    <li>千葉県</li>
                    <li>東京都</li>
                        <ul class="ml-8">
                            <li class="flex items-center">
                                <a href="#"
                                    class="text-base font-medium hover:text-blue-200 hover:underline transition-colors">山崎
                                    聖</a>
                                <img src="{{ asset('images/logotoumei.png') }}" alt="Logo"
                                    class="h-12 rounded-full w-12">
                            </li>
                        </ul>
                    </li>
                    <li>神奈川県</li>
                </ul>
            </div>

            <!-- 中部地方 -->
            <div class="p-4">
                <h5 class="text-xl font-semibold mb-3 text-blue-300">中部地方</h5>
                <ul class="space-y-2 text-left">
                    <li>新潟県</li>
                    <li>富山県</li>
                    <li>石川県</li>
                    <li>福井県</li>
                    <li>山梨県</li>
                    <li>長野県</li>
                    <li>岐阜県</li>
                    <li>静岡県</li>
                    <li>愛知県</li>
                </ul>
            </div>

            <!-- 近畿地方 -->
            <div class="p-4">
                <h5 class="text-xl font-semibold mb-3 text-blue-300">近畿地方</h5>
                <ul class="space-y-2 text-left">
                    <li>三重県</li>
                    <li>滋賀県</li>
                    <li>京都府</li>
                    <li>大阪府</li>
                    <li>兵庫県</li>
                    <li>奈良県</li>
                    <li>和歌山県</li>
                </ul>
            </div>

            <!-- 中国・四国地方 -->
            <div class="p-4">
                <h5 class="text-xl font-semibold mb-3 text-blue-300">中国地方・四国地方</h5>
                <ul class="space-y-2 text-left">
                    <li>島根県</li>
                    <li>岡山県</li>
                    <li>広島県</li>
                    <li>山口県</li>
                    <li>徳島県</li>
                    <li>香川県</li>
                    <li>愛媛県</li>
                    <li>高知県</li>
                </ul>
            </div>

            <!-- 九州・沖縄地方 -->
            <div class="p-4">
                <h5 class="text-xl font-semibold mb-3 text-blue-300">九州・沖縄地方</h5>
                <ul class="space-y-2 text-left">
                    <li>福岡県</li>
                    <li>佐賀県</li>
                    <li>長崎県</li>
                    <li>熊本県</li>
                    <li>大分県</li>
                    <li>宮崎県</li>
                    <li>鹿児島県</li>
                    <li>沖縄県</li>
                </ul>
            </div>
        </div>

        <!-- コピーライト表記 -->
        <p class="text-center text-sm mt-8 text-gray-400 w-full">
            &copy; 2025 TaxBar® Tax Minutes®. All rights reserved.
        </p>
    </div>
</div>
