@extends('layouts.app')

@section('styles')
    <style>
        /* ✅ 料金表の背景を青のグラデーションに変更 */
        body {
            background: linear-gradient(to right, #3b82f6, #1e40af);
            color: white;
        }
    </style>
@endsection

@section('content')
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
@endsection
