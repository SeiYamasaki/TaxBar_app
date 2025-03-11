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
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stripe = Stripe('{{ env('STRIPE_KEY') }}');

            // セッションIDを使用してチェックアウトページにリダイレクト
            stripe.redirectToCheckout({
                sessionId: '{{ $sessionId }}'
            }).then(function(result) {
                if (result.error) {
                    alert(result.error.message);
                }
            });

            // 手動でチェックアウトボタンも用意
            document.getElementById('checkout-button').addEventListener('click', function() {
                stripe.redirectToCheckout({
                    sessionId: '{{ $sessionId }}'
                }).then(function(result) {
                    if (result.error) {
                        alert(result.error.message);
                    }
                });
            });
        });
    </script>
</body>

</html>
