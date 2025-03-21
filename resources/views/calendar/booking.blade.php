<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TaxBar®️ | 予約カレンダー</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.1/index.global.min.js"></script>
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
                    </div>
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
        saveBooking() { Alpine.store('bookingModal').saveBooking() }
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
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="endTime" class="block text-sm font-medium text-gray-700">終了時間</label>
                                    <input type="time" name="endTime" id="endTime" x-model="endTime"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="themeId"
                                        class="block text-sm font-medium text-gray-700">相談テーマ</label>
                                    <select name="themeId" id="themeId" x-model="themeId"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                        <option value="">選択してください</option>
                                        @foreach ($themes as $theme)
                                            <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                                        @endforeach
                                    </select>
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
            // Alpine.jsの初期化時にbookingModalストアを登録
            document.addEventListener('alpine:init', () => {
                console.log('Alpine.js初期化中');
                Alpine.store('bookingModal', {
                    open: false,
                    date: '',
                    startTime: '',
                    endTime: '',
                    themeId: '',
                    taxAdvisorId: {{ (auth()->user()->role === 'tax_advisor' || auth()->user()->role === 'admin') && auth()->user()->taxAdvisor ? auth()->user()->taxAdvisor->id : 'null' }},
                    isSaving: false,
                    saveBooking: function() {
                        console.log('予約保存開始');
                        this.isSaving = true;

                        // 日付と時間を結合してISOフォーマットに変換
                        const startDateTime = new Date(`${this.date}T${this.startTime}`);
                        const endDateTime = new Date(`${this.date}T${this.endTime}`);

                        // 予約データを準備
                        const bookingData = {
                            tax_advisor_id: this.taxAdvisorId,
                            theme_id: this.themeId || null,
                            start_time: startDateTime.toISOString(),
                            end_time: endDateTime.toISOString()
                        };

                        // APIリクエスト
                        fetch('{{ route('bookings.store') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                body: JSON.stringify(bookingData)
                            })
                            .then(response => response.json())
                            .then(data => {
                                this.isSaving = false;

                                if (data.success) {
                                    // 予約成功
                                    alert(data.message);
                                    this.open = false;

                                    // カレンダーを更新
                                    calendar.refetchEvents();
                                } else {
                                    // エラーメッセージを表示
                                    alert(data.message || 'エラーが発生しました');
                                }
                            })
                            .catch(error => {
                                this.isSaving = false;
                                console.error('Error:', error);
                                alert('予約に失敗しました');
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
                        const calendar = new FullCalendar.Calendar(calendarEl, {
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
                            selectable: true, // 日付選択を有効化
                            select: function(info) {
                                // 過去の日付は選択できないようにする
                                const today = new Date();
                                today.setHours(0, 0, 0, 0);

                                if (info.start < today) {
                                    calendar.unselect();
                                    return;
                                }

                                // デバッグ用のコンソールログを追加
                                console.log('日付選択:', info.startStr);
                                console.log('ユーザーロール:', '{{ auth()->user()->role }}');
                                console.log('税理士ロール:',
                                    {{ auth()->user()->role === 'tax_advisor' || auth()->user()->role === 'admin' ? 'true' : 'false' }}
                                );

                                // 税理士（専門家）のみ予約フォームを表示
                                @if (auth()->user()->role === 'tax_advisor' || auth()->user()->role === 'admin')
                                    // Alpine.storeを使ってモーダルを表示
                                    console.log('税理士ユーザーとして処理を開始');
                                    const bookingStore = Alpine.store('bookingModal');
                                    if (!bookingStore) {
                                        console.error('bookingModalストアが見つかりません');
                                        alert('システムエラーが発生しました。ページをリロードしてください。');
                                        return;
                                    }
                                    console.log('bookingModalストア:', bookingStore);

                                    bookingStore.date = info.startStr;
                                    bookingStore.startTime = '10:00';
                                    bookingStore.endTime = '11:00';
                                    bookingStore.themeId = '';
                                    bookingStore.open = true;
                                    console.log('モーダルを開きました', bookingStore);
                                @else
                                    // 一般ユーザーには予約できないメッセージを表示
                                    console.log('一般ユーザーとして処理');
                                    alert('予約は税理士（専門家）のみ可能です。カレンダーは閲覧のみご利用いただけます。');
                                    calendar.unselect();
                                @endif
                            },

                            dayCellDidMount: function(info) {
                                const dayNumberEl = info.el.querySelector('.fc-daygrid-day-number');
                                if (dayNumberEl) {
                                    const randomColor = colors[Math.floor(Math.random() * colors
                                        .length)];
                                    dayNumberEl.style.color = randomColor;
                                    dayNumberEl.style.fontWeight = "bold";
                                    dayNumberEl.style.fontSize = "1.1em";
                                    dayNumberEl.style.display = "inline-block";
                                    dayNumberEl.style.padding = "3px 6px";
                                    dayNumberEl.style.borderRadius = "6px";
                                    dayNumberEl.style.position = "relative"; // 🎯 祝日名の位置調整

                                    // ✅ JST (日本時間) に変換して日付を取得
                                    const localDate = new Date(info.date.getTime() + (9 * 60 * 60 *
                                        1000));
                                    const dateStr = localDate.toISOString().split("T")[
                                        0]; // YYYY-MM-DD 形式

                                    // 🌸 土日・祝日ハイライト
                                    if (info.date.getDay() === 0) {
                                        dayNumberEl.style.backgroundColor = "#FFB6C1"; // 日曜ピンク
                                    } else if (info.date.getDay() === 6) {
                                        dayNumberEl.style.backgroundColor = "#87CEFA"; // 土曜青
                                    }

                                    if (holidays[dateStr]) {
                                        dayNumberEl.style.backgroundColor = "#FFD700"; // ゴールド
                                        dayNumberEl.style.color = "#000";

                                        // 🏷️ **祝日名を日付の真横に表示**
                                        const holidayLabel = document.createElement("span");
                                        holidayLabel.textContent =
                                            ` ${holidays[dateStr]}`; // スペースで少し空ける
                                        holidayLabel.style.fontSize = "1em";
                                        holidayLabel.style.fontWeight = "bold";
                                        holidayLabel.style.color = "#006400"; // 深緑
                                        holidayLabel.style.marginLeft = "5px"; // 🎯 日付のすぐ横に配置
                                        holidayLabel.style.verticalAlign = "middle"; // 🎯 位置を揃える
                                        dayNumberEl.parentNode.insertBefore(holidayLabel, dayNumberEl
                                            .nextSibling);
                                    }
                                }
                            },

                            eventSources: [{
                                url: '{{ route('bookings.index') }}',
                                method: 'GET',
                                failure: function() {
                                    alert('予約データの取得に失敗しました');
                                }
                            }],

                            eventClick: function(info) {
                                // Zoomミーティングへの参加リンクがある場合は開く
                                if (info.event.url) {
                                    window.open(info.event.url);
                                    info.jsEvent.preventDefault(); // 通常のクリックイベントをキャンセル
                                }
                            }
                        });

                        calendar.render();
                    })
                    .catch(error => {
                        console.error("祝日データの取得に失敗しました:", error);
                    });
            });
        </script>
    @endpush

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @stack('scripts')
</body>

</html>
