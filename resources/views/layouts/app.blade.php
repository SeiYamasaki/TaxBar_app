<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TaxBar®') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- <!-- Bootstrap 5 -->登録フォームのデザイン --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- <!-- FontAwesome -->登録フォームのデザイン --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- ✅ Alpine.js を追加 -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Styles -->
    <style>
        /* ✅ デフォルトの `body` スタイル（変更を許可） */
        body {
            background: linear-gradient(to right, #4f92ff, #0052cc, #002766);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ✅ デフォルトの `main` スタイル */
        main {
            flex-grow: 1;
            width: 100%;
            display: flex; /* ✅ デフォルトは `flex` だが、ページごとに変更可能 */
            justify-content: center;
            align-items: center;
            min-height: auto !important; /* ✅ 高さを自動調整 */
        }

        /* ✅ ヘッダーのスタイル */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 90px;
            background-color: white;
            z-index: 1000;
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>

    <!-- ✅ 特定ページ専用のスタイル -->
    @yield('page-specific-styles')

    @stack('styles')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<!-- ✅ `@yield('body-class')` で特定のページだけクラスを変更可能 -->
<body class="@yield('body-class')">
    @include('components.header')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    <!-- Scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 画像プレビュー関数
            function previewImage(input, previewId) {
                const file = input.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.getElementById(previewId);
                        img.src = e.target.result;
                        img.classList.remove("d-none"); // 非表示を解除
                        img.style.display = "block"; // 確実に表示
                    };
                    reader.readAsDataURL(file);
                }
            }

            // 税理士写真プレビュー
            const taxPhotoInput = document.getElementById("tax_accountant_photo");
            if (taxPhotoInput) {
                taxPhotoInput.addEventListener("change", function() {
                    previewImage(this, "preview_tax_accountant_photo");
                });
            }

            // その他の写真プレビュー
            const additionalPhotosInput = document.getElementById("additional_photos");
            if (additionalPhotosInput) {
                additionalPhotosInput.addEventListener("change", function(e) {
                    const container = document.getElementById("preview_additional_photos");
                    container.innerHTML = ""; // 既存のプレビューをクリア

                    Array.from(e.target.files).forEach((file) => {
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(event) {
                                const imgWrapper = document.createElement("div");
                                imgWrapper.classList.add("m-2");

                                const img = document.createElement("img");
                                img.src = event.target.result;
                                img.classList.add("img-thumbnail");
                                img.style.maxHeight = "100px";

                                imgWrapper.appendChild(img);
                                container.appendChild(imgWrapper);
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
