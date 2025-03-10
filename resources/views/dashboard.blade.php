<!DOCTYPE html>
<html lang="ja" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar® | ダッシュボード</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="flex flex-col min-h-full bg-gray-100">
    @include('components.header')

    <!-- ヘッダーの高さ分のスペーサー -->
    <div class="h-20"></div>

    <main class="flex-grow container mx-auto px-4 py-8 mt-20">
        <div class="bg-white shadow-md rounded-lg p-8 max-w-4xl mx-auto">
            <!-- ロゴの表示 -->
            <div class="flex justify-center mb-6">
                <img src="/images/logotoumei.png" alt="ロゴ" class="h-48">
            </div>

            <h1 class="text-3xl font-bold text-gray-800 mb-2 text-center">Dashboard</h1>
            <p class="text-xl text-gray-600 mb-6 text-center">登録情報</p>

            <!-- フラッシュメッセージ表示 -->
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- ユーザー情報の表示 -->
            <div class="bg-gray-50 border-l-4 border-blue-500 p-6 rounded-lg mb-6">
                <p class="py-1"><strong>名前:</strong> {{ auth()->user()->name }}</p>
                <p class="py-1"><strong>メールアドレス:</strong> {{ auth()->user()->email }}</p>
                <p class="py-1"><strong>ユーザー種別:</strong>
                    @switch(auth()->user()->role)
                        @case('admin')
                            管理者
                        @break

                        @case('tax_advisor')
                            税理士
                        @break

                        @case('company')
                            企業
                        @break

                        @case('individual')
                            個人
                        @break

                        @default
                            未設定
                    @endswitch
                </p>

                @if (auth()->user()->role === 'tax_advisor' && auth()->user()->taxAdvisor)
                    <!-- 税理士の場合の追加情報 -->
                    <h3 class="font-bold mt-3 mb-2 border-b pb-1">税理士プロフィール</h3>
                    <p class="py-1"><strong>事務所名:</strong> {{ auth()->user()->taxAdvisor->office_name ?? '未登録' }}</p>
                    <p class="py-1"><strong>郵便番号:</strong> {{ auth()->user()->taxAdvisor->postal_code ?? '未登録' }}</p>
                    <p class="py-1"><strong>都道府県:</strong> {{ auth()->user()->taxAdvisor->prefecture ?? '未登録' }}</p>
                    <p class="py-1"><strong>住所:</strong> {{ auth()->user()->taxAdvisor->address ?? '未登録' }}</p>
                    <p class="py-1"><strong>事務所電話番号:</strong> {{ auth()->user()->taxAdvisor->office_phone ?? '未登録' }}
                    </p>
                    <p class="py-1"><strong>携帯電話番号:</strong> {{ auth()->user()->taxAdvisor->mobile_phone ?? '未登録' }}
                    </p>
                    <p class="py-1"><strong>専門分野:</strong> {{ auth()->user()->taxAdvisor->specialty ?? '未登録' }}</p>
                    @if (auth()->user()->taxAdvisor->subscriptionPlan)
                        <p class="py-1"><strong>料金プラン:</strong>
                            {{ auth()->user()->taxAdvisor->subscriptionPlan->name ?? '未登録' }}</p>
                        <p class="py-1"><strong>プラン期間:</strong>
                            {{ auth()->user()->taxAdvisor->subscription_start_date ? auth()->user()->taxAdvisor->subscription_start_date->format('Y年m月d日') : '未設定' }}
                            から
                            {{ auth()->user()->taxAdvisor->subscription_end_date ? auth()->user()->taxAdvisor->subscription_end_date->format('Y年m月d日') : '未設定' }}
                        </p>
                    @endif
                @endif
            </div>

            <!-- Tax Minutes リール動画管理セクション -->
            <div class="bg-gray-50 border-l-4 border-green-500 p-6 rounded-lg mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Tax Minutes リール動画</h2>

                <!-- 動画アップロードフォーム -->
                <div class="mb-6 p-4 bg-white rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold mb-3">新しい動画をアップロード</h3>
                    <form action="{{ route('taxminivideos.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-4">
                        @csrf
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">タイトル</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">説明</label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="prefecture" class="block text-sm font-medium text-gray-700 mb-1">関連都道府県</label>
                            <select name="prefecture" id="prefecture"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">選択してください</option>
                                <option value="北海道" {{ old('prefecture') == '北海道' ? 'selected' : '' }}>北海道</option>
                                <option value="青森県" {{ old('prefecture') == '青森県' ? 'selected' : '' }}>青森県</option>
                                <option value="岩手県" {{ old('prefecture') == '岩手県' ? 'selected' : '' }}>岩手県</option>
                                <option value="宮城県" {{ old('prefecture') == '宮城県' ? 'selected' : '' }}>宮城県</option>
                                <option value="秋田県" {{ old('prefecture') == '秋田県' ? 'selected' : '' }}>秋田県</option>
                                <option value="山形県" {{ old('prefecture') == '山形県' ? 'selected' : '' }}>山形県</option>
                                <option value="福島県" {{ old('prefecture') == '福島県' ? 'selected' : '' }}>福島県</option>
                                <option value="茨城県" {{ old('prefecture') == '茨城県' ? 'selected' : '' }}>茨城県</option>
                                <option value="栃木県" {{ old('prefecture') == '栃木県' ? 'selected' : '' }}>栃木県</option>
                                <option value="群馬県" {{ old('prefecture') == '群馬県' ? 'selected' : '' }}>群馬県</option>
                                <option value="埼玉県" {{ old('prefecture') == '埼玉県' ? 'selected' : '' }}>埼玉県</option>
                                <option value="千葉県" {{ old('prefecture') == '千葉県' ? 'selected' : '' }}>千葉県</option>
                                <option value="東京都" {{ old('prefecture') == '東京都' ? 'selected' : '' }}>東京都</option>
                                <option value="神奈川県" {{ old('prefecture') == '神奈川県' ? 'selected' : '' }}>神奈川県
                                </option>
                                <option value="新潟県" {{ old('prefecture') == '新潟県' ? 'selected' : '' }}>新潟県</option>
                                <option value="富山県" {{ old('prefecture') == '富山県' ? 'selected' : '' }}>富山県</option>
                                <option value="石川県" {{ old('prefecture') == '石川県' ? 'selected' : '' }}>石川県</option>
                                <option value="福井県" {{ old('prefecture') == '福井県' ? 'selected' : '' }}>福井県</option>
                                <option value="山梨県" {{ old('prefecture') == '山梨県' ? 'selected' : '' }}>山梨県</option>
                                <option value="長野県" {{ old('prefecture') == '長野県' ? 'selected' : '' }}>長野県</option>
                                <option value="岐阜県" {{ old('prefecture') == '岐阜県' ? 'selected' : '' }}>岐阜県</option>
                                <option value="静岡県" {{ old('prefecture') == '静岡県' ? 'selected' : '' }}>静岡県</option>
                                <option value="愛知県" {{ old('prefecture') == '愛知県' ? 'selected' : '' }}>愛知県</option>
                                <option value="三重県" {{ old('prefecture') == '三重県' ? 'selected' : '' }}>三重県</option>
                                <option value="滋賀県" {{ old('prefecture') == '滋賀県' ? 'selected' : '' }}>滋賀県</option>
                                <option value="京都府" {{ old('prefecture') == '京都府' ? 'selected' : '' }}>京都府</option>
                                <option value="大阪府" {{ old('prefecture') == '大阪府' ? 'selected' : '' }}>大阪府</option>
                                <option value="兵庫県" {{ old('prefecture') == '兵庫県' ? 'selected' : '' }}>兵庫県</option>
                                <option value="奈良県" {{ old('prefecture') == '奈良県' ? 'selected' : '' }}>奈良県</option>
                                <option value="和歌山県" {{ old('prefecture') == '和歌山県' ? 'selected' : '' }}>和歌山県
                                </option>
                                <option value="鳥取県" {{ old('prefecture') == '鳥取県' ? 'selected' : '' }}>鳥取県</option>
                                <option value="島根県" {{ old('prefecture') == '島根県' ? 'selected' : '' }}>島根県</option>
                                <option value="岡山県" {{ old('prefecture') == '岡山県' ? 'selected' : '' }}>岡山県</option>
                                <option value="広島県" {{ old('prefecture') == '広島県' ? 'selected' : '' }}>広島県</option>
                                <option value="山口県" {{ old('prefecture') == '山口県' ? 'selected' : '' }}>山口県</option>
                                <option value="徳島県" {{ old('prefecture') == '徳島県' ? 'selected' : '' }}>徳島県</option>
                                <option value="香川県" {{ old('prefecture') == '香川県' ? 'selected' : '' }}>香川県</option>
                                <option value="愛媛県" {{ old('prefecture') == '愛媛県' ? 'selected' : '' }}>愛媛県</option>
                                <option value="高知県" {{ old('prefecture') == '高知県' ? 'selected' : '' }}>高知県</option>
                                <option value="福岡県" {{ old('prefecture') == '福岡県' ? 'selected' : '' }}>福岡県</option>
                                <option value="佐賀県" {{ old('prefecture') == '佐賀県' ? 'selected' : '' }}>佐賀県</option>
                                <option value="長崎県" {{ old('prefecture') == '長崎県' ? 'selected' : '' }}>長崎県</option>
                                <option value="熊本県" {{ old('prefecture') == '熊本県' ? 'selected' : '' }}>熊本県</option>
                                <option value="大分県" {{ old('prefecture') == '大分県' ? 'selected' : '' }}>大分県</option>
                                <option value="宮崎県" {{ old('prefecture') == '宮崎県' ? 'selected' : '' }}>宮崎県</option>
                                <option value="鹿児島県" {{ old('prefecture') == '鹿児島県' ? 'selected' : '' }}>鹿児島県
                                </option>
                                <option value="沖縄県" {{ old('prefecture') == '沖縄県' ? 'selected' : '' }}>沖縄県</option>
                            </select>
                            @error('prefecture')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="video" class="block text-sm font-medium text-gray-700 mb-1">動画ファイル</label>
                            <input type="file" name="video" id="video"
                                accept="video/mp4,video/quicktime,video/x-msvideo,video/x-flv,video/x-ms-wmv" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-sm text-gray-500 mt-1">最大ファイルサイズ: 100MB</p>
                            @error('video')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="thumbnail"
                                class="block text-sm font-medium text-gray-700 mb-1">サムネイル画像（オプション）</label>
                            <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-sm text-gray-500 mt-1">最大ファイルサイズ: 20MB</p>
                            @error('thumbnail')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                                アップロード
                            </button>
                        </div>
                    </form>
                </div>

                <!-- 投稿済み動画一覧 -->
                <div class="p-4 bg-white rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold mb-3">投稿済み動画</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2 px-4 border-b text-left">サムネイル</th>
                                    <th class="py-2 px-4 border-b text-left">タイトル</th>
                                    <th class="py-2 px-4 border-b text-left">都道府県</th>
                                    <th class="py-2 px-4 border-b text-left">投稿日</th>
                                    <th class="py-2 px-4 border-b text-left">アクション</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse (auth()->user()->taxMinutesVideos ?? [] as $video)
                                    <tr>
                                        <td class="py-2 px-4 border-b">
                                            <img src="{{ $video->thumbnail_url ?? asset('images/default-thumbnail.jpg') }}"
                                                alt="サムネイル" class="w-16 h-10 object-cover rounded">
                                        </td>
                                        <td class="py-2 px-4 border-b">{{ $video->title }}</td>
                                        <td class="py-2 px-4 border-b">{{ $video->prefecture }}</td>
                                        <td class="py-2 px-4 border-b">{{ $video->created_at->format('Y/m/d') }}</td>
                                        <td class="py-2 px-4 border-b">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('taxminivideos.edit', $video->id) }}"
                                                    class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-2 rounded text-sm">
                                                    編集
                                                </a>
                                                <form action="{{ route('taxminivideos.destroy', $video->id) }}"
                                                    method="POST" onsubmit="return confirm('この動画を削除してもよろしいですか？');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="bg-red-500 hover:bg-red-600 text-white py-1 px-2 rounded text-sm">
                                                        削除
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 px-4 border-b text-center text-gray-500">
                                            投稿した動画はありません
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- プロフィール写真の表示 -->
            @if (auth()->user()->role === 'tax_advisor' && auth()->user()->taxAdvisor)
                <div class="bg-gray-50 border-l-4 border-blue-500 p-6 rounded-lg mb-6">
                    <p class="mb-3"><strong>プロフィール写真:</strong></p>
                    <div class="flex justify-center">
                        <img src="{{ auth()->user()->taxAdvisor->tax_accountant_photo ?? '/default-photo.png' }}"
                            alt="プロフィール写真" class="max-w-xs rounded-lg shadow-md">
                    </div>
                </div>

                <!-- その他の写真の表示 -->
                <div class="bg-gray-50 border-l-4 border-blue-500 p-6 rounded-lg mb-6">
                    <p class="mb-3"><strong>その他の写真:</strong></p>
                    <div class="flex flex-wrap justify-center gap-4">
                        @if (auth()->user()->taxAdvisor && auth()->user()->taxAdvisor->additional_photos)
                            @foreach (json_decode(auth()->user()->taxAdvisor->additional_photos, true) as $photo)
                                <img src="{{ $photo }}" alt="追加写真" class="max-w-xs rounded-lg shadow-md">
                            @endforeach
                        @else
                            <p>登録されていません</p>
                        @endif
                    </div>
                </div>
            @endif

            <div class="flex justify-center">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">ログアウト</button>
                </form>
            </div>
        </div>
    </main>
</body>

</html>
