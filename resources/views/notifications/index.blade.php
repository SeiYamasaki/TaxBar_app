<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar®️ | 通知一覧</title>
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

            <h1 class="text-3xl font-bold text-gray-800 mb-2 text-center">通知一覧</h1>
            <p class="text-xl text-gray-600 mb-6 text-center">システム通知とお知らせ</p>

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

            <!-- 全て既読にするボタン -->
            @if (Auth::user()->unreadNotifications->count() > 0)
                <div class="mb-6 text-right">
                    <form action="{{ route('notifications.mark-all-as-read') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            すべて既読にする
                        </button>
                    </form>
                </div>
            @endif

            <!-- 通知一覧 -->
            <div class="mt-6">
                @if (count($notifications) > 0)
                    <div class="space-y-4">
                        @foreach ($notifications as $notification)
                            <div
                                class="p-4 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }} border rounded-lg shadow-sm">
                                <div class="flex justify-between items-start">
                                    <div class="flex-grow">
                                        @if ($notification->type === 'App\Notifications\InvoiceNotification')
                                            <h3 class="font-semibold text-lg">お支払い完了のお知らせ</h3>
                                            <p class="text-gray-600">請求書番号: {{ $notification->data['invoice_number'] }}
                                            </p>
                                            <p class="text-gray-600">金額:
                                                {{ number_format($notification->data['amount']) }}円</p>
                                            <p class="text-gray-600">ステータス: {{ $notification->data['status'] }}</p>
                                            <p class="text-gray-600">支払日:
                                                {{ \Carbon\Carbon::parse($notification->data['paid_at'])->format('Y年m月d日') }}
                                            </p>
                                            <div class="mt-2">
                                                <a href="{{ route('invoices.show', $notification->data['invoice_id']) }}"
                                                    class="text-blue-600 hover:text-blue-800">
                                                    詳細を見る
                                                </a>
                                            </div>
                                        @else
                                            <h3 class="font-semibold text-lg">
                                                {{ $notification->data['message'] ?? '通知' }}</h3>
                                        @endif
                                        <p class="text-xs text-gray-500 mt-2">
                                            {{ $notification->created_at->format('Y年m月d日 H:i') }}</p>
                                    </div>
                                    @if (!$notification->read_at)
                                        <form action="{{ route('notifications.mark-as-read', $notification->id) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="text-sm text-blue-600 hover:text-blue-800 bg-white px-3 py-1 rounded-full shadow-sm">
                                                既読にする
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-500">既読:
                                            {{ $notification->read_at->format('Y/m/d H:i') }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- ページネーション -->
                    <div class="mt-6">
                        {{ $notifications->links() }}
                    </div>
                @else
                    <div class="bg-gray-50 p-6 rounded-lg text-center text-gray-500">
                        通知はありません
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
