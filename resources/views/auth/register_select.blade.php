@extends('layouts.app')

@section('body-class', 'register-page') <!-- ✅ ここで特定のクラスを適用 -->

@section('page-specific-styles')
    <style>
        main {
            display: block !important;
            height: auto !important;
            padding-top: 300px !important;
            /* ✅ PCで確実に余白を取る */
            padding-bottom: 500px !important;
        }

        /* スマホの余白はそのまま */
        @media (max-width: 768px) {
            main {
                padding-top: 160px !important;
            }
        }

        body {
            overflow: auto !important;
        }

        /* `.container` に `margin-top` を追加 */
        .container {
            margin-top: 0px !important;
            
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let headerHeight = document.querySelector('header').offsetHeight;
            document.querySelector('main').style.paddingTop = (headerHeight + 60) + "px"; // ✅ 余裕を持たせる
        });
    </script>

@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h2 class="text-center mb-4 text-white text-3xl">アカウント登録の選択</h2>
                <p class="text-center text-white mb-5">登録するアカウントの種類を選択してください。</p>

                <div class="row">
                    <!-- 税理士その他の専門家 (緑) -->
                    <div class="col-md-4">
                        <div class="card shadow-lg border-0">
                            <div class="card-header bg-success text-white text-center">
                                <h4><i class="fas fa-user-tie"></i> 税理士･専門家(有料)</h4>
                            </div>
                            <div class="card-body text-center">
                                <p class="text-muted">会計士･税理士その他の専門家の登録</p>
                                <a href="{{ route('register.tax_expert') }}" class="btn btn-success btn-lg w-100">
                                    登録する
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- 企業 (赤) -->
                    <div class="col-md-4">
                        <div class="card shadow-lg border-0">
                            <div class="card-header bg-danger text-white text-center">
                                <h4><i class="fas fa-building"></i> 企業(無料)</h4>
                            </div>
                            <div class="card-body text-center">
                                <p class="text-muted">法人事業者向けの登録です。</p>
                                <a href="{{ route('register.company') }}" class="btn btn-danger btn-lg w-100">
                                    登録する
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- 個人 (青のまま) -->
                    <div class="col-md-4">
                        <div class="card shadow-lg border-0">
                            <div class="card-header bg-primary text-white text-center">
                                <h4><i class="fas fa-user"></i> 個人(無料)</h4>
                            </div>
                            <div class="card-body text-center">
                                <p class="text-muted">個人の方向けの登録です。</p>
                                <a href="{{ route('register.individual') }}" class="btn btn-primary btn-lg w-100">
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
