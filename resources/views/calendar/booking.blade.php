<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TaxBar®️ | 予約カレンダー</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.12.3/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
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

                <!-- カレンダー本体 -->
                <div class="bg-white rounded-lg shadow p-6 w-full max-w-[1800px] mx-auto">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">TaxBar®予約管理カレンダー</h2>
                        <button id="refreshButton" type="button"
                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none">
                            <i class="fas fa-sync-alt mr-2"></i>更新
                        </button>
                    </div>

                    <!-- システムメッセージ表示エリア -->
                    <div id="system-messages"
                        class="mb-4 p-3 bg-blue-100 text-blue-700 border border-blue-200 rounded hidden">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span id="message-content">システムメッセージ</span>
                        </div>
                    </div>

                    <!-- エラーメッセージ表示エリア -->
                    <div id="error-messages"
                        class="mb-4 p-3 bg-red-100 text-red-700 border border-red-200 rounded hidden">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span id="error-content">エラーメッセージ</span>
                        </div>
                    </div>

                    <!-- デバッグパネル (開発環境のみ) -->
                    @if (config('app.env') === 'local' || config('app.debug'))
                        <div id="debug-panel" class="mb-4 p-2 bg-gray-100 border border-gray-300 rounded text-sm">
                            <div class="flex justify-between items-center">
                                <h3 class="text-gray-700 font-bold">開発用デバッグ情報</h3>
                                <button id="toggle-debug"
                                    class="px-2 py-1 bg-gray-300 text-gray-700 rounded text-xs">表示</button>
                            </div>
                            <div id="debug-content" style="display: none;" class="mt-2">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <h4 class="font-semibold">システム情報</h4>
                                        <ul class="mt-1">
                                            <li>環境: {{ config('app.env') }}</li>
                                            <li>デバッグモード: {{ config('app.debug') ? 'ON' : 'OFF' }}</li>
                                            <li>Zoom設定:
                                                {{ !empty(config('services.zoom.client_id')) ? '設定済み' : '未設定' }}</li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold">API通信ログ</h4>
                                        <div id="api-log"
                                            class="mt-1 h-40 overflow-y-auto bg-gray-50 p-2 text-xs border rounded">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- カレンダー表示エリア -->
                    <div id="calendar" class="w-full"></div>
                </div>
            </main>
        </div>
    </div>

    <!-- 予約モーダル -->
    <div id="bookingModal" x-data="{
        get open() { return Alpine.store('bookingModal').open },
        set open(value) { Alpine.store('bookingModal').open = value },
        get date() { return Alpine.store('bookingModal').date },
        set date(value) { Alpine.store('bookingModal').date = value },
        get startTime() { return Alpine.store('bookingModal').startTime },
        set startTime(value) { Alpine.store('bookingModal').startTime = value },
        get endTime() { return Alpine.store('bookingModal').endTime },
        set endTime(value) { Alpine.store('bookingModal').endTime = value },
        get themeId() { return Alpine.store('bookingModal').themeId },
        set themeId(value) { Alpine.store('bookingModal').themeId = value },
        get isSaving() { return Alpine.store('bookingModal').isSaving },
        get meetingDuration() { return Alpine.store('bookingModal').meetingDuration },
        calculateEndTime() { Alpine.store('bookingModal').calculateEndTime() },
        saveBooking() { Alpine.store('bookingModal').saveBooking() },
        get calendarRef() { return Alpine.store('bookingModal').calendarRef },
        set calendarRef(value) { Alpine.store('bookingModal').calendarRef = value },
        get title() { return Alpine.store('bookingModal').title },
        set title(value) { Alpine.store('bookingModal').title = value }
    }" x-show="open" x-cloak class="fixed inset-0 z-[1000] overflow-y-auto"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="open" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Zoom相談予約
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="date" class="block text-sm font-medium text-gray-700">日付</label>
                                    <input type="date" name="date" id="date" x-model="date"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="startTime"
                                        class="block text-sm font-medium text-gray-700">開始時間</label>
                                    <input type="time" name="startTime" id="startTime" x-model="startTime"
                                        @change="calculateEndTime()"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="endTime" class="block text-sm font-medium text-gray-700">終了時間</label>
                                    <div x-show="meetingDuration !== null">
                                        <input type="time" name="endTime" id="endTime" x-model="endTime"
                                            readonly
                                            class="mt-1 block w-full border border-gray-300 bg-gray-100 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                        <p class="mt-1 text-xs text-gray-500">終了時間はご契約のプランによって自動設定されます</p>
                                    </div>
                                    <div x-show="meetingDuration === null">
                                        <div
                                            class="mt-1 block w-full border border-gray-300 bg-gray-100 rounded-md shadow-sm py-2 px-3 sm:text-sm">
                                            無制限
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500">VIPプランは時間無制限でご利用いただけます</p>
                                    </div>
                                </div>

                                <div>
                                    <label for="themeId"
                                        class="block text-sm font-medium text-gray-700">相談テーマ</label>
                                    <select name="themeId" id="themeId" x-model="themeId"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                        <option value="">選択してください</option>
                                        @if ($themes->count() > 0)
                                            @foreach ($themes as $theme)
                                                <option value="{{ $theme->id }}">{{ $theme->title }}</option>
                                            @endforeach
                                        @else
                                            <option value="" disabled>専門テーマが選択されていません</option>
                                        @endif
                                    </select>
                                    @if ($themes->count() == 0)
                                        <p class="mt-1 text-xs text-red-500">プロフィール編集で専門テーマを選択してください</p>
                                    @endif
                                </div>

                                <div>
                                    <label for="title"
                                        class="block text-sm font-medium text-gray-700">予約タイトル</label>
                                    <input type="text" name="title" id="title" x-model="title"
                                        value="Zoom相談予約"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" @click="saveBooking()" :disabled="isSaving"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        <span x-show="!isSaving">予約する</span>
                        <span x-show="isSaving" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            処理中...
                        </span>
                    </button>
                    <button type="button" @click="open = false"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        キャンセル
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .calendar-container {
                padding: 20px;
            }

            #calendar {
                max-width: 1800px;
                margin: 0 auto;
            }

            /* 予約可能な時間帯のスタイル */
            .fc-event.available-slot {
                background-color: #d1e7dd;
                border-color: #badbcc;
                color: #0f5132;
                cursor: pointer;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // グローバルエラーハンドラーを設定
            window.addEventListener('error', function(e) {
                console.error('Uncaught error:', e.error);
                // エラーをユーザーに通知（開発時のみ）
                if (location.hostname === 'localhost' || location.hostname === '127.0.0.1') {
                    const errorDiv = document.createElement('div');
                    errorDiv.className =
                        'fixed bottom-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg max-w-md';
                    errorDiv.innerHTML = `<p class="font-bold">JavaScriptエラー</p>
                                         <p>${e.error?.message || 'Unknown error'}</p>`;
                    document.body.appendChild(errorDiv);

                    // 5秒後に消える
                    setTimeout(() => {
                        errorDiv.remove();
                    }, 5000);
                }
            });

            // Alpine.jsの初期化時にbookingModalストアを登録
            document.addEventListener('alpine:init', () => {
                console.log('Alpine.js初期化中');
                Alpine.store('bookingModal', {
                    open: false,
                    date: '',
                    startTime: '',
                    endTime: '',
                    themeId: '',
                    title: 'Zoom相談予約', // デフォルトタイトル
                    taxAdvisorId: {{ (auth()->user()->role === 'tax_advisor' || auth()->user()->role === 'admin') && auth()->user()->taxAdvisor ? auth()->user()->taxAdvisor->id : 'null' }},
                    meetingDuration: {{ (auth()->user()->role === 'tax_advisor' || auth()->user()->role === 'admin') &&
                    auth()->user()->taxAdvisor &&
                    auth()->user()->taxAdvisor->subscriptionPlan
                        ? (auth()->user()->taxAdvisor->subscriptionPlan->zoom_meeting_duration === null
                            ? 'null'
                            : auth()->user()->taxAdvisor->subscriptionPlan->zoom_meeting_duration)
                        : 60 }},
                    isSaving: false,
                    calendarRef: null, // カレンダー参照用の変数を追加
                    calculateEndTime: function() {
                        console.log('計算開始 - meetingDuration:', this.meetingDuration);

                        if (this.startTime) {
                            // VIPプランの場合は無制限
                            if (this.meetingDuration === null) {
                                console.log('VIPプラン検出: 終了時間を無制限に設定');
                                this.endTime = null;
                                return;
                            }

                            // 開始時間をDate型に変換
                            const startDate = new Date(`2000-01-01T${this.startTime}`);

                            // ミーティング時間（分）を加算
                            startDate.setMinutes(startDate.getMinutes() + this.meetingDuration);

                            // HH:MM形式に変換
                            let hours = startDate.getHours().toString().padStart(2, '0');
                            let minutes = startDate.getMinutes().toString().padStart(2, '0');

                            this.endTime = `${hours}:${minutes}`;
                            console.log('計算後の終了時間:', this.endTime);
                        }
                    },
                    saveBooking: function() {
                        console.log('予約保存開始');
                        this.isSaving = true;

                        // CSRFトークンを取得
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content');
                        console.log('CSRFトークン:', csrfToken ? 'あり' : 'なし');

                        // 日付と時間を結合してISOフォーマットに変換
                        const startDateTime = new Date(`${this.date}T${this.startTime}`);

                        // VIPプランの場合、終了時間は開始時間+4時間に設定
                        let endDateTime;
                        if (this.meetingDuration === null) {
                            // VIPプラン（無制限）の場合
                            const endDate = new Date(startDateTime.getTime());
                            endDate.setHours(endDate.getHours() + 4); // 4時間を加算
                            endDateTime = endDate;
                            console.log('VIPプラン：終了時間を4時間後に設定', endDateTime.toISOString());
                        } else {
                            // 通常プラン
                            endDateTime = new Date(`${this.date}T${this.endTime}`);
                        }

                        // タイトルが未設定の場合はデフォルト値を設定
                        if (!this.title || this.title.trim() === '') {
                            this.title = 'Zoom相談予約';
                        }

                        // 予約データを準備
                        const bookingData = {
                            tax_advisor_id: this.taxAdvisorId,
                            theme_id: this.themeId || null,
                            start_time: startDateTime.toISOString(),
                            end_time: endDateTime.toISOString(),
                            title: this.title
                        };

                        console.log('送信データ：', bookingData);

                        // APIリクエスト
                        fetch('{{ route('bookings.store') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                credentials: 'same-origin', // セッションCookieを含める
                                body: JSON.stringify(bookingData)
                            })
                            .then(response => {
                                // ステータスコードとレスポンスタイプを記録
                                console.log('Response status:', response.status);
                                console.log('Response type:', response.headers.get('content-type'));

                                // セッション期限切れやログアウト状態の場合はページをリロード
                                if (response.status === 401 || response.status === 419) {
                                    console.error('認証エラー: セッションが期限切れかログアウト状態です');
                                    alert('セッションが期限切れです。ページをリロードします。');
                                    window.location.reload();
                                    return Promise.reject('認証エラー');
                                }

                                if (response.status === 422) {
                                    return response.json().then(data => {
                                        console.error('バリデーションエラー:', data);
                                        let errorMessage = 'バリデーションエラー: ';
                                        if (data.details) {
                                            for (const [field, errors] of Object.entries(data
                                                    .details)) {
                                                errorMessage +=
                                                    `${field}: ${errors.join(', ')}; `;
                                            }
                                        } else {
                                            errorMessage += data.error || '不明なエラー';
                                        }
                                        throw new Error(errorMessage);
                                    });
                                }

                                // エラーレスポンスの場合はエラーメッセージを取得
                                if (!response.ok) {
                                    if (response.headers.get('content-type')?.includes(
                                            'application/json')) {
                                        return response.json().then(data => {
                                            throw new Error(data.message ||
                                                `サーバーエラー: ${response.status}`);
                                        });
                                    } else {
                                        // HTML等のレスポンスの場合はテキストとして読み込む
                                        return response.text().then(text => {
                                            console.error('HTMLエラーレスポンス:', text.substring(0,
                                                200) + '...');
                                            throw new Error(`予期しないレスポンス形式: ${response.status}`);
                                        });
                                    }
                                }

                                // 正常なレスポンスの場合はJSONとして解析
                                return response.json();
                            })
                            .then(data => {
                                this.isSaving = false;

                                if (data.success) {
                                    // 予約成功のデータをログに記録
                                    console.log('予約成功:', data);
                                    console.log('Zoom会議情報:', data.zoom_meeting);

                                    // Zoom会議URLがある場合は表示
                                    if (data.zoom_meeting && data.zoom_meeting.join_url) {
                                        const meetingInfo = '予約が完了しました！\n\n' +
                                            'Zoom会議URL: ' + data.zoom_meeting.join_url + '\n' +
                                            (data.zoom_meeting.password ? 'パスワード: ' + data.zoom_meeting
                                                .password : '');
                                        alert(meetingInfo);
                                    } else {
                                        // 通常の成功メッセージ
                                        alert(data.message || '予約が完了しました');
                                    }

                                    this.open = false;

                                    // カレンダーを更新
                                    if (window.calendarInstance) {
                                        window.calendarInstance.refetchEvents();
                                        console.log('カレンダーイベントを更新しました（window.calendarInstance経由）');
                                    } else if (this.calendarRef) {
                                        this.calendarRef.refetchEvents();
                                        console.log('カレンダーイベントを更新しました（Alpine.js store経由）');
                                    } else {
                                        console.error('カレンダー参照が見つかりません');
                                        // 強制的にページを更新
                                        window.location.reload();
                                    }
                                } else {
                                    // エラーメッセージを表示
                                    alert(data.message || 'エラーが発生しました');
                                }
                            })
                            .catch(error => {
                                this.isSaving = false;
                                console.error('Error:', error);
                                // エラーの詳細情報を表示
                                alert('予約に失敗しました: ' + error.message);
                            });
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                const calendarEl = document.getElementById('calendar');
                const bookingModal = document.getElementById('bookingModal');

                // CSRFトークンをヘッダーに設定
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;

                const colors = [
                    "#8B0000", // Dark Red（深い赤）
                    "#A0522D", // Sienna Brown（シエナブラウン）
                    "#556B2F", // Dark Olive Green（ダークオリーブグリーン）
                    "#2F4F4F", // Dark Slate Gray（ダークスレートグレー）
                    "#3B4252", // Midnight Blue（ミッドナイトブルー）
                    "#4B0082", // Indigo（インディゴ）
                    "#6A5ACD", // Slate Blue（スレートブルー）
                    "#8B4513", // Saddle Brown（サドルブラウン）
                    "#483D8B", // Dark Slate Blue（ダークスレートブルー）
                    "#2C3E50" // Charcoal Blue（チャコールブルー）
                ];

                // 🇯🇵 祝日API（最新の祝日を取得）
                fetch('https://holidays-jp.github.io/api/v1/date.json')
                    .then(response => response.json())
                    .then(holidays => {
                        // カレンダーオブジェクトをグローバル変数に保存
                        window.calendarInstance = new FullCalendar.Calendar(calendarEl, {
                            initialView: 'dayGridMonth',
                            locale: 'ja',
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,timeGridWeek,timeGridDay'
                            },
                            buttonText: {
                                today: '今日',
                                month: '月表示',
                                week: '週表示',
                                day: '日表示'
                            },
                            allDaySlot: false,
                            slotMinTime: '09:00:00',
                            slotMaxTime: '18:00:00',
                            height: 1000,
                            selectable: true,
                            select: function(info) {
                                // 過去の日付は選択できないようにする
                                const today = new Date();
                                today.setHours(0, 0, 0, 0);

                                if (info.start < today) {
                                    window.calendarInstance.unselect();
                                    return;
                                }

                                console.log('日付選択:', info.startStr);
                                console.log('ユーザーロール:', '{{ auth()->user()->role }}');

                                @if (auth()->user()->role === 'tax_advisor' || auth()->user()->role === 'admin')
                                    const bookingStore = Alpine.store('bookingModal');
                                    if (!bookingStore) {
                                        window.addApiLog('bookingModalストアが見つかりません', 'error');
                                        return;
                                    }

                                    bookingStore.date = info.startStr;
                                    bookingStore.startTime = '10:00';
                                    bookingStore.calculateEndTime();
                                    bookingStore.themeId = '';
                                    bookingStore.open = true;
                                @else
                                    alert('予約は税理士（専門家）のみ可能です。カレンダーは閲覧のみご利用いただけます。');
                                    window.calendarInstance.unselect();
                                @endif
                            },

                            eventSources: [{
                                url: '{{ url('api/bookings') }}',
                                method: 'GET',
                                format: 'json',
                                failure: function(error) {
                                    console.error('予約データの取得エラー:', error);
                                    window.addApiLog('予約データの取得エラー: ' + error.message, 'error');
                                    return [];
                                }
                            }]
                        });

                        window.calendarInstance.render();

                        if (Alpine.store('bookingModal')) {
                            Alpine.store('bookingModal').calendarRef = window.calendarInstance;
                            console.log('カレンダー参照がAlpineストアに保存されました');
                        }
                    })
                    .catch(error => {
                        console.error("祝日データの取得に失敗しました:", error);
                        // エラーが発生しても、カレンダーは表示する（祝日なしで）
                        window.addApiLog("祝日データの取得に失敗しました: " + error.message, "error");

                        // エラーメッセージを表示
                        const errorMsgEl = document.getElementById('error-content');
                        const errorMsgArea = document.getElementById('error-messages');
                        if (errorMsgEl && errorMsgArea) {
                            errorMsgEl.textContent = "祝日データの取得に失敗しました。カレンダーを更新してください。";
                            errorMsgArea.classList.remove('hidden');

                            // 5秒後にメッセージを消す
                            setTimeout(() => {
                                errorMsgArea.classList.add('hidden');
                            }, 5000);
                        }

                        // カレンダーを祝日なしで初期化
                        window.calendarInstance = new FullCalendar.Calendar(calendarEl, {
                            initialView: 'dayGridMonth',
                            locale: 'ja',
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,timeGridWeek,timeGridDay'
                            },
                            buttonText: {
                                today: '今日',
                                month: '月表示',
                                week: '週表示',
                                day: '日表示'
                            },
                            allDaySlot: false,
                            slotMinTime: '09:00:00',
                            slotMaxTime: '18:00:00',
                            height: 1000,
                            selectable: true,
                            select: function(info) {
                                // 過去の日付は選択できないようにする
                                const today = new Date();
                                today.setHours(0, 0, 0, 0);

                                if (info.start < today) {
                                    window.calendarInstance.unselect();
                                    return;
                                }

                                console.log('日付選択:', info.startStr);
                                console.log('ユーザーロール:', '{{ auth()->user()->role }}');

                                @if (auth()->user()->role === 'tax_advisor' || auth()->user()->role === 'admin')
                                    const bookingStore = Alpine.store('bookingModal');
                                    if (!bookingStore) {
                                        window.addApiLog('bookingModalストアが見つかりません', 'error');
                                        return;
                                    }

                                    bookingStore.date = info.startStr;
                                    bookingStore.startTime = '10:00';
                                    bookingStore.calculateEndTime();
                                    bookingStore.themeId = '';
                                    bookingStore.open = true;
                                @else
                                    alert('予約は税理士（専門家）のみ可能です。カレンダーは閲覧のみご利用いただけます。');
                                    window.calendarInstance.unselect();
                                @endif
                            },

                            eventSources: [{
                                url: '{{ url('api/bookings') }}',
                                method: 'GET',
                                format: 'json',
                                failure: function(error) {
                                    console.error('予約データの取得エラー:', error);
                                    window.addApiLog('予約データの取得エラー: ' + error.message, 'error');
                                    return [];
                                }
                            }]
                        });

                        window.calendarInstance.render();

                        if (Alpine.store('bookingModal')) {
                            Alpine.store('bookingModal').calendarRef = window.calendarInstance;
                            console.log('カレンダー参照がAlpineストアに保存されました');
                        }
                    });
            });
        </script>
    @endpush

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @stack('scripts')

    <script>
        // デバッグ関数をグローバルに定義（カレンダー初期化前に）
        window.addApiLog = function(message, type = 'info') {
            const apiLog = document.getElementById('api-log');
            if (!apiLog) {
                console.log(`${type}: ${message}`);
                return;
            }

            const logEntry = document.createElement('div');
            logEntry.classList.add('log-entry', `log-${type}`);

            const timestamp = new Date().toLocaleTimeString('ja-JP');
            logEntry.innerHTML =
                `<span class="log-time">${timestamp}</span> <span class="log-message">${message}</span>`;

            if (type === 'error') {
                logEntry.style.color = '#dc3545';
            } else if (type === 'success') {
                logEntry.style.color = '#28a745';
            } else if (type === 'warning') {
                logEntry.style.color = '#ffc107';
            }

            apiLog.prepend(logEntry);

            // 最大30件まで保持
            const entries = apiLog.querySelectorAll('.log-entry');
            if (entries.length > 30) {
                for (let i = 30; i < entries.length; i++) {
                    entries[i].remove();
                }
            }
        };

        // デバッグパネル機能
        document.addEventListener('DOMContentLoaded', function() {
            const debugPanel = document.getElementById('debug-panel');
            const debugContent = document.getElementById('debug-content');
            const toggleDebugBtn = document.getElementById('toggle-debug');
            const apiLog = document.getElementById('api-log');
            const refreshButton = document.getElementById('refreshButton');

            // デバッグパネルが存在する場合のみ処理
            if (debugPanel && toggleDebugBtn) {
                // デバッグパネル表示切替
                toggleDebugBtn.addEventListener('click', function() {
                    if (debugContent.style.display === 'none') {
                        debugContent.style.display = 'block';
                        toggleDebugBtn.textContent = '非表示';
                    } else {
                        debugContent.style.display = 'none';
                        toggleDebugBtn.textContent = '表示';
                    }
                });

                // システム情報表示
                window.addApiLog('デバッグモード起動中', 'info');
                window.addApiLog('環境: {{ config('app.env') }}', 'info');
                window.addApiLog('Zoom設定: {{ !empty(config('services.zoom.client_id')) ? '設定あり' : '未設定' }}',
                    'info');
            }

            // 更新ボタンの機能拡張
            if (refreshButton) {
                refreshButton.addEventListener('click', function() {
                    window.addApiLog('ページ更新を開始します...', 'info');
                    // システムメッセージを表示
                    const systemMessages = document.getElementById('system-messages');
                    const messageContent = document.getElementById('message-content');
                    if (systemMessages && messageContent) {
                        messageContent.textContent = 'データを再読み込み中です...';
                        systemMessages.classList.remove('hidden');
                    }

                    // カレンダーをリフレッシュ
                    if (window.calendarInstance) {
                        window.calendarInstance.refetchEvents();
                        window.addApiLog('カレンダーデータ再読み込み完了', 'success');

                        // 3秒後にメッセージを隠す
                        setTimeout(function() {
                            systemMessages.classList.add('hidden');
                        }, 3000);
                    }
                });
            }

            // 元のAPIリクエストをラップして、ログに記録するようにする
            const originalFetch = window.fetch;
            window.fetch = function() {
                // APIリクエスト開始をログに記録
                const url = arguments[0];
                const method = arguments[1]?.method || 'GET';
                window.addApiLog(`${method} リクエスト: ${url}`, 'info');

                return originalFetch.apply(this, arguments)
                    .then(response => {
                        // レスポンスステータスをログに記録
                        const status = response.status;
                        const statusText = response.statusText;

                        if (status >= 200 && status < 300) {
                            window.addApiLog(`成功: ${status} ${statusText}`, 'success');
                        } else if (status >= 400) {
                            window.addApiLog(`エラー: ${status} ${statusText}`, 'error');
                        } else {
                            window.addApiLog(`レスポンス: ${status} ${statusText}`, 'warning');
                        }

                        return response;
                    })
                    .catch(error => {
                        window.addApiLog(`通信エラー: ${error.message}`, 'error');
                        throw error;
                    });
            };
        });
    </script>
</body>

</html>
