@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">企業 登録</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register.company.post') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="company_name">会社名</label>
                                <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                                    name="company_name" value="{{ old('company_name') }}" required>
                                @error('company_name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="email">メールアドレス</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">パスワード</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="password_confirmation">パスワード（確認）</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="registration_number">法人番号（任意）</label>
                                <input type="text"
                                    class="form-control @error('registration_number') is-invalid @enderror"
                                    name="registration_number" value="{{ old('registration_number') }}">
                                @error('registration_number')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="address">企業所在地</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3" required>{{ old('address') }}</textarea>
                                @error('address')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="contact_info">連絡先情報（電話番号、担当者など）</label>
                                <textarea class="form-control @error('contact_info') is-invalid @enderror" name="contact_info" rows="3" required>{{ old('contact_info') }}</textarea>
                                @error('contact_info')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-danger mt-3 w-100">登録</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
