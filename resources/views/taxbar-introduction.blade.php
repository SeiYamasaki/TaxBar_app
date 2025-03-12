@extends('layouts.app')

@section('title', 'TaxBar®紹介ページ')

@section('content')
    <!-- ここでヘッダーとフッターは自動的に引き継がれます -->

    <div class="container">
        <h1>ようこそ、TaxBar®紹介ページへ！</h1>
        <p>こちらは、TaxBar®のサービスを紹介するページです。</p>
        <p>以下の動画で、TaxBar®のサービス内容や提供する支援についてご覧いただけます。</p>

        <!-- 動画埋め込み -->
        <div class="video-container">
            <video width="100%" controls>
                <source src="{{ asset('videos/taxbar_introduction_v1.mp4') }}" type="video/mp4">
            </video>
        </div>
    </div>

@endsection
