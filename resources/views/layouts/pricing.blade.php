@extends('layouts.app')

@section('styles')
    <style>
        /* ✅ このページだけ適用 */
        body {
            padding-top: 100px !important; /* ✅ ヘッダーの高さを考慮し少し大きめに */
            background: linear-gradient(to right, #4f92ff, #0052cc, #002766);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ✅ `main` のスタイルを修正 */
        main {
            flex-grow: 1;
            display: block !important; /* ✅ `display: flex;` の影響を無効化 */
            width: 100%;
            margin-top: 100px !important; /* ✅ ヘッダーの高さ分だけ確実に下げる */
        }

        /* ✅ ヘッダーの固定位置を明示 */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 80px; /* ✅ ヘッダーの高さを統一 */
            background-color: white;
            z-index: 50;
            display: flex;
            align-items: center;
            padding: 0 20px; /* ✅ ヘッダーの左右の余白 */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* ✅ 影を追加 */
        }
    </style>
@endsection

@section('content')
    <main>
        <div class="max-w-3xl mx-auto bg-white p-8 border border-gray-300 rounded-lg shadow-md text-black">
            <h1 class="text-4xl font-bold text-center mb-8 text-blue-600">💰 料金表</h1>

            <!-- 企業向けプラン -->
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($corporatePlans as $plan)
                    <div class="bg-white rounded-2xl shadow-lg p-6 text-center border border-gray-200">
                        <h2 class="text-2xl font-semibold text-blue-600 mb-4">{{ $plan['name'] }}</h2>
                        <p class="text-4xl font-bold text-blue-600 mb-4">¥{{ number_format($plan['price']) }}</p>
                        <ul class="mb-6 text-gray-600">
                            @foreach ($plan['features'] as $feature)
                                <li class="flex items-center justify-center gap-2">✅ {{ $feature }}</li>
                            @endforeach
                        </ul>
                        <a href="#"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">申込み</a>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
