@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 pt-24">
        <div class="flex justify-center">
            <div class="w-full md:w-2/3 lg:w-1/2">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-100 px-6 py-4 border-b border-gray-200 font-semibold text-lg">税理士その他の専門家 登録</div>

                    <div class="p-6">
                        <form method="POST" action="{{ route('register.tax_expert.post') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- 税理士氏名 -->
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">税理士等氏名</label>
                                <input type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    name="name" required>
                            </div>

                            <!-- 事務所名 (税理士法人名可) -->
                            <div class="mb-4">
                                <label for="office_name"
                                    class="block text-gray-700 text-sm font-bold mb-2">事務所名（税理士法人名可）</label>
                                <input type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    name="office_name" required>
                            </div>

                            <!-- メールアドレス -->
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">メールアドレス</label>
                                <input type="email"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    name="email" required>
                            </div>

                            <!-- 郵便番号 -->
                            <div class="mb-4">
                                <label for="postal_code" class="block text-gray-700 text-sm font-bold mb-2">郵便番号</label>
                                <div class="flex">
                                    <input type="text"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        name="postal_code" id="postal_code" placeholder="例：1234567" maxlength="8" required>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">ハイフンなしで7桁の数字を入力してください</p>
                            </div>

                            <!-- 都道府県 -->
                            <div class="mb-4">
                                <label for="prefecture" class="block text-gray-700 text-sm font-bold mb-2">都道府県</label>
                                <select
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    name="prefecture" id="prefecture" required>
                                    <option value="">選択してください</option>
                                    <option value="北海道">北海道</option>
                                    <option value="青森県">青森県</option>
                                    <option value="岩手県">岩手県</option>
                                    <option value="宮城県">宮城県</option>
                                    <option value="秋田県">秋田県</option>
                                    <option value="山形県">山形県</option>
                                    <option value="福島県">福島県</option>
                                    <option value="東京都">東京都</option>
                                    <option value="神奈川県">神奈川県</option>
                                    <option value="埼玉県">埼玉県</option>
                                    <option value="千葉県">千葉県</option>
                                    <option value="茨城県">茨城県</option>
                                    <option value="栃木県">栃木県</option>
                                    <option value="群馬県">群馬県</option>
                                    <option value="新潟県">新潟県</option>
                                    <option value="富山県">富山県</option>
                                    <option value="石川県">石川県</option>
                                    <option value="福井県">福井県</option>
                                    <option value="山梨県">山梨県</option>
                                    <option value="長野県">長野県</option>
                                    <option value="岐阜県">岐阜県</option>
                                    <option value="静岡県">静岡県</option>
                                    <option value="愛知県">愛知県</option>
                                    <option value="三重県">三重県</option>
                                    <option value="滋賀県">滋賀県</option>
                                    <option value="京都府">京都府</option>
                                    <option value="大阪府">大阪府</option>
                                    <option value="兵庫県">兵庫県</option>
                                    <option value="奈良県">奈良県</option>
                                    <option value="和歌山県">和歌山県</option>
                                    <option value="鳥取県">鳥取県</option>
                                    <option value="島根県">島根県</option>
                                    <option value="岡山県">岡山県</option>
                                    <option value="広島県">広島県</option>
                                    <option value="山口県">山口県</option>
                                    <option value="徳島県">徳島県</option>
                                    <option value="香川県">香川県</option>
                                    <option value="愛媛県">愛媛県</option>
                                    <option value="高知県">高知県</option>
                                    <option value="福岡県">福岡県</option>
                                    <option value="佐賀県">佐賀県</option>
                                    <option value="長崎県">長崎県</option>
                                    <option value="熊本県">熊本県</option>
                                    <option value="大分県">大分県</option>
                                    <option value="宮崎県">宮崎県</option>
                                    <option value="鹿児島県">鹿児島県</option>
                                    <option value="沖縄県">沖縄県</option>
                                </select>
                            </div>

                            <!-- 住所 -->
                            <div class="mb-4">
                                <label for="address" class="block text-gray-700 text-sm font-bold mb-2">住所</label>
                                <input type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    name="address" id="address" required>
                            </div>

                            <!-- 事務所電話番号 -->
                            <div class="mb-4">
                                <label for="office_phone"
                                    class="block text-gray-700 text-sm font-bold mb-2">事務所電話番号</label>
                                <input type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    name="office_phone" required>
                            </div>

                            <!-- 携帯電話番号 -->
                            <div class="mb-4">
                                <label for="mobile_phone"
                                    class="block text-gray-700 text-sm font-bold mb-2">携帯電話番号</label>
                                <input type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    name="mobile_phone">
                            </div>

                            <!-- 税理士写真 -->
                            <div class="mb-4">
                                <label for="tax_accountant_photo"
                                    class="block text-gray-700 text-sm font-bold mb-2">税理士写真</label>
                                <input type="file"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    id="tax_accountant_photo" name="tax_accountant_photo" accept="image/*">
                                <img id="preview_tax_accountant_photo" src="#" alt="プレビュー"
                                    class="hidden mt-2 max-h-48 border rounded">
                            </div>

                            <!-- その他の写真 -->
                            <div class="mb-4">
                                <label for="additional_photos"
                                    class="block text-gray-700 text-sm font-bold mb-2">その他の写真</label>
                                <input type="file"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    id="additional_photos" name="additional_photos[]" accept="image/*" multiple>
                            </div>

                            <!-- パスワード -->
                            <div class="mb-4">
                                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">パスワード</label>
                                <input type="password"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                                    name="password" required>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1"><strong>{{ $message }}</strong></p>
                                @enderror
                            </div>

                            <!-- パスワード確認 -->
                            <div class="mb-6">
                                <label for="password_confirmation"
                                    class="block text-gray-700 text-sm font-bold mb-2">パスワード（確認）</label>
                                <input type="password"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    name="password_confirmation" required>
                            </div>

                            <!-- 禁止事項確認 -->
                            <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">利用規約及び禁止事項</h3>
                                <div
                                    class="text-sm text-gray-600 mb-4 max-h-80 overflow-y-auto p-3 border border-gray-200 rounded">
                                    <h4 class="font-bold mb-2">第1条（目的）</h4>
                                    <p class="mb-3">
                                        本規約は、TaxBar®が提供するオンラインプラットフォームにおいて、
                                        税理士およびその他の専門家と一般利用者が適切かつ円滑にサービスを利用できるようにすることを目的とします。
                                        本サービスを通じて、利用者は税務相談、専門家によるアドバイス、その他関連する情報を提供または取得することができます。
                                        また、サービスの公平性、公正性、信頼性を確保し、不正行為を防止することを目的とします。
                                    </p>

                                    <h4 class="font-bold mb-2">第2条（契約期間）</h4>
                                    <p class="mb-3">
                                        本サービスの契約期間は1年間とします。契約期間満了の30日前までに登録者から解約の申し出がない場合、
                                        自動的に1年間更新されるものとします。
                                    </p>

                                    <h4 class="font-bold mb-2">第3条（支払方法及び課金）</h4>
                                    <p class="mb-3">
                                        登録者は、サービス登録時にWEB決済を行い、月払いでの課金となります。
                                        当月分の料金は当月課金とし、支払い方法は、TaxBar®が指定する決済手段を利用するものとします。
                                        期限内に支払いが確認できない場合、サービスの利用を停止または契約を解除することがあります。
                                    </p>

                                    <h4 class="font-bold mb-2">第4条（適用範囲）</h4>
                                    <p class="mb-3">本規約は、TaxBar®を利用するすべての登録者、税理士その他の専門家、及び一般利用者に適用されます。</p>

                                    <h4 class="font-bold mb-2">第5条（登録及びアカウント管理）</h4>
                                    <p class="mb-3">
                                        登録者は、正確な情報を提供し、虚偽の情報を使用しないものとします。アカウント情報の管理は登録者の責任とし、不正使用があった場合は速やかにTaxBar®へ報告するものとします。
                                    </p>

                                    <h4 class="font-bold mb-2">第6条（なりすましの禁止）</h4>
                                    <p class="mb-3">
                                        一般利用者は、他人の名義を使用する、または別人になりすまして本サービスを利用することを禁止します。
                                        なりすまし行為が発覚した場合、直ちにアカウントを停止し、登録を抹消することがあります。
                                        また、なりすまし行為によって発生した損害について、
                                        TaxBar®は当該登録者に対し損害賠償請求を行うことができ、登録者はその支払い義務を負うものとします。
                                    </p>

                                    <h4 class="font-bold mb-2">第7条（途中退会）</h4>
                                    <p class="mb-3">
                                        登録者は、TaxBar®のサービスから途中退会することができます。
                                        退会を希望する場合、所定の手続きを行うものとします。
                                        ただし、退会時点で未払いの費用がある場合は、退会後もその支払い義務を負うものとします。
                                        また、途中退会に伴う日割り返金は行いません。
                                    </p>

                                    <h4 class="font-bold mb-2">第8条（準拠法及び合意管轄）</h4>
                                    <p class="mb-3">
                                        本規約は日本法を準拠法とし、本規約及び本サービスに関する一切の紛争については、
                                        東京地方裁判所又は東京簡易裁判所を第一審の専属的合意管轄裁判所とします。
                                    </p>

                                    <h4 class="font-bold mb-2">第9条（イエローカード制）</h4>
                                    <p class="mb-3">
                                        TaxBar®は、利用規約及び禁止事項に違反した者に対し、
                                        イエローカードを提示することができる。
                                        イエローカードが2枚提示された者は登録を抹消され、
                                        レッドカードが1枚提示された者は即時に登録を抹消されるものとする。
                                    </p>
                                </div>
                                <div class="flex items-start mt-4">
                                    <div class="flex items-center h-5">
                                        <input id="terms_agree" name="terms_agree" type="checkbox" required
                                            class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300">
                                    </div>
                                    <label for="terms_agree" class="ml-2 text-sm font-medium text-gray-700">
                                        上記の利用規約及び禁止事項を理解し、遵守することに同意します。
                                    </label>
                                </div>
                            </div>

                            <!-- 登録ボタン -->
                            <button type="submit"
                                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors duration-300 mt-4">
                                登録
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/form-preview.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 禁止事項チェックボックスと登録ボタンの連動
            const termsAgree = document.getElementById('terms_agree');
            const submitButton = document.querySelector('button[type="submit"]');

            // チェックボックスの状態を確認し、ボタンの有効/無効を切り替える関数
            function updateSubmitButton() {
                if (termsAgree.checked) {
                    submitButton.disabled = false;
                    submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    submitButton.classList.add('hover:bg-blue-600');
                } else {
                    submitButton.disabled = true;
                    submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                    submitButton.classList.remove('hover:bg-blue-600');
                }
            }

            // 初期状態ではボタンを無効化
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            submitButton.classList.remove('hover:bg-blue-600');

            // チェックボックスの変更を監視
            termsAgree.addEventListener('change', updateSubmitButton);

            // 画像プレビュー機能
            document.getElementById('tax_accountant_photo').addEventListener('change', function(e) {
                const preview = document.getElementById('preview_tax_accountant_photo');
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                    }
                    reader.readAsDataURL(this.files[0]);
                } else {
                    preview.classList.add('hidden');
                }
            });

            // 複数画像プレビュー
            document.getElementById('additional_photos').addEventListener('change', function(e) {
                const preview = document.getElementById('preview_additional_photos');
                preview.innerHTML = '';
                if (this.files) {
                    Array.from(this.files).forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.classList.add('max-h-32', 'm-1', 'border', 'rounded');
                            preview.appendChild(img);
                        }
                        reader.readAsDataURL(file);
                    });
                }
            });
        });
    </script>
@endsection
