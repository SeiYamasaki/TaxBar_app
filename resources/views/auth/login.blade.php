@extends('layouts.app')

@section('body-class', 'bg-gradient-to-br from-blue-500 to-blue-900')

@section('content')
    <div class="flex justify-center items-center min-h-screen mt-20"> {{-- ✅ ヘッダーとの距離を微調整 --}}
        <div
            class="w-[700px] h-[700px] bg-white rounded-lg shadow-lg p-12 flex flex-col justify-center items-center custom-form">

            <!-- ✅ ロゴサイズをさらに調整 -->
            <div class="mb-5">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-40 w-auto custom-logo">
            </div>

            <!-- ✅ タイトル -->
            <h1 class="text-2xl font-bold text-yellow-600 mb-5 text-center">🔑 ログイン</h1>

            <!-- ✅ フォーム -->
            <form method="POST" action="{{ route('login') }}" class="w-full flex flex-col items-center">
                @csrf

                <!-- ✅ フォーム入力欄の幅を調整 -->
                <div class="mb-4 w-4/5 custom-input">
                    <label for="email" class="block text-gray-800 text-base font-semibold mb-1">📧 メールアドレス</label>
                    <input type="email" name="email" id="email"
                        class="w-full px-4 py-3 border border-gray-300 rounded focus:ring focus:ring-yellow-400 text-base bg-white"
                        placeholder="example@mail.com" required>
                </div>

                <div class="mb-4 w-4/5 custom-input">
                    <label for="password" class="block text-gray-800 text-base font-semibold mb-1">🔒 パスワード</label>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-3 border border-gray-300 rounded focus:ring focus:ring-yellow-400 text-base bg-white"
                        placeholder="********" required>
                </div>

                <div class="mb-4 flex justify-between items-center w-4/5 custom-input">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="mr-2">
                        <span class="text-gray-800 text-base">記憶する</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-yellow-600 text-base hover:underline">パスワードを忘れた?</a>
                </div>

                <!-- ✅ ボタンの幅を調整 -->
                <button type="submit"
                    class="w-2/3 bg-blue-500 text-white text-base font-bold py-2 px-6 h-12 rounded hover:bg-blue-600 transition custom-button">
                    🚀 ログイン
                </button>
            </form>

            <!-- ✅ 登録リンク -->
            <p class="text-center text-gray-800 text-base mt-4">
                アカウントをお持ちでないですか？
                <a href="{{ route('register.select') }}" class="text-yellow-600 hover:underline">登録する</a>
            </p>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* ✅ スマホ対応の改善 */
        @media (max-width: 768px) {
            .custom-form {
                width: 95vw !important;
                height: 180vw !important;
                max-width: 95% !important;
                max-height: 180vh !important;
                padding: 2rem !important;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .custom-logo {
                height: 7rem !important;
                /* スマホのロゴを調整 */
            }

            .custom-input {
                max-width: 100% !important;
                /* フォームの横幅を調整 */
            }

            .custom-button {
                width: 80% !important;
                /* ボタンを調整 */
            }
        }
    </style>
@endpush
