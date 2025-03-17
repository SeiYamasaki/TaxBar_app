<!-- 決済確認モーダル -->
<div id="payment-confirmation-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <!-- ぼかしオーバーレイ (固定位置) -->
    <div class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-md"></div>

    <!-- モーダルコンテンツ -->
    <div class="relative z-10 max-h-screen w-full max-w-md px-4 py-4">
        <div class="bg-white rounded-lg shadow-xl w-full overflow-hidden flex flex-col max-h-[90vh]">
            <div class="bg-gray-800 text-white p-4 flex justify-between items-center">
                <h2 class="text-xl font-bold">決済確認</h2>
                <button type="button" id="close-payment-modal" class="text-white hover:text-gray-300 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-6">
                <p class="text-gray-700 mb-4">以下の内容で決済を行います。よろしいですか？</p>

                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <div class="mb-2">
                        <span class="font-semibold">プラン名:</span>
                        <span id="modal-plan-name"></span>
                    </div>
                    <div>
                        <span class="font-semibold">料金:</span>
                        <span id="modal-plan-price"></span>
                    </div>
                </div>

                <div class="flex justify-between">
                    <button type="button" id="cancel-payment-btn"
                        class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg">
                        キャンセル
                    </button>
                    <button type="button" id="confirm-payment-btn"
                        class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg">
                        決済する
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
