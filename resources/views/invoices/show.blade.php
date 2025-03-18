<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar®️ | インボイス詳細</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="mt-24 flex flex-col min-h-full bg-gray-100">
    @include('components.header')

    <!-- ヘッダーの高さ分のスペーサー -->
    <div class="h-16"></div>

    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg p-8 max-w-3xl mx-auto">
            <!-- ロゴの表示 -->
            <div class="flex justify-center mb-6">
                <img src="/images/logotoumei.png" alt="ロゴ" class="h-24">
            </div>

            <h1 class="text-3xl font-bold text-gray-800 mb-2 text-center">インボイス詳細</h1>

            <!-- インボイス情報 -->
            <div class="mt-8 border-t pt-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">請求書</h2>
                        <p class="text-gray-600">請求書番号: {{ $invoice->invoice_number }}</p>
                    </div>
                    @if ($invoice->pdf_path)
                        <a href="{{ $invoice->pdf_path }}" target="_blank"
                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            PDFをダウンロード
                        </a>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">請求元</h3>
                        <p class="text-gray-600">TaxBar株式会社</p>
                        <p class="text-gray-600">登録番号: T7011001108477</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">請求先</h3>
                        <p class="text-gray-600">{{ $invoice->user->name }} 様</p>
                        <p class="text-gray-600">{{ $invoice->user->email }}</p>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">請求詳細</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700">
                                    <th class="py-3 px-4 text-left border">項目</th>
                                    <th class="py-3 px-4 text-right border">金額</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($invoice->items && is_array($invoice->items))
                                    @foreach ($invoice->items as $item)
                                        <tr class="border">
                                            <td class="py-3 px-4 border">{{ $item['description'] ?? '項目' }}</td>
                                            <td class="py-3 px-4 text-right border">
                                                {{ number_format($item['amount'] ?? 0) }}円</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="border">
                                        <td class="py-3 px-4 border">{{ $invoice->description ?? 'TaxBarサービス利用料' }}</td>
                                        <td class="py-3 px-4 text-right border">{{ number_format($invoice->amount) }}円
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr class="bg-gray-50">
                                    <td class="py-3 px-4 font-bold border">合計</td>
                                    <td class="py-3 px-4 text-right font-bold border">
                                        {{ number_format($invoice->amount) }}円</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">支払い情報</h3>
                        <p class="text-gray-600">支払い方法:
                            {{ $invoice->payment_method === 'card' ? 'クレジットカード' : $invoice->payment_method }}</p>
                        <p class="text-gray-600">支払い日:
                            {{ $invoice->paid_at ? $invoice->paid_at->format('Y年m月d日') : '-' }}</p>
                        <p class="text-gray-600">ステータス:
                            @if ($invoice->status === 'paid')
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">支払済み</span>
                            @else
                                <span
                                    class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">{{ $invoice->status }}</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">備考</h3>
                        <p class="text-gray-600">{{ $invoice->description ?? '特になし' }}</p>
                    </div>
                </div>
            </div>

            <!-- 戻るボタン -->
            <div class="mt-10 text-center">
                <a href="{{ route('invoices.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                    インボイス一覧に戻る
                </a>
            </div>
        </div>
    </main>

    <!-- フッター -->
    @include('components.footer')
</body>

</html>
