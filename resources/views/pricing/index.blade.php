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
                '※TaxBar®専門AI実装' => 'aiTaxBarSupport',
                '※税務Q&A補助(税理士補助)' => 'taxQASupport',
                '※相談履歴の参照(税理士補助)' => 'pastHistoryReference',
                '※税務助言補助(税理士補助)' => 'taxAdviceSupport',
                '※税制改正通知(税理士補助)' => 'taxRevisionNotification',
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

        <!-- 企業向けプラン -->
        <div id="corporate" class="mx-auto py-12">
            <div class="overflow-x-auto">
                <div class="flex justify-center">
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-0 max-w-5xl shadow-2xl rounded-lg overflow-hidden">

                        <!-- PC用: 左側の項目列 -->
                        <div class="hidden sm:block bg-gradient-to-b from-gray-100 to-gray-200">
                            <div class="h-28 flex items-center justify-center p-4 bg-gray-800 text-white">
                                <h3 class="text-lg font-bold">プラン比較</h3>
                            </div>
                            @foreach ($items as $label => $key)
                                <div class="p-4 flex items-center h-16 {{ $loop->even ? 'bg-gray-50' : '' }}">
                                    <span class="text-sm font-medium">{{ $label }}</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- 各プラン列 -->
                        @foreach ($corporatePlans as $index => $plan)
                            <div class="{{ $colors[$index] }}">
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

                                <!-- スマホ用: 各プランに項目を表示 -->
                                <div class="sm:hidden">
                                    @foreach ($items as $label => $key)
                                        <div class="p-4 flex flex-col items-center h-16 bg-white border-b border-gray-200">
                                            <span class="text-xs font-bold text-gray-600">{{ $label }}</span>
                                            <span class="text-sm font-medium">
                                                @if ($key === 'monthlyFee')
                                                    ¥{{ number_format($plan['monthlyFee']) }}
                                                @elseif ($plan[$key] === '有')
                                                    ✅
                                                @elseif ($plan[$key] === '無')
                                                    ❌
                                                @else
                                                    {{ $plan[$key] }}
                                                @endif
                                            </span>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- PC用: 各項目の値 -->
                                <div class="hidden sm:block">
                                    @foreach ($items as $label => $key)
                                        <div
                                            class="p-4 flex items-center justify-center h-16 {{ $loop->even ? 'bg-opacity-50 bg-white' : '' }}">
                                            @if ($key === 'monthlyFee')
                                                <span
                                                    class="text-lg font-bold">¥{{ number_format($plan['monthlyFee']) }}</span>
                                            @elseif ($plan[$key] === '有')
                                                ✅
                                            @elseif ($plan[$key] === '無')
                                                ❌
                                            @else
                                                <span class="text-sm font-medium">{{ $plan[$key] }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

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
    </div>
@endsection
