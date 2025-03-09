@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">税理士その他の専門家 登録</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register.tax_expert.post') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- 税理士氏名 -->
                            <div class="form-group">
                                <label for="name">税理士等氏名</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>

                            <!-- 事務所名 (税理士法人名可) -->
                            <div class="form-group">
                                <label for="office_name">事務所名（税理士法人名可）</label>
                                <input type="text" class="form-control" name="office_name" required>
                            </div>

                            <!-- メールアドレス -->
                            <div class="form-group">
                                <label for="email">メールアドレス</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>

                            <!-- 郵便番号 -->
                            <div class="form-group">
                                <label for="postal_code">郵便番号</label>
                                <input type="text" class="form-control" name="postal_code" id="postal_code" required>
                            </div>

                            <!-- 都道府県 -->
                            <div class="form-group">
                                <label for="prefecture">都道府県</label>
                                <select class="form-control" name="prefecture" id="prefecture" required>
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
                            <div class="form-group">
                                <label for="address">住所</label>
                                <input type="text" class="form-control" name="address" id="address" required>
                            </div>

                            <!-- 事務所電話番号 -->
                            <div class="form-group">
                                <label for="office_phone">事務所電話番号</label>
                                <input type="text" class="form-control" name="office_phone" required>
                            </div>

                            <!-- 携帯電話番号 -->
                            <div class="form-group">
                                <label for="mobile_phone">携帯電話番号</label>
                                <input type="text" class="form-control" name="mobile_phone">
                            </div>

                            <!-- 税理士写真 -->
                            <div class="form-group">
                                <label for="tax_accountant_photo">税理士写真</label>
                                <input type="file" class="form-control" id="tax_accountant_photo"
                                    name="tax_accountant_photo" accept="image/*">
                                <img id="preview_tax_accountant_photo" src="#" alt="プレビュー"
                                    class="img-fluid mt-2 d-none border rounded" style="max-height: 200px;">
                            </div>

                            <!-- その他の写真 -->
                            <div class="form-group">
                                <label for="additional_photos">その他の写真</label>
                                <input type="file" class="form-control" id="additional_photos"
                                    name="additional_photos[]" accept="image/*" multiple>
                                <div id="preview_additional_photos" class="mt-2 d-flex flex-wrap border p-2 rounded">
                                </div>
                            </div>

                            <!-- パスワード -->
                            <div class="form-group mb-3">
                                <label for="password">パスワード</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <!-- パスワード確認 -->
                            <div class="form-group mb-3">
                                <label for="password_confirmation">パスワード（確認）</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>

                            <!-- 料金プランの選択 -->
                            <div class="form-group">
                                <label for="plan">選択するプラン</label>
                                <select class="form-control" id="plan" name="plan" required>
                                    @foreach (config('pricing.plans') as $key => $plan)
                                        <option value="{{ $key }}" data-price="{{ $plan['price'] }}">
                                            {{ $plan['name'] }}（{{ number_format($plan['price']) }}円）
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- 決済ボタン -->
                            <button id="payButton" class="btn btn-success w-100 mt-3">クレジットカードで支払う</button>

                            <!-- 登録ボタン（決済後の登録） -->
                            <button type="submit" class="btn btn-primary mt-3 w-100">登録</button>
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
        document.getElementById('postal_code').addEventListener('input', function() {
            const postalCode = this.value.replace(/[^0-9]/g, ''); // 数字以外を削除
            if (postalCode.length === 7) { // 郵便番号が7桁の場合
                fetch(`https://api.zipaddress.net/?zipcode=${postalCode}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.code === 200) {
                            document.getElementById('address').value = data.data.fullAddress; // 住所を自動入力
                            document.getElementById('prefecture').value = data.data.pref; // 都道府県を自動入力
                        } else {
                            console.error('API Error:', data.message);
                        }
                    })
                    .catch(error => console.error('Fetch Error:', error));
            }
        });
    </script>
@endsection
