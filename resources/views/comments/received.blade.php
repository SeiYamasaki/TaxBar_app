<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>受信コメント一覧 - TaxBar®️</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 font-sans">
    <!-- ヘッダー -->
    @include('components.header')

    <!-- メインコンテンツ -->
    <main class="container mt-24 mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-10">受信コメント一覧</h1>

        <!-- フィルタリングオプション -->
        <div class="mb-8 bg-white p-6 rounded-lg shadow-md">
            <form action="{{ route('comments.received') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">ステータス</label>
                    <select name="status"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">すべて</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>承認済み</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>承認待ち</option>
                    </select>
                </div>
                <div>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        フィルター
                    </button>
                </div>
            </form>
        </div>

        <!-- コメント一覧 -->
        <div class="space-y-6">
            @if (count($comments) > 0)
                @foreach ($comments as $comment)
                    <div
                        class="bg-white p-6 rounded-lg shadow-md border-l-4 {{ $comment->is_approved ? 'border-green-500' : 'border-yellow-500' }}">
                        <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                            <div class="flex-1">
                                <!-- コメント情報 -->
                                <div class="flex items-center mb-2">
                                    <span class="font-bold text-gray-800 mr-2">{{ $comment->display_name }}</span>
                                    <span
                                        class="text-gray-500 text-sm">{{ $comment->created_at->format('Y年m月d日 H:i') }}</span>
                                    <span
                                        class="ml-2 {{ $comment->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} text-xs px-2 py-1 rounded-full">
                                        {{ $comment->is_approved ? '承認済み' : '承認待ち' }}
                                    </span>
                                </div>

                                <!-- コメント対象 -->
                                <div class="text-sm text-gray-600 mb-3">
                                    @if ($comment->commentable_type === 'App\Models\TaxMinutesVideo')
                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1">動画</span>
                                        <a href="{{ route('taxminivideos.show', $comment->commentable_id) }}"
                                            class="text-indigo-600 hover:underline">
                                            {{ $comment->commentable->title ?? '削除された動画' }}
                                        </a>
                                    @elseif($comment->commentable_type === 'App\Models\Theme')
                                        <span
                                            class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded mr-1">テーマ</span>
                                        <a href="#" class="text-indigo-600 hover:underline">
                                            {{ $comment->commentable->title ?? '削除されたテーマ' }}
                                        </a>
                                    @endif
                                </div>

                                <!-- コメント本文 -->
                                <div class="bg-gray-50 p-4 rounded-lg text-gray-700">
                                    {{ $comment->content }}
                                </div>
                            </div>

                            <!-- 操作ボタン -->
                            <div class="flex flex-col gap-2 min-w-[120px]">
                                @if (!$comment->is_approved)
                                    <form action="{{ route('comments.approve', $comment->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded">
                                            承認する
                                        </button>
                                    </form>
                                    <form action="{{ route('comments.reject', $comment->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded">
                                            拒否する
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                        onsubmit="return confirm('このコメントを削除しますか？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded">
                                            削除する
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- ページネーション -->
                <div class="mt-6">
                    {{ $comments->links() }}
                </div>
            @else
                <div class="bg-white p-8 rounded-lg shadow-md text-center">
                    <p class="text-gray-500 text-lg">受信したコメントはありません</p>
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
    </main>

    <!-- フッター -->
    @include('components.footer')
</body>

</html>
