<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お支払い処理中 - TaxBar</title>
    <script src="https://js.stripe.com/v3/"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="text-center p-8 bg-white rounded-lg shadow-lg max-w-md">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500 mx-auto mb-4"></div>
        <h1 class="text-2xl font-bold text-gray-800 mb-4">決済処理中...</h1>
        <p class="text-gray-600 mb-6">決済ページに移動しています。しばらくお待ちください。</p>
        <div class="text-sm text-gray-500">ページが自動的に切り替わらない場合は、<button id="checkout-button"
                class="text-blue-500 underline">こちら</button>をクリックしてください。</div>

        <div id="debug-info" class="mt-6 p-4 bg-gray-100 rounded text-left text-xs text-gray-500" style="display:none;">
            <h3 class="font-bold mb-2">デバッグ情報：</h3>
            <p>Session ID: <span id="debug-session-id">{{ $sessionId }}</span></p>
            <p>Stripe Key: <span id="debug-stripe-key">{{ config('services.stripe.key', env('STRIPE_KEY')) }}</span></p>
            <p>Environment: <span>{{ app()->environment() }}</span></p>
            <p id="debug-log"></p>
            <div class="mt-2">
                <button id="show-debug" class="px-2 py-1 bg-gray-200 rounded">デバッグ情報を表示</button>
            </div>
        </div>
    </div>

    <script>
        // デバッグ情報の表示切り替え
        document.getElementById('show-debug').addEventListener('click', function() {
            const debugInfo = document.getElementById('debug-info');
            debugInfo.style.display = 'block';
        });

        // コンソールログをデバッグ情報エリアにも表示する関数
        function debugLog(message) {
            console.log(message);
            const logElement = document.getElementById('debug-log');
            logElement.innerHTML += message + '<br>';
        }

        debugLog('決済ページロード開始');
        document.addEventListener('DOMContentLoaded', function() {
            try {
                // Stripeキーの取得
                const stripeKey = '{{ config('services.stripe.key', env('STRIPE_KEY')) }}';
                debugLog('Stripeキー長さ: ' + stripeKey.length + ' 文字');

                if (!stripeKey || stripeKey.length < 10) {
                    throw new Error('Stripeキーが正しく設定されていません');
                }

                const stripe = Stripe(stripeKey);
                const sessionId = '{{ $sessionId }}';
                debugLog('セッションID: ' + sessionId);

                // セッションIDを使用してチェックアウトページにリダイレクト
                debugLog('チェックアウトページへのリダイレクト開始');
                stripe.redirectToCheckout({
                    sessionId: sessionId
                }).then(function(result) {
                    if (result.error) {
                        debugLog('リダイレクトエラー: ' + result.error.message);
                        alert(result.error.message);
                        // エラー発生時にデバッグ情報を表示
                        document.getElementById('debug-info').style.display = 'block';
                    }
                }).catch(function(error) {
                    debugLog('予期しないエラー: ' + error.message);
                    // エラー発生時にデバッグ情報を表示
                    document.getElementById('debug-info').style.display = 'block';
                });

                // 手動でチェックアウトボタンも用意
                document.getElementById('checkout-button').addEventListener('click', function() {
                    debugLog('チェックアウトボタンクリック');
                    stripe.redirectToCheckout({
                        sessionId: sessionId
                    }).then(function(result) {
                        if (result.error) {
                            debugLog('リダイレクトエラー: ' + result.error.message);
                            alert(result.error.message);
                        }
                    }).catch(function(error) {
                        debugLog('予期しないエラー: ' + error.message);
                    });
                });
            } catch (error) {
                debugLog('決済処理中にエラーが発生しました: ' + error.message);
                console.error('決済処理中にエラーが発生しました:', error);

                // エラー発生時にデバッグ情報を表示
                document.getElementById('debug-info').style.display = 'block';

                alert('決済処理中にエラーが発生しました。しばらくお待ちください。');
            }
        });
    </script>
</body>

</html>
