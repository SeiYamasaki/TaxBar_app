<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar®️ | インボイス一覧</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="mt-24 flex flex-col min-h-full bg-gray-100">
    @include('components.header')

    <!-- ヘッダーの高さ分のスペーサー -->
    <div class="h-16"></div>

    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg p-8 max-w-5xl mx-auto">
            <!-- ロゴの表示 -->
            <div class="flex justify-center mb-6">
                <img src="/images/logotoumei.png" alt="ロゴ" class="h-36">
            </div>

            <h1 class="text-3xl font-bold text-gray-800 mb-2 text-center">インボイス一覧</h1>
            <p class="text-xl text-gray-600 mb-6 text-center">お支払い履歴</p>

            <!-- フラッシュメッセージ表示 -->
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- インボイス一覧 -->
            <div class="mt-6">
                @if (count($invoices) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700">
                                    <th class="py-3 px-4 text-left">請求書番号</th>
                                    <th class="py-3 px-4 text-left">金額</th>
                                    <th class="py-3 px-4 text-left">ステータス</th>
                                    <th class="py-3 px-4 text-left">支払日</th>
                                    <th class="py-3 px-4 text-left">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3 px-4">{{ $invoice->invoice_number }}</td>
                                        <td class="py-3 px-4">{{ number_format($invoice->amount) }}円</td>
                                        <td class="py-3 px-4">
                                            @if ($invoice->status === 'paid')
                                                <span
                                                    class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">支払済み</span>
                                            @else
                                                <span
                                                    class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">{{ $invoice->status }}</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4">
                                            {{ $invoice->paid_at ? $invoice->paid_at->format('Y年m月d日') : '-' }}</td>
                                        <td class="py-3 px-4">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('invoices.show', $invoice->id) }}"
                                                    class="text-blue-600 hover:text-blue-800">
                                                    詳細
                                                </a>
                                                @if ($invoice->pdf_path)
                                                    <a href="{{ $invoice->pdf_path }}" target="_blank"
                                                        class="text-green-600 hover:text-green-800">
                                                        PDF
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- ページネーション -->
                    <div class="mt-6">
                        {{ $invoices->links() }}
                    </div>
                @else
                    <div class="bg-gray-50 p-6 rounded-lg text-center text-gray-500">
                        インボイスの記録がありません
                    </div>
                @endif
            </div>

            <!-- 戻るボタン -->
            <div class="mt-10 text-center">
                <a href="{{ route('dashboard') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                    ダッシュボードに戻る
                </a>
            </div>
        </div>
    </main>

    <!-- フッター -->
    @include('components.footer')
</body>

</html>
