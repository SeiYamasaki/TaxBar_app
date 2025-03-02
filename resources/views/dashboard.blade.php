<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar®️ | ダッシュボード</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #eef2f3;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            width: 80%;
            /* 横幅を広げる */
            max-width: 1200px;
            background-color: white;
            padding: 50px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            text-align: center;
            position: relative;
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 700px auto 20px;
            max-width: 250px;
        }


        .header {
            font-size: 36px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .message {
            font-size: 22px;
            color: #555;
            margin-bottom: 30px;
        }

        .info {
            text-align: left;
            font-size: 20px;
            line-height: 1.8;
            margin-bottom: 30px;
            border-left: 4px solid #3498db;
            padding-left: 20px;
            background-color: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
        }

        .profile-photo,
        .additional-photo {
            max-width: 250px;
            height: auto;
            border-radius: 10px;
            margin-top: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .logout-button {
            background-color: #e74c3c;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 20px;
            transition: background-color 0.3s ease;
        }

        .logout-button:hover {
            background-color: #c0392b;
        }
    </style>
</head>

<body>
    @include('components.header')
    <div class="container">
        <!-- ロゴの表示 -->
        <img src="/images/logotoumei.png" alt="ロゴ" class="logo">

        <div class="header">Dashboard</div>
        <div class="message">登録情報</div>

        <div class="info">
            <p><strong>名前:</strong> {{ auth()->user()->name }}</p>
            <p><strong>メールアドレス:</strong> {{ auth()->user()->email }}</p>
            <p><strong>事務所名:</strong> {{ auth()->user()->office_name ?? '未登録' }}</p>
            <p><strong>郵便番号:</strong> {{ auth()->user()->postal_code ?? '未登録' }}</p>
            <p><strong>都道府県:</strong> {{ auth()->user()->prefecture ?? '未登録' }}</p>
            <p><strong>住所:</strong> {{ auth()->user()->address ?? '未登録' }}</p>
            <p><strong>事務所電話番号:</strong> {{ auth()->user()->office_phone ?? '未登録' }}</p>
            <p><strong>携帯電話番号:</strong> {{ auth()->user()->mobile_phone ?? '未登録' }}</p>
            <p><strong>登録番号:</strong> {{ auth()->user()->tax_registration_number ?? '未登録' }}</p>
            <p><strong>料金プラン:</strong> {{ auth()->user()->plan ?? '未登録' }}</p>
        </div>

        <!-- プロフィール写真の表示 -->
        <div class="info">
            <p><strong>プロフィール写真:</strong></p>
            <img src="{{ auth()->user()->tax_accountant_photo ?? '/default-photo.png' }}" alt="プロフィール写真"
                class="profile-photo">
        </div>

        <!-- その他の写真の表示 -->
        <div class="info">
            <p><strong>その他の写真:</strong></p>
            @if (auth()->user()->additional_photos)
                @foreach (json_decode(auth()->user()->additional_photos, true) as $photo)
                    <img src="{{ $photo }}" alt="追加写真" class="additional-photo">
                @endforeach
            @else
                <p>登録されていません</p>
            @endif
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-button">ログアウト</button>
        </form>
    </div>
</body>

</html>
