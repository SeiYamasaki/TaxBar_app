@extends('layouts.app')

@section('title', '料金表')

@section('content')
    <div class="container mt-12 mx-auto py-12">

        <h1 class="text-3xl font-bold text-center mb-8 text-white">料金表／月払い</h1>
        <h1 class="text-3xl font-bold text-center mb-8 text-white">契約期間／1年</h1>
        <h1 class="text-1xl font-bold text-center mb-8 text-white">一般法人個人は登録無料！</h1>

        <!-- フラッシュメッセージの表示 -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 mx-auto max-w-4xl">
                {{ session('success') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6 mx-auto max-w-4xl">
                {{ session('warning') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 mx-auto max-w-4xl">
                {{ session('error') }}
            </div>
        @endif

        <!-- ユーザー名の表示 -->
        @if (Auth::check())
            <p class="text-white text-lg font-semibold">ようこそ、{{ Auth::user()->name }} さん！</p>
        @else
            <p class="text-white text-lg font-semibold">ゲストとして閲覧中</p>
        @endif

        {{-- <!-- タブ切り替えボタン -->
        <div class="flex justify-center mb-6">
            <button id="corporate-tab" class="tab-btn active" onclick="showTab('corporate')">専門家</button>
            <button id="individual-tab" class="tab-btn" onclick="showTab('individual')">企業･個人</button>
        </div> --}}

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
                                    <form id="payment-form-{{ $index }}" action="{{ route('stripe.payment') }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="plan_id" value="{{ $index + 1 }}">
                                        <input type="hidden" name="amount" value="{{ $plan['monthlyFee'] }}">
                                        <input type="hidden" name="plan_name" value="{{ $plan['name'] }}">
                                        <button type="button"
                                            class="payment-button {{ $buttonColors[$index] }} text-white py-3 px-8 rounded-full text-sm font-bold transition-all transform hover:scale-105 shadow-lg"
                                            data-plan-name="{{ $plan['name'] }}"
                                            data-plan-price="¥{{ number_format($plan['monthlyFee']) }}"
                                            data-form-id="payment-form-{{ $index }}">
                                            今すぐ申し込む
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- プラン選択モーダル (tax_advisorユーザー用) -->
    @if (Auth::check() && Auth::user()->role === 'tax_advisor' && (request()->has('show_plan_modal') || session('warning')))
        <div id="plan-modal" class="fixed inset-0 z-50 flex items-center justify-center">
            <!-- ぼかしオーバーレイ (固定位置) -->
            <div class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-md"></div>

            <!-- モーダルコンテンツ -->
            <div class="relative z-10 max-h-screen w-full max-w-5xl px-4 py-4">
                <div class="bg-white rounded-lg shadow-xl w-full overflow-hidden flex flex-col max-h-[90vh]">
                    <div class="bg-gray-800 text-white p-4 flex justify-between items-center">
                        <h2 class="text-xl font-bold">プランを選択してください</h2>
                        <a href="{{ url('/') }}" class="text-white hover:text-gray-300 cursor-pointer"
                            id="close-modal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    </div>

                    <div class="p-6 overflow-y-auto">
                        @if (session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('warning'))
                            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                                {{ session('warning') }}
                            </div>
                        @endif

                        <p class="text-gray-700 mb-6">税理士として活動するには、プランにご登録いただく必要があります。以下からプランをお選びください。</p>

                        <!-- プラン選択部分 -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            @foreach ($corporatePlans as $index => $plan)
                                <div
                                    class="border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow flex flex-col h-full">
                                    <div class="p-4 {{ $headerColors[$index] }} text-white">
                                        <h3 class="text-xl font-bold mb-1 text-center">{{ $plan['name'] }}</h3>
                                        <p class="text-center text-xl font-bold">
                                            ¥{{ number_format($plan['monthlyFee']) }}/月</p>
                                    </div>
                                    <div class="p-4 overflow-y-auto flex-grow">
                                        <ul class="space-y-2">
                                            <li class="flex items-center">
                                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                開店時間: {{ $plan['openTime'] }}
                                            </li>
                                            <li class="flex items-center">
                                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                開店回数: {{ $plan['openCountPerMonth'] }}
                                            </li>
                                            <li class="flex items-center">
                                                <svg class="h-5 w-5 {{ $plan['tipping'] === '有' ? 'text-green-500' : 'text-red-500' }} mr-2"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="{{ $plan['tipping'] === '有' ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}">
                                                    </path>
                                                </svg>
                                                投銭機能: {{ $plan['tipping'] }}
                                            </li>
                                            <li class="flex items-center">
                                                <svg class="h-5 w-5 {{ $plan['specialGuest'] === '有' ? 'text-green-500' : 'text-red-500' }} mr-2"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="{{ $plan['specialGuest'] === '有' ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}">
                                                    </path>
                                                </svg>
                                                スペシャルゲスト適用: {{ $plan['specialGuest'] }}
                                            </li>
                                            <li class="flex items-center">
                                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                TaxMinutes投稿: {{ Str::limit($plan['taxMinutesPost'], 30) }}
                                            </li>
                                            <li class="flex items-center">
                                                <svg class="h-5 w-5 {{ $plan['videoPostingPerMonth'] !== '無' ? 'text-green-500' : 'text-red-500' }} mr-2"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="{{ $plan['videoPostingPerMonth'] !== '無' ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}">
                                                    </path>
                                                </svg>
                                                動画投稿/月: {{ Str::limit($plan['videoPostingPerMonth'], 30) }}
                                            </li>
                                            <li class="flex items-center">
                                                <svg class="h-5 w-5 {{ $plan['marketingSupport'] !== '無' ? 'text-green-500' : 'text-red-500' }} mr-2"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="{{ $plan['marketingSupport'] !== '無' ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}">
                                                    </path>
                                                </svg>
                                                マーケティング支援: {{ Str::limit($plan['marketingSupport'], 30) }}
                                            </li>
                                            <li class="flex items-center">
                                                <svg class="h-5 w-5 {{ $plan['aiTaxBarSupport'] === '有' ? 'text-green-500' : 'text-red-500' }} mr-2"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="{{ $plan['aiTaxBarSupport'] === '有' ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}">
                                                    </path>
                                                </svg>
                                                TaxBar®専門AI実装: {{ $plan['aiTaxBarSupport'] }}
                                            </li>
                                            <li class="flex items-center">
                                                <svg class="h-5 w-5 {{ $plan['taxQASupport'] === '有' ? 'text-green-500' : 'text-red-500' }} mr-2"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="{{ $plan['taxQASupport'] === '有' ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}">
                                                    </path>
                                                </svg>
                                                税務Q&A補助: {{ $plan['taxQASupport'] }}
                                            </li>
                                            <li class="flex items-center">
                                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                相談履歴の参照: {{ $plan['pastHistoryReference'] }}
                                            </li>
                                            <li class="flex items-center">
                                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                税務助言補助: {{ $plan['taxAdviceSupport'] }}
                                            </li>
                                            <li class="flex items-center">
                                                <svg class="h-5 w-5 {{ $plan['taxRevisionNotification'] !== '無' ? 'text-green-500' : 'text-red-500' }} mr-2"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="{{ $plan['taxRevisionNotification'] !== '無' ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}">
                                                    </path>
                                                </svg>
                                                税制改正通知: {{ Str::limit($plan['taxRevisionNotification'], 30) }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="p-4 bg-gray-50 flex justify-center mt-auto">
                                        <form id="modal-payment-form-{{ $index }}"
                                            action="{{ route('stripe.payment') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="plan_id" value="{{ $index + 1 }}">
                                            <input type="hidden" name="amount" value="{{ $plan['monthlyFee'] }}">
                                            <input type="hidden" name="plan_name" value="{{ $plan['name'] }}">
                                            <button type="button"
                                                class="payment-button {{ $buttonColors[$index] }} text-white py-2 px-6 rounded-full text-sm font-bold transition-all transform hover:scale-105"
                                                data-plan-name="{{ $plan['name'] }}"
                                                data-plan-price="¥{{ number_format($plan['monthlyFee']) }}"
                                                data-form-id="modal-payment-form-{{ $index }}">
                                                このプランを選択
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- 決済確認モーダルを読み込み -->
    @include('components.payment-confirmation-modal')

    <!-- モーダル表示時の背景スクロール制御 -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalElement = document.getElementById('plan-modal');
            const modalContent = document.querySelector('.p-6.overflow-y-auto');
            const paymentConfirmationModal = document.getElementById('payment-confirmation-modal');
            const closePaymentModalBtn = document.getElementById('close-payment-modal');
            const cancelPaymentBtn = document.getElementById('cancel-payment-btn');
            const confirmPaymentBtn = document.getElementById('confirm-payment-btn');
            const modalPlanName = document.getElementById('modal-plan-name');
            const modalPlanPrice = document.getElementById('modal-plan-price');

            let currentFormId = null;

            // 決済ボタンのクリックイベント
            document.querySelectorAll('.payment-button').forEach(button => {
                button.addEventListener('click', function() {
                    const planName = this.getAttribute('data-plan-name');
                    const planPrice = this.getAttribute('data-plan-price');
                    const formId = this.getAttribute('data-form-id');

                    // モーダルに情報をセット
                    modalPlanName.textContent = planName;
                    modalPlanPrice.textContent = planPrice;
                    currentFormId = formId;

                    // モーダルを表示
                    paymentConfirmationModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                });
            });

            // 決済モーダルを閉じる
            const closePaymentModal = function() {
                paymentConfirmationModal.classList.add('hidden');
                document.body.style.overflow = '';
                currentFormId = null;
            };

            // 閉じるボタンのクリックイベント
            if (closePaymentModalBtn) {
                closePaymentModalBtn.addEventListener('click', closePaymentModal);
            }

            // キャンセルボタンのクリックイベント
            if (cancelPaymentBtn) {
                cancelPaymentBtn.addEventListener('click', closePaymentModal);
            }

            // 決済するボタンのクリックイベント
            if (confirmPaymentBtn) {
                confirmPaymentBtn.addEventListener('click', function() {
                    if (currentFormId) {
                        document.getElementById(currentFormId).submit();
                    }
                });
            }

            // ホイールイベントを選択的に阻止する関数（モーダル内のスクロールは許可）
            const preventScrollOutsideModal = function(e) {
                // イベントの発生源がモーダルコンテンツ内かチェック
                if (modalContent && modalContent.contains(e.target)) {
                    // モーダル内のスクロールは許可
                    return true;
                }
                // モーダル外のスクロールは阻止
                e.preventDefault();
                e.stopPropagation();
                return false;
            };

            if (modalElement) {
                // スクロール無効化 - より強力な方法
                document.body.style.overflow = 'hidden';
                document.body.style.height = '100%';
                document.documentElement.style.overflow = 'hidden';
                document.documentElement.style.height = '100%';

                // モーダル外のホイールイベントのみを無効化
                document.addEventListener('wheel', preventScrollOutsideModal, {
                    passive: false
                });
                document.addEventListener('touchmove', preventScrollOutsideModal, {
                    passive: false
                });
            }

            // 閉じるボタンをクリックしたときの処理
            const closeBtn = document.getElementById('close-modal');
            if (closeBtn) {
                closeBtn.addEventListener('click', function(e) {
                    // デフォルトの動作を停止（リンクのナビゲーションを防ぐ）
                    e.preventDefault();

                    // スクロール再有効化
                    document.body.style.overflow = '';
                    document.body.style.height = '';
                    document.documentElement.style.overflow = '';
                    document.documentElement.style.height = '';

                    // イベントリスナーを削除
                    document.removeEventListener('wheel', preventScrollOutsideModal);
                    document.removeEventListener('touchmove', preventScrollOutsideModal);

                    // トップページにリダイレクト
                    window.location.href = "{{ url('/') }}";
                });
            }
        });
    </script>
@endsection
