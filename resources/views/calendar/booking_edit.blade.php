<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TaxBar®️ | 予約編集</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.12.3/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="flex h-full bg-gray-100 relative">
    <x-tax-advisor.sidebar :user="auth()->user()" />

    <!-- メインコンテンツ -->
    <div class="flex-1 md:ml-64 transition-all duration-300 ease-in-out">
        <!-- ヘッダー -->
        <header class="fixed top-0 right-0 left-0 md:left-64 z-[999] bg-white md:bg-transparent shadow md:shadow-none">
            <div class="flex justify-between items-center h-16 px-4 md:px-6">
                <!-- モバイル用のハンバーガーメニューのスペース -->
                <div class="w-10 md:hidden"></div>

                <!-- アカウントメニュー - 右寄せ -->
                <div class="relative ml-auto" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                        <div class="flex items-center space-x-4">
                            @if (auth()->user()->taxAdvisor && auth()->user()->taxAdvisor->tax_accountant_photo)
                                <img src="{{ asset('storage/' . auth()->user()->taxAdvisor->tax_accountant_photo) }}"
                                    alt="プロフィール画像" class="w-10 h-10 rounded-full">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex flex-col">
                                <span
                                    class="text-sm font-medium text-gray-700 md:text-white">{{ auth()->user()->name }}</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>

                    <!-- ドロップダウンメニュー -->
                    <div x-show="open" x-cloak @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-[9999]">
                        <a href="{{ route('tax_advisor.profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            プロフィール編集
                        </a>
                        <a href="{{ route('notifications.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            通知
                            @if (auth()->user()->unreadNotifications->count() > 0)
                                <span
                                    class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <button type="submit" @click.prevent="$el.closest('form').submit()"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                ログアウト
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <x-parallax-header />

        <!-- メインコンテンツのパディング調整 -->
        <div class="relative w-full -mt-24 z-50">
            <main class="w-full px-8 sm:px-10 py-16">

                <!-- 編集フォーム -->
                <div class="bg-white rounded-lg shadow p-6 w-full max-w-[1000px] mx-auto" x-data="bookingEditApp()">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-3xl font-semibold text-gray-800">予約編集</h2>
                        <div class="flex space-x-2">
                            <a href="{{ route('calendar.index') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 focus:outline-none">
                                カレンダーに戻る
                            </a>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-200 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 p-3 bg-red-100 text-red-700 border border-red-200 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- システムメッセージ表示エリア -->
                    <div x-show="message.text"
                        :class="message.type === 'error' ? 'bg-red-100 text-red-700 border-red-200' :
                            'bg-green-100 text-green-700 border-green-200'"
                        class="mb-4 p-3 border rounded">
                        <span x-text="message.text"></span>
                    </div>

                    <form @submit.prevent="updateBooking">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- 予約タイトル -->
                            <div class="md:col-span-2">
                                <label for="title" class="block text-2xl font-medium text-pink-700">予約タイトル</label>
                                <input type="text" name="title" id="title" x-model="form.title"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 text-2xl">
                            </div>

                            <!-- 開始日付と時間 -->
                            <div>
                                <label for="start_date" class="block text-2xl font-medium text-yellow-700">開始日</label>
                                <input type="date" name="start_date" id="start_date" x-model="form.start_date"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 text-2xl">
                            </div>

                            <div>
                                <label for="start_time" class="block text-2xl font-medium text-green-700">開始時間</label>
                                <input type="time" name="start_time" id="start_time" x-model="form.start_time"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 text-2xl">
                            </div>

                            <!-- 終了日付と時間 -->
                            <div>
                                <label for="end_date" class="block text-2xl font-medium text-blue-700">終了日</label>
                                <input type="date" name="end_date" id="end_date" x-model="form.end_date"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 text-2xl">
                            </div>

                            <div>
                                <label for="end_time" class="block text-2xl font-medium text-purple-700">終了時間</label>
                                <input type="time" name="end_time" id="end_time" x-model="form.end_time"
                                    readonly
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-100 cursor-not-allowed focus:outline-none focus:ring-green-500 focus:border-green-500 text-2xl">
                            </div>

                            <!-- 相談テーマ -->
                            <div>
                                <label for="theme_id" class="block text-2xl font-medium text-indigo-700">相談テーマ</label>
                                <select name="theme_id" id="theme_id" x-model="form.theme_id"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 text-2xl">
                                    <option value="">選択してください</option>
                                    @forelse ($themes as $theme)
                                        <option value="{{ $theme->id }}"
                                            {{ ($booking->theme_id ?? null) == $theme->id ? 'selected' : '' }}>
                                            {{ $theme->title }}
                                        </option>
                                    @empty
                                        <option value="" disabled>テーマがありません</option>
                                    @endforelse
                                </select>
                                @if ($themes->isEmpty())
                                    <p class="mt-1 text-base text-red-500">テーマが設定されていません。プロフィール編集で専門テーマを選択してください。</p>
                                @endif
                            </div>

                            <!-- ステータス -->
                            <div>
                                <label for="status" class="block text-2xl font-medium text-rose-700">ステータス</label>
                                <select name="status" id="status" x-model="form.status"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 text-2xl">
                                    @foreach (App\Http\Controllers\BookingApiController::$bookingStatus as $status)
                                        <option value="{{ $status }}"
                                            {{ ($booking->status ?? null) == $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Zoom会議URL（表示のみ） -->
                            <div class="md:col-span-2">
                                <label for="zoom_url"
                                    class="block text-2xl font-medium text-orange-700">Zoom会議URL</label>
                                <div class="mt-1 flex items-center">
                                    <input type="text" id="zoom_url" readonly x-model="form.zoom_url"
                                        class="block w-full border border-gray-300 bg-gray-100 rounded-md shadow-sm py-2 px-3 focus:outline-none text-2xl">
                                    <button type="button" @click="copyZoomUrl"
                                        class="ml-2 p-2 bg-blue-100 text-blue-600 rounded hover:bg-blue-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                </div>
                                <p class="mt-1 text-base text-gray-500">Zoom会議URLは自動生成され、更新できません</p>
                            </div>
                        </div>

                        <!-- ボタングループ -->
                        <div class="mt-8 flex justify-between">
                            <div>
                                <button type="button" @click="confirmDelete"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-xl font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    :disabled="isProcessing">
                                    <span x-show="!isProcessing">予約を削除</span>
                                    <span x-show="isProcessing" class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        処理中...
                                    </span>
                                </button>
                            </div>

                            <div class="flex space-x-3">
                                <a href="{{ route('calendar.index') }}"
                                    class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-xl font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    キャンセル
                                </a>
                                <button type="submit" :disabled="isProcessing"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-xl font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <span x-show="!isProcessing">保存</span>
                                    <span x-show="isProcessing" class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        保存中...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <!-- Alpine.js スクリプト -->
    <script>
        function bookingEditApp() {
            return {
                form: {
                    title: "{{ $booking->title ?? 'Zoom相談予約' }}",
                    start_date: "{{ $booking->start_time ? $booking->start_time->format('Y-m-d') : '' }}",
                    start_time: "{{ $booking->start_time ? $booking->start_time->format('H:i') : '' }}",
                    end_date: "{{ $booking->end_time ? $booking->end_time->format('Y-m-d') : '' }}",
                    end_time: "{{ $booking->end_time ? $booking->end_time->format('H:i') : '' }}",
                    theme_id: "{{ $booking->theme_id ?? '' }}",
                    status: "{{ $booking->status ?? '保留中' }}",
                    zoom_url: "{{ $booking->zoom_meeting_url ?? '' }}"
                },
                isProcessing: false,
                message: {
                    text: '',
                    type: 'success'
                },

                // 予約更新処理
                updateBooking() {
                    this.isProcessing = true;
                    this.message.text = '';

                    // CSRFトークンを取得
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    // 開始時間と終了時間をISOフォーマットに変換
                    const startDateTime = new Date(`${this.form.start_date}T${this.form.start_time}`);
                    const endDateTime = new Date(`${this.form.end_date}T${this.form.end_time}`);

                    // 予約データを準備
                    const bookingData = {
                        title: this.form.title,
                        theme_id: this.form.theme_id || null,
                        start_time: startDateTime.toISOString(),
                        end_time: endDateTime.toISOString(),
                        status: this.form.status
                    };

                    // APIリクエスト
                    fetch('/bookings/{{ $booking->id }}/update', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(bookingData)
                        })
                        .then(response => {
                            if (response.status === 401 || response.status === 419) {
                                throw new Error('認証エラー: セッションが期限切れかログアウト状態です');
                            }
                            return response.json();
                        })
                        .then(data => {
                            this.isProcessing = false;

                            if (data.success) {
                                this.message = {
                                    text: '予約が更新されました',
                                    type: 'success'
                                };

                                // 3秒後にメッセージを消す
                                setTimeout(() => {
                                    this.message.text = '';
                                }, 3000);
                            } else {
                                this.message = {
                                    text: data.message || 'エラーが発生しました',
                                    type: 'error'
                                };
                            }
                        })
                        .catch(error => {
                            this.isProcessing = false;
                            this.message = {
                                text: '更新に失敗しました: ' + error.message,
                                type: 'error'
                            };
                            console.error('Error:', error);
                        });
                },

                // 予約削除確認
                confirmDelete() {
                    if (confirm('この予約を削除しますか？この操作は取り消せません。')) {
                        this.deleteBooking();
                    }
                },

                // 予約削除処理
                deleteBooking() {
                    this.isProcessing = true;
                    this.message.text = '';

                    // CSRFトークンを取得
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    // APIリクエスト
                    fetch('/bookings/{{ $booking->id }}', {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (response.status === 401 || response.status === 419) {
                                throw new Error('認証エラー: セッションが期限切れかログアウト状態です');
                            }
                            return response.json();
                        })
                        .then(data => {
                            this.isProcessing = false;

                            if (data.message && !data.error) {
                                this.message = {
                                    text: '予約が削除されました',
                                    type: 'success'
                                };

                                // 2秒後にカレンダー画面にリダイレクト
                                setTimeout(() => {
                                    window.location.href = '{{ route('calendar.index') }}';
                                }, 2000);
                            } else {
                                this.message = {
                                    text: data.error || 'エラーが発生しました',
                                    type: 'error'
                                };
                            }
                        })
                        .catch(error => {
                            this.isProcessing = false;
                            this.message = {
                                text: '削除に失敗しました: ' + error.message,
                                type: 'error'
                            };
                            console.error('Error:', error);
                        });
                },

                // Zoom URLのコピー
                copyZoomUrl() {
                    if (!this.form.zoom_url) {
                        alert('Zoom会議URLがありません');
                        return;
                    }

                    navigator.clipboard.writeText(this.form.zoom_url)
                        .then(() => {
                            alert('Zoom会議URLをクリップボードにコピーしました');
                        })
                        .catch(err => {
                            console.error('コピーに失敗しました:', err);
                            alert('コピーに失敗しました');
                        });
                }
            };
        }
    </script>
</body>

</html>
