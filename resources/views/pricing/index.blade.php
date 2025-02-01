@extends('layouts.app')

@section('title', '料金表')

@section('content')
    <div class="container mx-auto py-12">
        <h1 class="text-4xl font-bold text-center mb-8">料金表／月払い</h1>
        

        <!-- ユーザー名の表示 -->
        @if (Auth::check())
            <p class="text-lg font-semibold">ようこそ、{{ Auth::user()->name }} さん！</p>
        @else
            <p class="text-lg font-semibold">ゲストとして閲覧中</p>
        @endif

        <!-- タブ切り替えボタン -->
        <div class="flex justify-center mb-6">
            <button id="corporate-tab" class="tab-btn active" onclick="showTab('corporate')">専門家</button>
            <button id="individual-tab" class="tab-btn" onclick="showTab('individual')">企業･個人</button>
        </div>

        <!-- 企業向けプラン -->
        <div id="corporate" class="tab-content">
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($corporatePlans as $plan)
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
