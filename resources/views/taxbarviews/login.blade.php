<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TaxBar®のトップページです。">
    <title>TaxBar® | HOME</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col min-h-full">
    @include('components.header')

    <main class="flex-grow">
        <!-- 背景動画 -->
        <div class="video-container">
            <video autoplay muted loop>
                <source src="{{ asset('videos/loginbackground.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <!-- 追加のH1見出し -->
        <h1 class="start-heading">さぁ､始めよう TaxBar®</h1>

        <!-- 追加する動画（80%サイズ） -->
        <div class="extra-video-container">
            <video autoplay muted loop>
                <source src="{{ asset('videos/ZOOM_1.mov') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <div class="timeline-container">
            <h1 class="start-heading">TaxBar®からのお知らせ</h1>
            <div class="timeline-item">
                <div id="news-content">
                    <p>最新のお知らせを取得中...</p>
                </div>
            </div>
        </div>

        <script>
            async function fetchNews() {
                const spreadsheetId = "1ckX1KuD_bWLBRp_I95w6HSsjlCxdXk_DR3DvBsaUgHA"; // ✅ あなたのスプレッドシートID
                const url = `https://docs.google.com/spreadsheets/d/${spreadsheetId}/gviz/tq?tqx=out:json`;

                try {
                    const response = await fetch(url);
                    const text = await response.text();
                    const json = JSON.parse(text.substring(47, text.length - 2)); // 余計な部分を削除
                    const rows = json.table.rows; // スプレッドシートのデータを取得

                    let newsHtml = "";
                    const maxItems = 5; // 最新5件を表示

                    for (let i = 0; i < Math.min(rows.length, maxItems); i++) {
                        if (rows[i] && rows[i].c[0] && rows[i].c[1]) {
                            let dateValue = rows[i].c[0].v; // スプレッドシートのA列データ（日時）
                            let formattedDate = "日付エラー"; // 初期値（エラーハンドリング）

                            // **📌 1. 数値のシリアル値（Google Sheetsの日付）を適切に変換**
                            if (typeof dateValue === "number") {
                                const baseDate = new Date(1899, 11, 30);
                                baseDate.setDate(baseDate.getDate() + dateValue);
                                formattedDate = baseDate.toLocaleString("ja-JP", {
                                    year: 'numeric',
                                    month: '2-digit',
                                    day: '2-digit',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });
                            }
                            // **📌 2. カンマ区切りの "Date(YYYY,MM,DD,HH,MM,SS)" を変換**
                            else if (typeof dateValue === "string" && dateValue.startsWith("Date(")) {
                                let dateParts = dateValue.match(/\d+/g); // 数字だけ抽出
                                if (dateParts && dateParts.length >= 3) {
                                    let year = parseInt(dateParts[0], 10);
                                    let month = parseInt(dateParts[1], 10) - 1; // **📌 月を 0 ベースに補正**
                                    let day = parseInt(dateParts[2], 10);
                                    let hours = dateParts.length > 3 ? parseInt(dateParts[3], 10) : 0;
                                    let minutes = dateParts.length > 4 ? parseInt(dateParts[4], 10) : 0;
                                    let seconds = dateParts.length > 5 ? parseInt(dateParts[5], 10) : 0;

                                    let parsedDate = new Date(year, month, day, hours, minutes, seconds);
                                    if (!isNaN(parsedDate.getTime())) {
                                        formattedDate = parsedDate.toLocaleString("ja-JP", {
                                            year: 'numeric',
                                            month: '2-digit',
                                            day: '2-digit',
                                            hour: '2-digit',
                                            minute: '2-digit'
                                        });
                                    } else {
                                        console.warn("無効なカンマ区切り日付:", dateValue);
                                    }
                                }
                            }
                            // **📌 3. "YYYY/MM/DD HH:MM:SS" の文字列を変換**
                            else if (typeof dateValue === "string") {
                                let parsedDate = new Date(dateValue);
                                if (!isNaN(parsedDate.getTime())) {
                                    formattedDate = parsedDate.toLocaleString("ja-JP", {
                                        year: 'numeric',
                                        month: '2-digit',
                                        day: '2-digit',
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    });
                                } else {
                                    console.warn("無効な文字列日付:", dateValue);
                                }
                            } else {
                                console.warn("日付が無効です:", dateValue);
                            }

                            let newsText = rows[i].c[1].v; // お知らせの内容
                            let newLabel = i === 0 ? `<span class="new-label">NEW!</span>` : ""; // 最新のお知らせに「NEW!」を表示

                            newsHtml += `<p class="news-item">${newLabel} ${formattedDate} - ${newsText}</p>`;
                        }
                    }

                    document.getElementById("news-content").innerHTML = newsHtml || `<p>現在、お知らせはありません。</p>`;
                } catch (error) {
                    console.error("ニュースの取得に失敗しました", error);
                    document.getElementById("news-content").innerHTML = `<p>お知らせの取得に失敗しました。</p>`;
                }
            }

            // 初回ロード時 & 10秒ごとに更新
            fetchNews();
            setInterval(fetchNews, 10000);
        </script>



        <div class="gif-container">
            <img src="{{ asset('images/robo1.gif') }}" alt="GIF2" class="gif-item">
        </div>
        <div class="guest-container">
            <div class="guest-title">
                <h1 class="x2txt">☆TaxBar&reg;イチオシのスペシャル税理士☆</h1>
                <h1 class="x2txt">！！新設法人設立Bar 2025年2月2日 PM20時～21時 要予約！！</h1>
                <h2 class="x2txt">大手監査法人出身 ! 財務のプロフェッショナル｡ 新設法人ならこの会計士 ！</h2>
                <button class="guest-button">今すぐ予約する</button>
            </div>

            <div class="guest-list">
                <!-- 3人目のゲスト -->
                <div class="guest-item">
                    <h2 class="x2txt">黒瀬公認会計士事務所</h2>
                    <div class="image-preview">
                        <img src="{{ asset('images/guest_v3.jpg') }}" alt="ゲストの画像">
                    </div>
                    <!-- 📌 GIF をゲスト画像の下中央に配置（1つだけ） -->
                    <div class="gif-container">
                        <img src="{{ asset('images/robo1.gif') }}" alt="GIF1" class="gif-item">
                    </div>
                </div>

                <!-- 4人目のゲスト -->
                <div class="guest-item">
                    <h2 class="x2txt">公認会計士税理士 黒瀬賢史</h2>
                    <div class="image-preview">
                        <img src="{{ asset('images/guest_v4.png') }}" alt="ゲストの画像">
                    </div>
                    <div>
                        <!-- 📌 GIF をゲスト画像の下中央に配置（1つだけ） -->
                        <div class="gif-container">
                            <img src="{{ asset('images/robo2.gif') }}" alt="GIF2" class="gif-item">
                        </div>
                    </div>
                </div>
            </div>

            <div class="guest-container">
                <div class="guest-title">
                    <h1 class="x2txt">☆TaxBar&reg;イチオシのスペシャル税理士☆</h1>
                    <h1 class="x2txt">！！資金調達Bar 2025年2月2日 PM20時～21時 要予約！！</h1>
                    <button class="guest-button">今すぐ予約する</button>
                </div>

                <div class="guest-list">
                    <!-- 1人目のゲスト -->
                    <div class="guest-item">
                        <h2 class="x2txt">酒井雄介税理士事務所</h2>
                        <div class="image-preview">
                            <img src="{{ asset('images/guest_v5.png') }}" alt="ゲストの画像">
                        </div>
                        <!-- 📌 GIF をゲスト画像の下中央に配置（1つだけ） -->
                        <div class="gif-container">
                            <img src="{{ asset('images/robo1.gif') }}" alt="GIF1" class="gif-item">
                        </div>
                    </div>

                    <!-- 2人目のゲスト -->
                    <div class="guest-item">
                        <h2 class="x2txt">公認会計士税理士 酒井雄介</h2>
                        <div class="image-preview">
                            <img src="{{ asset('images/guest_v6.png') }}" alt="ゲストの画像">
                        </div>
                        <!-- 📌 GIF をゲスト画像の下中央に配置（1つだけ） -->
                        <div class="gif-container">
                            <img src="{{ asset('images/robo2.gif') }}" alt="GIF2" class="gif-item">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('components.footer')
</body>

</html>
