@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 pt-24">
        <div class="flex justify-center">
            <div class="w-full md:w-2/3 lg:w-1/2">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-100 px-6 py-4 border-b border-gray-200 font-semibold text-lg">{{ __('個人ユーザー登録') }}
                    </div>

                    <div class="p-6">
                        <form method="POST" action="{{ route('register.individual.post') }}">
                            @csrf

                            <!-- Name -->
                            <div class="mb-4">
                                <label for="name"
                                    class="block text-gray-700 text-sm font-bold mb-2">{{ __('氏名(ニックネーム可)') }}</label>
                                <input id="name" type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                                    name="name" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1"><strong>{{ $message }}</strong></p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email"
                                    class="block text-gray-700 text-sm font-bold mb-2">{{ __('メールアドレス') }}</label>
                                <input id="email" type="email"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                                    name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1"><strong>{{ $message }}</strong></p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password"
                                    class="block text-gray-700 text-sm font-bold mb-2">{{ __('パスワード') }}</label>
                                <input id="password" type="password"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                                    name="password" required>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1"><strong>{{ $message }}</strong></p>
                                @enderror
                            </div>

                            <!-- Password Confirmation -->
                            <div class="mb-4">
                                <label for="password_confirmation"
                                    class="block text-gray-700 text-sm font-bold mb-2">{{ __('パスワード（確認）') }}</label>
                                <input id="password_confirmation" type="password"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    name="password_confirmation" required>
                            </div>

                            <!-- Date of Birth -->
                            <div class="mb-4">
                                <label for="date_of_birth"
                                    class="block text-gray-700 text-sm font-bold mb-2">{{ __('生年月日') }}</label>
                                <input id="date_of_birth" type="date"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('date_of_birth') border-red-500 @enderror"
                                    name="date_of_birth" value="{{ old('date_of_birth') }}">
                                @error('date_of_birth')
                                    <p class="text-red-500 text-xs mt-1"><strong>{{ $message }}</strong></p>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div class="mb-4">
                                <label for="gender"
                                    class="block text-gray-700 text-sm font-bold mb-2">{{ __('性別') }}</label>
                                <select id="gender"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('gender') border-red-500 @enderror"
                                    name="gender">
                                    <option value="">選択してください</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>男性</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>女性</option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>その他</option>
                                </select>
                                @error('gender')
                                    <p class="text-red-500 text-xs mt-1"><strong>{{ $message }}</strong></p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="mb-4">
                                <label for="address"
                                    class="block text-gray-700 text-sm font-bold mb-2">{{ __('住所（居住地）') }}</label>
                                <textarea id="address"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('address') border-red-500 @enderror"
                                    name="address" rows="3">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="text-red-500 text-xs mt-1"><strong>{{ $message }}</strong></p>
                                @enderror
                            </div>

                            <!-- Contact Info -->
                            <div class="mb-6">
                                <label for="contact_info"
                                    class="block text-gray-700 text-sm font-bold mb-2">{{ __('連絡先情報（電話番号など）') }}</label>
                                <textarea id="contact_info"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('contact_info') border-red-500 @enderror"
                                    name="contact_info" rows="3">{{ old('contact_info') }}</textarea>
                                @error('contact_info')
                                    <p class="text-red-500 text-xs mt-1"><strong>{{ $message }}</strong></p>
                                @enderror
                            </div>

                            <!-- 禁止事項確認 -->
                            <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">利用規約及び禁止事項</h3>
                                <div
                                    class="bg-white text-sm text-gray-600 mb-4 max-h-80 overflow-y-auto p-3 border border-gray-200 rounded">
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

                            <!-- Submit Button -->
                            <div class="mb-0">
                                <button type="submit" id="submit-btn"
                                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors duration-300">
                                    {{ __('登録') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 禁止事項チェックボックスと登録ボタンの連動
            const termsAgree = document.getElementById('terms_agree');
            const submitButton = document.getElementById('submit-btn');

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
        });
    </script>
@endsection
