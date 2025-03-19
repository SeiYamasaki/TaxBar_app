@extends('layouts.app')

@section('content')
    <style>
        /* このページだけ背景を白くする */
        body {
            background-color: white !important;
        }

        /* レインボーアニメーション */
        @keyframes rainbowAnimation {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* タイトルのスタイル */
        .title-container {
            text-align: left;
            font-size: 26px;
            font-weight: bold;
            color: #2b2b99;
            display: inline-block;
            white-space: nowrap;
        }

        /* スマホ対応 */
        @media (max-width: 768px) {
            .title-container {
                font-size: 12px;
                text-align: left;
                white-space: normal;
            }
        }

        /* タイトルのスタイル調整 */
        h1.text-center {
            margin-bottom: 0.3em;
            font-size: 50px;
            font-weight: bold;
            color: black;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
            max-width: 100%;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.2;
        }

        /* スマホ対応 */
        @media (max-width: 768px) {
            h1.text-center {
                font-size: 20px;
                /* スマホでは少し小さめに */
                max-width: 100%;
                word-break: break-word;
                text-shadow: none;
            }
        }

        /* iframeコンテナを中央配置 */
        .iframe-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            max-width: 1600px;
            width: 90%;
            margin: 2em auto;
        }

        /* iframe を囲むコンテナ */
        .iframe-container {
            position: relative;
            width: 100%;
            max-width: 1400px;
            height: 0;
            padding-top: 56.25%;
            box-shadow: 0 4px 12px 0 rgba(0, 0, 0, 0.3);
            overflow: hidden;
            border-radius: 8px;
            min-height: 600px;
            /* スマホで適切な高さを確保 */
        }

        /* スマホ用の高さ調整 */
        @media (max-width: 768px) {
            .iframe-container {
                padding-top: 100%;
                /* 画面比率をスマホ向けに調整 */
                height: 50%;
                min-height: 60vh;
                /* 画面の高さに合わせる */
            }

            .iframe-container iframe {
                width: 100%;
                height: 100%;
                min-height: 600px;
                object-fit: cover;
                /* iframe のコンテンツを上詰め */
                display: block;
            }
        }


        /* 前のページ・次のページのテキスト */
        .page-text {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            font-weight: bold;
            color: red;
            background: transparent;
            padding: 5px;
            border-radius: 5px;
            white-space: nowrap;
        }

        /* 左右のテキストを適切に配置 */
        .prev-text {
            left: -180px;
        }

        .next-text {
            right: -180px;
        }

        /* レスポンシブ調整 */
        @media (max-width: 1200px) {
            .prev-text {
                left: -150px;
            }

            .next-text {
                right: -150px;
            }
        }

        @media (max-width: 992px) {
            .prev-text {
                left: -120px;
            }

            .next-text {
                right: -120px;
            }
        }

        /* スマホのナビゲーションテキスト調整 */
        @media (max-width: 768px) {

            .prev-text,
            .next-text {
                position: absolute;
                text-align: center;
                font-size: 12px;
                top: auto;
                bottom: 20px;
            }

            .prev-text {
                left: 10px;
            }

            .next-text {
                right: 10px;
            }
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => { // JavaScriptの実行を遅延させてキャッシュの影響を減らす
                const videos = [{
                        title: "黒瀬公認会計士事務所",
                        src: "https://www.canva.com/design/DAGhZo_GWrg/hfSCwsydYaIJJwePclnYqw/view?embed&fit=cover"
                    },
                    {
                        title: "酒井公認会計士事務所",
                        src: "https://www.canva.com/design/DAGiJeDkHbQ/aUWAACq034TrI4VClz6LSg/view?embed"
                    }
                ];

                // 正しくシャッフルできているか確認
                console.log("シャッフル前:", JSON.stringify(videos));
                videos.sort(() => Math.random() - 0.5);
                console.log("シャッフル後:", JSON.stringify(videos));

                // `video-container` が正しく存在するか確認
                const container = document.getElementById("video-container");
                if (!container) {
                    console.error("video-container が見つかりません");
                    return;
                }

                // コンテナをクリアしてランダムに配置
                container.innerHTML = "";

                videos.forEach(video => {
                    const videoHtml = `
                    <h1 class="text-center">${video.title}</h1>
                    <div class="iframe-wrapper">
                        <div class="page-text prev-text">画像をクリックして前へ⏭️⏭️</div>
                        <div class="iframe-container">
                            <iframe loading="lazy"
                                style="position: absolute; width: 100%; height: 100%; min-height: 60vh; top: 0; left: 0; border: none; padding: 0; margin: 0; border-radius: 8px; background: white;"
                                src="${video.src}"
                                allowfullscreen="allowfullscreen" allow="fullscreen">
                            </iframe>
                        </div>
                        <div class="page-text next-text">⏪️⏪️画像をクリックして次へ</div>
                    </div>`;
                    container.innerHTML += videoHtml;
                });

            }, 300); // 300ms 遅延
        });
    </script>

    <div class="title-container" style="margin-top: 7em; background-color: white; padding: 5em; border-radius: 10px;">
        <!-- 左上にTaxBar® 特集ページを表示（レインボーグラデーション） -->
        <div
            style="margin-bottom: 0.3em; font-size: 50px; font-weight: bold;
        background-image: linear-gradient(90deg, #ff0000, #ff7f00, #ffff00, #00ff00, #0000ff, #4b0082, #8b00ff);
        background-size: 400% 400%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: rainbowAnimation 6s infinite linear;">
            TaxBar® 特集ページ
        </div>

        <!-- ランダム配置される動画 -->
        <div id="video-container"></div>

        <p class="text-center" style="margin-top: 0.5em; color: black; font-size: 20px; font-weight: bold;">
            特別なコンテンツをお楽しみください！
        </p>
    </div>


    {{-- <div class="title-container" style="margin-top: 7em; background-color: white; padding: 5em; border-radius: 10px;">
        <!-- 左上にTaxBar® 特集ページを表示（レインボーグラデーション） -->
        <div
            style="margin-bottom: 0.3em; font-size: 50px; font-weight: bold; 
        background-image: linear-gradient(90deg, #ff0000, #ff7f00, #ffff00, #00ff00, #0000ff, #4b0082, #8b00ff);
        background-size: 400% 400%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: rainbowAnimation 6s infinite linear;">
            TaxBar® 特集ページ
        </div>

        <!-- タイトル -->
        <h1 class="text-center">
            黒瀬公認会計士事務所
        </h1>

        <!-- iframeとナビゲーションのテキストを含むコンテナ -->
        <div class="iframe-wrapper">
            <div class="page-text prev-text">画像をクリックして前へ⏭️⏭️</div>

            <div class="iframe-container">
                <iframe loading="lazy"
                    style="position: absolute; width: 100%; height: 100%; min-height: 60vh; top: 0; left: 0; border: none; padding: 0; margin: 0; border-radius: 8px; background: white;"
                    src="https://www.canva.com/design/DAGhZo_GWrg/hfSCwsydYaIJJwePclnYqw/view?embed&fit=cover"
                    allowfullscreen="allowfullscreen" allow="fullscreen">
                </iframe>
            </div>

            <div class="page-text next-text">⏪️⏪️画像をクリックして次へ</div>
        </div>
        <!-- タイトル -->
        <h1 class="text-center">
            酒井公認会計士事務所
        </h1>

        <!-- iframeとナビゲーションのテキストを含むコンテナ -->
        <div class="iframe-wrapper">
            <div class="page-text prev-text">画像をクリックして前へ⏭️⏭️</div>

            <div class="iframe-container">
                <iframe loading="lazy"
                    style="position: absolute; width: 100%; height: 100%; min-height: 60vh; top: 0; left: 0; border: none; padding: 0; margin: 0; border-radius: 8px; background: white;"
                    src="https://www.canva.com/design/DAGiJeDkHbQ/aUWAACq034TrI4VClz6LSg/view?embed"
                    allowfullscreen="allowfullscreen" allow="fullscreen">
                </iframe>

            </div>

            <div class="page-text next-text">⏪️⏪️画像をクリックして次へ</div>
        </div>
        <p class="text-center" style="margin-top: 0.5em; color: black; font-size: 20px; font-weight: bold;">
            特別なコンテンツをお楽しみください！
        </p>
    </div> --}}
