@extends('layouts.app')

@section('title', '料金表')

@section('content')
    <div class="container mt-12 mx-auto py-12">
        <h1 class="text-4xl font-bold text-center mb-8 text-white">料金表／月払い</h1>


        <!-- ユーザー名の表示 -->
        @if (Auth::check())
            <p class="text-white text-lg font-semibold">ようこそ、{{ Auth::user()->name }} さん！</p>
        @else
            <p class="text-white text-lg font-semibold">ゲストとして閲覧中</p>
        @endif

        <!-- タブ切り替えボタン -->
        <div class="flex justify-center mb-6">
            <button id="corporate-tab" class="tab-btn active" onclick="showTab('corporate')">専門家</button>
            <button id="individual-tab" class="tab-btn" onclick="showTab('individual')">企業･個人</button>
        </div>

        <!-- 企業向けプラン -->
        <div id="corporate" class="mx-auto py-12">
            <div class="overflow-x-auto">
                <div class="flex justify-center">
                    <!-- 全体をラップするコンテナ -->
                    <div class="grid grid-cols-4 gap-0 max-w-5xl shadow-2xl rounded-lg overflow-hidden">

                        <!-- 左側の項目列 -->
                        <div class="bg-gradient-to-b from-gray-100 to-gray-200">
                            <!-- 上部ヘッダー（プラン比較） -->
                            <div class="h-28 flex items-center justify-center p-4 bg-gray-800 text-white">
                                <h3 class="text-lg font-bold">プラン比較</h3>
                            </div>

                            @php
                                $items = [
                                    '月額払い' => 'monthlyFee',
                                    '契約期間' => 'contractDuration',
                                    '開店時間/1回' => 'openTime',
                                    '開店回数/月' => 'openCountPerMonth',
                                    '投銭機能' => 'tipping',
                                    'スペシャルゲスト適用' => 'specialGuest',
                                    'TaxMinutes投稿' => 'taxMinutesPost',
                                    '動画投稿/月' => 'videoPostingPerMonth',
                                    'マーケティング支援' => 'marketingSupport',
                                    'AI_TaxBar支援' => 'aiTaxBarSupport',
                                    '税務Q&Aサポート' => 'taxQASupport',
                                    '過去相談履歴の参照' => 'pastHistoryReference',
                                    '税務アドバイス補助' => 'taxAdviceSupport',
                                    '税制改正の自動通知' => 'taxRevisionNotification',
                                ];

                                $colors = [
                                    'bg-gradient-to-b from-yellow-50 to-yellow-100', // ゴールド
                                    'bg-gradient-to-b from-blue-50 to-blue-100', // プラチナ
                                    'bg-gradient-to-b from-purple-50 to-purple-100', // VIP
                                ];

                                $headerColors = [
                                    'bg-gradient-to-r from-yellow-500 to-yellow-600', // ゴールド
                                    'bg-gradient-to-r from-blue-500 to-blue-600', // プラチナ
                                    'bg-gradient-to-r from-purple-600 to-purple-700', // VIP
                                ];

                                $buttonColors = [
                                    'bg-yellow-600 hover:bg-yellow-700', // ゴールド
                                    'bg-blue-600 hover:bg-blue-700', // プラチナ
                                    'bg-purple-600 hover:bg-purple-700', // VIP
                                ];
                            @endphp

                            <!-- 項目名リスト -->
                            @foreach ($items as $label => $key)
                                <div class="p-4 flex items-center h-16 {{ $loop->even ? 'bg-gray-50' : '' }}">
                                    <span class="text-sm font-medium">{{ $label }}</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- 各プラン列 -->
                        @foreach ($corporatePlans as $index => $plan)
                            <div class="{{ $colors[$index] }}">
                                <!-- プラン名ヘッダー -->
                                <div
                                    class="h-28 flex flex-col items-center justify-center p-4 text-white {{ $headerColors[$index] }}">
                                    <h3 class="text-xl font-bold mb-1">{{ $plan['name'] }}</h3>
                                    <div class="flex items-center">
                                        @if ($index === 0)
                                            <span
                                                class="text-xs bg-yellow-300 text-yellow-800 px-2 py-1 rounded-full font-bold">おすすめ</span>
                                        @elseif($index === 1)
                                            <span
                                                class="text-xs bg-blue-300 text-blue-800 px-2 py-1 rounded-full font-bold">人気</span>
                                        @elseif($index === 2)
                                            <span
                                                class="text-xs bg-purple-300 text-purple-800 px-2 py-1 rounded-full font-bold">最上級</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- 各項目の値 -->
                                @foreach ($items as $label => $key)
                                    <div
                                        class="p-4 flex items-center justify-center h-16 {{ $loop->even ? 'bg-opacity-50 bg-white' : '' }} transition-all hover:bg-opacity-80">
                                        @if ($key === 'monthlyFee')
                                            <span class="text-lg font-bold">¥{{ number_format($plan['monthlyFee']) }}</span>
                                        @elseif ($plan[$key] === '有')
                                            <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        @elseif ($plan[$key] === '無')
                                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        @else
                                            <span class="text-sm font-medium">{{ $plan[$key] }}</span>
                                        @endif
                                    </div>
                                @endforeach

                                <!-- 申し込みボタン -->
                                <div class="p-6 flex justify-center">
                                    <button
                                        class="{{ $buttonColors[$index] }} text-white py-3 px-8 rounded-full text-sm font-bold transition-all transform hover:scale-105 shadow-lg">
                                        今すぐ申し込む
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- 個人向けプラン -->
        <div id="individual" class="tab-content hidden">
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($individualPlans as $plan)
                    <div class="bg-white rounded-2xl shadow-lg p-6 text-center border border-gray-200">
                        <h2 class="text-2xl font-semibold mb-4">{{ $plan['name'] }}</h2>
                        <p class="text-4xl font-bold text-indigo-600 mb-4">¥{{ number_format($plan['price']) }}</p>
                        <ul class="mb-6 text-gray-600">
                            @foreach ($plan['features'] as $feature)
                                <li class="flex items-center justify-center gap-2">✅ {{ $feature }}</li>
                            @endforeach
                        </ul>
                        <a href="#"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">申込み</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function showTab(tab) {
            document.getElementById('corporate').classList.add('hidden');
            document.getElementById('individual').classList.add('hidden');
            document.getElementById(tab).classList.remove('hidden');

            document.getElementById('corporate-tab').classList.remove('active');
            document.getElementById('individual-tab').classList.remove('active');
            document.getElementById(tab + '-tab').classList.add('active');
        }
    </script>
@endpush

@push('styles')
    <style>
        .tab-btn {
            background: #ddd;
            padding: 10px 20px;
            margin: 0 5px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .tab-btn.active {
            background: red;
            color: white;
        }

        .hidden {
            display: none;
        }
    </style>
@endpush
