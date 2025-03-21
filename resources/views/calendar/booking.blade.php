<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <main class="w-full px-4 sm:px-6 py-8">
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

    @push('styles')
        <style>
            .calendar-container {
                padding: 20px;
            }

            #calendar {
                max-width: 1800px;
                margin: 0 auto;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const calendarEl = document.getElementById('calendar');

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

                            events: [{
                                    title: '予約1',
                                    start: '2025-03-20',
                                    end: '2025-03-20',
                                    backgroundColor: '#007bff',
                                    borderColor: '#007bff'
                                },
                                {
                                    title: '予約2',
                                    start: '2025-03-21',
                                    end: '2025-03-21',
                                    backgroundColor: '#28a745',
                                    borderColor: '#28a745'
                                }
                            ]
                        });

                        calendar.render();
                    })
                    .catch(error => {
                        console.error("祝日データの取得に失敗しました:", error);
                    });
            });
        </script>
    @endpush

    @stack('scripts')
</body>

</html>
