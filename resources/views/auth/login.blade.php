@extends('layouts.app')

@section('content')
    {{-- <div class="max-w-md mx-auto bg-white p-8 border border-gray-300 rounded-lg shadow-md"> --}}
        <div
        class="bg-white border border-gray-300 rounded-lg shadow-md w-3/4 max-w-3xl h-128 flex flex-col justify-center items-center p-8">

        <!-- ✅ ロゴ画像 -->
        <div class="flex justify-center mb-5">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-40 w-auto">
        </div>

        <!-- ✅ ゴールド系のタイトル -->
        <h1 class="text-2xl font-bold text-center text-yellow-600 mb-6">🔑 ログイン</h1>

        <!-- エラーメッセージ表示 -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4 w-full">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>🚫 {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- ✅ フォーム全体の幅を親要素に合わせる -->
        <form method="POST" action="{{ route('login') }}" class="w-full max-w-lg">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-800 font-semibold mb-2">📧 メールアドレス</label>
                <input type="email" name="email" id="email"
                    class="w-full px-4 py-2 border rounded focus:ring focus:ring-yellow-400" placeholder="example@mail.com"
                    required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-800 font-semibold mb-2">🔒 パスワード</label>
                <input type="password" name="password" id="password"
                    class="w-full px-4 py-2 border rounded focus:ring focus:ring-yellow-400" placeholder="********"
                    required>
            </div>

            <div class="mb-4 flex justify-between items-center">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-2">
                    <span class="text-gray-800">ログインを記憶する</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-yellow-600 hover:underline">パスワードを忘れた?</a>
            </div>

            <button type="submit"
                class="w-full bg-blue-500 text-white text-sm py-1 px-2 rounded hover:bg-blue-600 transition">
                🚀 ログイン
            </button>


        </form>

        <!-- ✅ 登録リンク -->
        <p class="text-center text-gray-800 mt-4">
            アカウントをお持ちでないですか？
            <a href="{{ route('register') }}" class="text-yellow-600 hover:underline">登録する</a>
        </p>
        </div>


    @endsection
