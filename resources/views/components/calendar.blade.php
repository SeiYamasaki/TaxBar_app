@props(['events' => []])

<div id="calendar" class="bg-white p-4 rounded shadow"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            locale: 'ja',
            events: @json($events),
            editable: true,
            selectable: true,
            selectMirror: true,
            dayMaxEvents: true,
            eventClick: function(info) {
                // イベントクリック時の処理
                alert('イベント: ' + info.event.title);
            },
            select: function(info) {
                // 日付選択時の処理
                var title = prompt('イベントのタイトルを入力してください:');
                if (title) {
                    // ここでAjaxリクエストを送信してイベントを保存できます
                    calendar.addEvent({
                        title: title,
                        start: info.startStr,
                        end: info.endStr,
                        allDay: info.allDay
                    });
                }
                calendar.unselect();
            }
        });
        calendar.render();
    });
</script>

<style>
    #calendar {
        max-width: 1100px;
        margin: 0 auto;
    }
</style>
