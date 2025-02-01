@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">企業 登録</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <label for="company_name">会社名</label>
                                <input type="text" class="form-control" name="company_name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">メールアドレス</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">パスワード</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-success mt-3">登録</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
