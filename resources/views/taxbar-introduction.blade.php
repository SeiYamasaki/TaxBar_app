<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar®紹介ページ</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* 画面全体の基本設定 */
        body,
        html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }

        /* 動画エリアの設定 */
        .video-container {
            width: 100vw;
            height: 100vh;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            background-color: black;
        }

        .video-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* アニメーション付きテキスト */
        .video-text {
            position: absolute;
            color: white;
            font-size: 6rem;
            font-weight: bold;
            text-align: center;
            text-shadow: 6px 6px 25px rgba(255, 255, 255, 0.9);
            opacity: 0;
            transform: translateY(50px) scale(0.8);
            animation: fadeInUp 3s ease-out forwards, shine 4s infinite alternate;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(50px) scale(0.8);
            }

            50% {
                opacity: 0.7;
                transform: translateY(10px) scale(1.1);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1.2);
            }
        }

        @keyframes shine {
            0% {
                text-shadow: 6px 6px 25px rgba(255, 255, 255, 0.9);
            }

            100% {
                text-shadow: 10px 10px 40px rgba(255, 255, 255, 1);
            }
        }

        /* メッセージボックス */
        .message-box {
            width: 100%;
            max-width: 1200px;
            background: white;
            border-radius: 15px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
            padding: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
            margin: -250px auto 30px auto;
            opacity: 0;
            transform: translateY(15px);
            animation: fadeInMessage 2s ease-out 2.5s forwards;
        }

        /* ロゴ */
        .message-box img {
            width: 150px;
            height: 150px;
        }

        /* メッセージテキスト */
        .message-text {
            font-size: 1.8rem;
            color: #333;
            font-weight: bold;
        }

        /* メッセージボックスのフェードイン */
        @keyframes fadeInMessage {
            0% {
                opacity: 0;
                transform: translateY(15px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* 紹介文コンテンツ */
        .content {
            width: 80%;
            max-width: 1600px;
            text-align: center;
            font-size: 1.6rem;
            color: #444;
            margin: 80px auto;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInContent 2s ease-out 3s forwards;
        }

        /* 紹介文フェードイン */
        @keyframes fadeInContent {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* スマホ対応 */
        @media (max-width: 768px) {
            .video-text {
                font-size: 1.5rem;
                /* スマホで見やすいサイズ */
                width: 90%;
                /* 横幅を調整 */
                line-height: 1.2;
                /* 行間を調整 */
                padding: 0 10px;
                /* 端の余白を確保 */
            }

            .message-box {
                flex-direction: column;
                text-align: center;
                padding: 20px;
            }

            .message-box img {
                width: 100px;
                height: 100px;
            }

            .message-text {
                font-size: 1.5rem;
            }

            .content {
                font-size: 1.4rem;
                width: 90%;
            }
        }
    </style>
</head>

<body>

    <!-- ヘッダー -->
    @include('components.header')

    <main>
        <!-- 動画埋め込み（自動再生） -->
        <div class="video-container">
            <video autoplay muted loop playsinline>
                <source src="{{ asset('videos/bar_7.mov') }}" type="video/mp4">
                お使いのブラウザは動画タグをサポートしていません。
            </video>
            <!-- アニメーション付きテキスト -->
            <div class="video-text">TaxBar®へようこそ！</div>
        </div>

        <!-- ロゴ入りメッセージボックス -->
        <div class="message-box">
            <img src="{{ asset('images/logo.png') }}" alt="TaxBar ロゴ">
            <div class="message-text">
                TaxBar®は、税理士による新しいオンライン相談プラットフォームです。
            </div>
        </div>
        <!-- 紹介文コンテンツ -->
        <div class="content">
            <p>
                TaxBar®では、全国の日本の公認会計士や税理士がオンラインで税務相談を提供します。<br>
                これまでの対面相談の手間を省き、どこからでも気軽に公認会計士や税理士と対面が可能です｡<br>
                実際の飲食店ではないですが､お酒を飲みながらでも参加いただくことを可能としています｡<br>
            </p>
            <p>
                企業や個人事業者、日本の国民の皆様(以下､｢一般ユーザー｣といいます｡)は無料で
                <a href="/register/select" style="color: blue; text-decoration: underline;">登録</a>いただけます｡<br>
                将来的はグローバル化し､世界中の方も一般ユーザーとなる予定となっております｡<br>
                但し､<a href="/view/prohibited" style="color: red; text-decoration: underline;">禁止事項</a>がありますのでメニューから
                ｢<a href="/view/prohibited" style="color: red; text-decoration: underline;">禁止事項</a>｣を御覧いただいた上で
                しっかりルールを守って参加いただくようお願いいたします｡<br>
                ルールに違反すると､TaxBar®は出入禁止(登録抹消)となりますので予めご承知おきください｡<br>
                当面の間､一般ユーザーは無料としますが､近い将来､課金にすることが決定しております｡<br>
                入店ご希望の一般ユーザー様は､メニューの
                <a href="/register/select" style="color: blue; text-decoration: underline;">登録</a>フォームよりいますぐご登録ください｡<br>
                企業経営者・個人事業主・フリーランスの皆様におかれましては､<br>
                ｢税理士を変えたい｣｢税理士を付けたい｣など､大歓迎です｡<br>
                実績豊富な税理士による高品質なサービスを受けれるかもしれません｡<br>
            </p>
            <p>
                実際にTaxBar®に入店して､あなたに最適な税理士を見つけましょう！
            </p>
        </div>


    </main>

    <!-- フッター -->
    @include('components.footer')

</body>

</html>
