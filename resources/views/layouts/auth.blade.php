<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ログイン - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gradient-to-br from-blue-500 to-blue-900 min-h-screen flex flex-col">

    <!-- ✅ ヘッダーを追加 -->
    @include('layouts.navigation')

    <!-- ✅ メインコンテンツ（ログインフォーム） -->
    <main class="flex-grow flex items-center justify-center mt-20">
        <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
            @yield('content')
        </div>
    </main>

</body>

</html>
