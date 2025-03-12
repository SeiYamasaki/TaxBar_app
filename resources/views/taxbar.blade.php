<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar® | TaxBar®とは？</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- A-Frameライブラリ -->
    <script src="https://aframe.io/releases/1.4.0/aframe.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/aframevr/aframe-extras@6.1.1/dist/aframe-extras.min.js"></script>

    <style>
        /* ✅ ヘッダーのスタイル */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 90px;
            background-color: white;
            z-index: 1000;
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        header .logo {
            font-size: 20px;
            /* ロゴのフォントサイズを調整 */
            font-weight: bold;
            margin-right: auto;
            /* ロゴを完全に左寄せ */
        }

        header nav {
            font-size: 14px;
            /* ナビゲーションのフォントサイズを調整 */
        }

        header .nav-items {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            overflow: auto;
            /* スクロール可能にする */
        }

        .info {
            position: absolute !important;
            top: 120px !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            background: rgba(0, 0, 0, 0.7) !important;
            color: white !important;
            padding: 10px 20px !important;
            border-radius: 5px !important;
            font-size: 16px !important;
        }

        .info2 {
            position: absolute !important;
            top: 200px !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            background: rgba(0, 0, 0, 0.7) !important;
            color: white !important;
            padding: 10px 20px !important;
            border-radius: 5px !important;
            font-size: 16px !important;
        }

        /* A-Frameシーンが画面いっぱいに広がるように */
        a-scene {
            width: 100%;
            height: 100%;
            display: block;
            /* 確実にブロック要素として表示 */
        }

        main {
            flex-grow: 1;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
            /* スクロール可能にするために方向を縦に */
        }

        /* フッターが常に画面下部に表示されるように */
        footer {
            margin-top: auto;
            /* フッターが下に表示されるように */
        }
    </style>
</head>

<body>

    <!-- ヘッダーをインクルード -->
    @include('components.header')

    <div class="info">TaxBar®入口エントランス</div>
    <div class="info2">黒◯をドアに中央に合わせてクリックして入店してください</div>

    <a-scene shadow="type: pcfsoft">
        <!-- 🌟 環境光（全体の明るさをUP） -->
        <a-light type="ambient" color="#EEE" intensity="0.8"></a-light>

        <!-- 💡 スポットライト（観葉植物を照らす） -->
        <a-light type="spot" position="0 3 2" intensity="1.5" angle="40" penumbra="0.5" color="white"></a-light>

        <!-- 🎨 床（豪華なカーペット追加） -->
        <a-plane position="0 0 0" rotation="-90 0 0" width="12" height="10" color="#D3D3D3"
            receiveShadow="true"></a-plane>
        <a-plane position="0 0.01 -2" rotation="-90 0 0" width="4" height="3" color="#B22222"></a-plane>

        <!-- 🏠 壁（少し色をつける） -->
        <a-box position="0 1.5 -5" width="10" height="3" depth="0.1" color="#FFDAB9"
            receiveShadow="true"></a-box>

        <!-- 🚪 ドア（中央に配置） -->
        <a-box id="door" position="0 1 -5" width="2" height="4" depth="0.1" color="brown"
            castShadow="true" onclick="window.location.href='{{ route('taxbar-introduction') }}';"></a-box>

        <!-- 🚪 ドアノブ（黒い球） -->
        <a-sphere position="0.8 1.5 -4.10" radius="0.05" color="black" castShadow="true"></a-sphere>

        <!-- 🏷 TaxBar® のロゴ画像 -->
        <a-image src="/images/logotoumei.png" position="-3.5 1.6 -4.9" width="3" height="3"></a-image>

        <!-- 📚 本棚 -->
        <a-box position="2 1.5 -3" width="1.5" height="2.5" depth="0.5" color="saddlebrown"
            receiveShadow="true"></a-box>

        <!-- 🪑 応接ソファー -->
        <a-box position="-2.5 0.6 -1.5" width="2" height="1.2" depth="1" color="darkgray"
            castShadow="true"></a-box>
        <a-box position="2.5 0.6 -1.5" width="2" height="1.2" depth="1" color="darkgray"
            castShadow="true"></a-box>

        <a-entity
            gltf-model="https://cdn.jsdelivr.net/gh/KhronosGroup/glTF-Sample-Models/2.0/SheenChair/glTF-Binary/SheenChair.glb"
            position="3 0 -2" scale="1.2 1.2 1.2" rotation="0 -90 0">
        </a-entity>

        <!-- 🚶‍♂️ プレイヤー（カメラ + 固定視点 & マウス操作） -->
        <a-entity id="player" position="0 1 2">
            <a-camera fov="90" wasd-controls="enabled:false" look-controls>
                <a-cursor></a-cursor>
            </a-camera>
        </a-entity>

    </a-scene>

</body>

</html>
