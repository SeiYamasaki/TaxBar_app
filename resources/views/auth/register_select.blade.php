@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h2 class="text-center mb-4">アカウント登録の選択</h2>
                <p class="text-center text-muted mb-5">登録するアカウントの種類を選択してください。</p>

                <div class="row">
                    <!-- 税理士その他の専門家 -->
                    <div class="col-md-4">
                        <div class="card shadow-lg border-0">
                            <div class="card-header bg-primary text-white text-center">
                                <h4><i class="fas fa-user-tie"></i> 税理士その他の専門家</h4>
                            </div>
                            <div class="card-body text-center">
                                <p class="text-muted">税理士、会計士、社労士などの専門家向けの登録です。</p>
                                <a href="{{ route('register.tax_expert') }}" class="btn btn-primary btn-lg w-100">
                                    登録する
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- 企業 -->
                    <div class="col-md-4">
                        <div class="card shadow-lg border-0">
                            <div class="card-header bg-success text-white text-center">
                                <h4><i class="fas fa-building"></i> 企業</h4>
                            </div>
                            <div class="card-body text-center">
                                <p class="text-muted">法人または事業者向けの登録です。</p>
                                <a href="{{ route('register.company') }}" class="btn btn-success btn-lg w-100">
                                    登録する
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- 個人 -->
                    <div class="col-md-4">
                        <div class="card shadow-lg border-0">
                            <div class="card-header bg-info text-white text-center">
                                <h4><i class="fas fa-user"></i> 個人</h4>
                            </div>
                            <div class="card-body text-center">
                                <p class="text-muted">個人の方向けの登録です。</p>
                                <a href="{{ route('register.individual') }}" class="btn btn-info btn-lg w-100">
                                    登録する
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
