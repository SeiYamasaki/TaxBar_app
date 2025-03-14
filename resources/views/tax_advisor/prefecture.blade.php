<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $prefecture }}の税理士一覧 | TaxBar®</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="bg-white overflow-auto min-h-screen">
    <!-- ヘッダーを固定 -->
    <header class="fixed top-0 left-0 w-full h-16 bg-white shadow-lg z-50 flex items-center">
        @include('components.header')
    </header>

    <!-- ヘッダーの高さ分だけ余白を確保 (mt-32) -->
    <div class="max-w-screen-lg mx-auto mt-32 px-6 sm:px-10 py-6">
        <h2 class="text-center text-2xl font-bold mb-6">{{ $prefecture }}の税理士一覧</h2>

        <!-- 税理士一覧 -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($advisors as $advisor)
                <div
                    class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="p-4">
                        <div class="flex items-center mb-4">
                            <img src="{{ $advisor->tax_accountant_photo ? asset('storage/' . $advisor->tax_accountant_photo) : asset('images/logotoumei.png') }}"
                                alt="{{ $advisor->user->name }}" class="h-16 w-16 rounded-full object-cover mr-4">
                            <div>
                                <h3 class="text-lg font-semibold">{{ $advisor->user->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $advisor->office_name }}</p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <p class="text-sm text-gray-700">
                                <span class="font-medium">住所:</span> 〒{{ $advisor->postal_code }}
                                {{ $advisor->prefecture }}{{ $advisor->address }}
                            </p>
                            <p class="text-sm text-gray-700">
                                <span class="font-medium">電話:</span> {{ $advisor->office_phone }}
                            </p>
                        </div>

                        @if ($advisor->specialty)
                            <div class="mb-3">
                                <p class="text-sm font-medium">専門分野:</p>
                                <p class="text-sm text-gray-700">{{ $advisor->specialty }}</p>
                            </div>
                        @endif

                        <div class="mt-4 text-center">
                            <a href="{{ route('tax-advisors.show', $advisor->id) }}"
                                class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                                詳細を見る
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-lg text-gray-600">{{ $prefecture }}の登録税理士はまだいません。</p>
                </div>
            @endforelse
        </div>

        <!-- ページネーション -->
        <div class="mt-8">
            {{ $advisors->links() }}
        </div>
    </div>

    <!-- フッター -->
    @include('components.footer')
</body>

</html>
