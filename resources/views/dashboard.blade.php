<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .container {
            max-width: 800px;
            background-color: white;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }
        .message {
            font-size: 18px;
            color: #555;
            margin-bottom: 20px;
        }
        .info {
            text-align: left;
            margin-bottom: 20px;
        }
        .profile-photo, .additional-photo {
            max-width: 150px;
            height: auto;
            border-radius: 8px;
            margin-top: 10px;
        }
        .logout-button {
            background-color: #e3342f;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .logout-button:hover {
            background-color: #cc1f1a;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Dashboard</div>
        <div class="message">You're logged in!</div>
        
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
            <img src="{{ auth()->user()->tax_accountant_photo ?? '/default-photo.png' }}" alt="プロフィール写真" class="profile-photo">
        </div>
        
        <!-- その他の写真の表示 -->
        <div class="info">
            <p><strong>その他の写真:</strong></p>
            @if(auth()->user()->additional_photos)
                @foreach(json_decode(auth()->user()->additional_photos, true) as $photo)
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
