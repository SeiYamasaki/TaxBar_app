@extends('layouts.faq')

@section('content')
    <div class="faq-header">
        <h1 class="faq-title">📌 TaxBar&regFAQ</h1>
        <p class="faq-subtitle">TaxBar&regに寄せられた質問を記載しています｡</p>
    </div>

    <!-- 検索フォーム -->
    <div class="search-container">
        <form method="GET" action="{{ route('faqs.index') }}" class="search-form">
            <input type="text" name="search" class="search-input" placeholder="🔍 キーワードで検索"
                value="{{ request('search') }}">
            <button type="submit" class="search-button">検索</button>
        </form>
    </div>

    <!-- FAQリスト -->
    <div class="faq-list">
        @forelse ($faqs as $index => $faq)
            <div class="faq-card {{ $index % 2 == 0 ? 'question-row' : 'answer-row' }}">
                <h5 class="faq-question">{{ $faq->question }}</h5>
                <p class="faq-answer">{{ $faq->answer }}</p>
            </div>
        @empty
            <div class="faq-no-result">
                🚫 検索結果が見つかりませんでした。
            </div>
        @endforelse
    </div>

    <!-- ページネーション -->
    <div class="pagination-container">
        {{ $faqs->links() }}
    </div>

    <style>
        /* FAQ全体 */
        .faq-list {
            text-align: left;
            /* ✅ 左寄せ */
        }

        /* FAQ項目のカード */
        .faq-card {
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
            transition: 0.3s;
            text-align: left;
            /* ✅ 左寄せ */
        }

        .faq-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        /* 質問の背景色（淡い緑） */
        .question-row {
            background: #d4f8e8;
        }

        /* 回答の背景色（淡い青） */
        .answer-row {
            background: #e3f2fd;
        }

        /* 質問のスタイル */
        .faq-question {
            font-size: 1.2rem;
            font-weight: bold;
            color: #2c786c;
            margin-bottom: 5px;
        }

        /* 回答のスタイル */
        .faq-answer {
            color: #333;
            font-size: 1rem;
        }

        /* 検索フォームの左寄せ */
        .search-container {
            text-align: left;
            /* ✅ 左寄せ */
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        /* 検索ボックス */
        .search-form {
            display: flex;
            background: white;
            border-radius: 25px;
            padding: 5px 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
        }

        .search-input {
            border: none;
            padding: 10px;
            flex: 1;
            border-radius: 20px;
            outline: none;
        }

        .search-button {
            background: blue;
            border: none;
            padding: 10px 15px;
            border-radius: 20px;
            color: white;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .search-button:hover {
            background: #ff4f7b;
        }

        /* ページネーション */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
@endsection
