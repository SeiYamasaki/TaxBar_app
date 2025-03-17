@extends('layouts.app')

@section('body-class', 'bg-gradient-to-br from-blue-500 to-blue-900')

@section('content')
    <div class="flex justify-center items-center h-screen mt-20"> {{-- ✅ ヘッダーとの距離を微調整 --}}
        <div class="w-[500px] h-[500px] bg-white rounded-lg shadow-lg p-8 flex flex-col justify-center items-center custom-form">
            
            <!-- ✅ ロゴサイズを少し縮小 -->
            <div class="mb-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-40 w-auto custom-logo">
            </div>

            <!-- ✅ タイトル -->
            <h1 class="text-xl font-bold text-yellow-600 mb-3 text-center">🔑 ログイン</h1>

            <!-- ✅ フォーム -->
            <form method="POST" action="{{ route('login') }}" class="w-full flex flex-col items-center">
                @csrf

                <!-- ✅ フォーム入力欄の幅を調整 -->
                <div class="mb-3 w-4/5 custom-input">
                    <label for="email" class="block text-gray-800 text-sm font-semibold mb-1">📧 メールアドレス</label>
                    <input type="email" name="email" id="email"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-yellow-400 text-sm bg-white"
                        placeholder="example@mail.com" required>
                </div>

                <div class="mb-3 w-4/5 custom-input">
                    <label for="password" class="block text-gray-800 text-sm font-semibold mb-1">🔒 パスワード</label>
                    <input type="password" name="password" id="password"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-yellow-400 text-sm bg-white"
                        placeholder="********" required>
                </div>

                <div class="mb-3 flex justify-between items-center w-4/5 custom-input">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="mr-2">
                        <span class="text-gray-800 text-sm">記憶する</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-yellow-600 text-sm hover:underline">パスワードを忘れた?</a>
                </div>

                <!-- ✅ ボタンの幅を微調整 -->
                <button type="submit"
                    class="w-1/2 bg-blue-500 text-white text-xs font-bold py-1 px-4 h-10 rounded hover:bg-blue-600 transition custom-button">
                    🚀 ログイン
                </button>
            </form>

            <!-- ✅ 登録リンク -->
            <p class="text-center text-gray-800 text-sm mt-3">
                アカウントをお持ちでないですか？
                <a href="{{ route('register.select') }}" class="text-yellow-600 hover:underline">登録する</a>
            </p>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* ✅ スマホだけ適用 */
    @media (max-width: 768px) {
        .custom-form {
            max-width: 90% !important;
            height: auto !important;
            padding: 1.5rem !important;
        }

        .custom-logo {
            height: 7rem !important; /* スマホのロゴを小さく */
        }

        .custom-input {
            max-width: 95% !important; /* フォームの横幅を調整 */
        }

        .custom-button {
            width: 8rem !important; /* ボタンを小さく */
        }
    }
</style>
@endpush
