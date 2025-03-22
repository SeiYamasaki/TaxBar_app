@extends('layouts.app')

@section('content')
    <div class="bg-gray-100 min-h-screen mt-32 mb-16">
        <div class="container mx-auto px-4 py-12">
            <div class="max-w-5xl mx-auto">
                <!-- フラッシュメッセージ -->
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm"
                        role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- プロフィールカード -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                    <div class="md:flex">
                        <!-- プロフィール画像 -->
                        <div class="md:w-1/3 bg-blue-50 flex items-center justify-center p-8">
                            @if ($taxAdvisor->tax_accountant_photo)
                                <img src="{{ asset('storage/' . $taxAdvisor->tax_accountant_photo) }}"
                                    alt="{{ $user->name }}のプロフィール画像"
                                    class="w-48 h-48 object-cover rounded-full border-4 border-white shadow-lg">
                            @else
                                <div
                                    class="w-48 h-48 rounded-full bg-gray-300 flex items-center justify-center border-4 border-white shadow-lg">
                                    <svg class="w-24 h-24 text-gray-500" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- プロフィール情報 -->
                        <div class="md:w-2/3 p-8">
                            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $user->name }}</h1>
                            <h2 class="text-xl text-blue-600 font-semibold mb-4">{{ $taxAdvisor->office_name }}</h2>

                            <div class="mb-6">
                                <span
                                    class="inline-block bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full mr-2 mb-2">税理士</span>
                                @if ($taxAdvisor->specialty)
                                    <span
                                        class="inline-block bg-green-100 text-green-800 text-sm font-semibold px-3 py-1 rounded-full mr-2 mb-2">専門:
                                        {{ $taxAdvisor->specialty }}</span>
                                @endif
                                <span
                                    class="inline-block bg-yellow-100 text-yellow-800 text-sm font-semibold px-3 py-1 rounded-full mr-2 mb-2">{{ $taxAdvisor->prefecture }}</span>
                            </div>

                            <!-- 専門テーマ表示 -->
                            @if ($selectedThemes->count() > 0)
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold mb-2">専門テーマ</h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($selectedThemes as $theme)
                                            <span
                                                class="inline-block bg-purple-100 text-purple-800 text-sm font-medium px-3 py-1 rounded-full">
                                                {{ $theme->title }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($taxAdvisor->profile_info)
                                <div class="text-gray-700 mb-6">
                                    <h3 class="text-lg font-semibold mb-2">プロフィール</h3>
                                    <p class="whitespace-pre-line">{{ $taxAdvisor->profile_info }}</p>
                                </div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                                <div>
                                    <p class="mb-2"><span class="font-semibold">事務所住所:</span><br>
                                        〒{{ $taxAdvisor->postal_code }}<br>
                                        {{ $taxAdvisor->prefecture }}{{ $taxAdvisor->address }}</p>
                                </div>
                                <div>
                                    <p class="mb-2"><span class="font-semibold">事務所電話番号:</span><br>
                                        {{ $taxAdvisor->office_phone }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 投稿動画セクション -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                    <div class="border-b border-gray-200">
                        <h2 class="text-2xl font-bold text-gray-800 p-6">投稿動画</h2>
                    </div>

                    <div class="p-6">
                        @if ($videos->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach ($videos as $video)
                                    <div
                                        class="bg-gray-50 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                                        <a href="{{ route('taxminivideos.show', $video) }}" class="block">
                                            <div class="relative pb-[177.77%]"> <!-- 16:9 アスペクト比 -->
                                                @if ($video->thumbnail_path)
                                                    <img src="{{ asset('storage/' . $video->thumbnail_path) }}"
                                                        alt="{{ $video->title }}"
                                                        class="absolute inset-0 w-full h-full object-cover">
                                                @else
                                                    <div
                                                        class="absolute inset-0 w-full h-full bg-gray-300 flex items-center justify-center">
                                                        <svg class="w-16 h-16 text-gray-500" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                                            </path>
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                @endif

                                                <!-- 再生ボタンオーバーレイ -->
                                                <div class="absolute inset-0 flex items-center justify-center">
                                                    <div
                                                        class="w-16 h-16 rounded-full bg-white bg-opacity-75 flex items-center justify-center">
                                                        <svg class="w-8 h-8 text-blue-600" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="p-4">
                                                <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2">
                                                    {{ $video->title }}</h3>
                                                <p class="text-gray-600 text-sm mb-2 line-clamp-3">
                                                    {{ $video->description }}</p>
                                                <p class="text-gray-500 text-xs">{{ $video->created_at->format('Y年m月d日') }}
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>

                            @if ($videos->count() >= 6)
                                <div class="mt-6 text-center">
                                    <a href="{{ route('taxminivideos.index') }}?tax_advisor={{ $user->id }}"
                                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition-colors duration-300">
                                        すべての動画を見る
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z">
                                    </path>
                                </svg>
                                <p class="text-gray-500 text-lg">まだ動画が投稿されていません</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- 問い合わせボタン -->
                <div class="text-center">
                    <a href="{{ route('inquiry.form') }}?tax_advisor={{ $user->id }}"
                        class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold px-8 py-3 rounded-lg shadow-lg transition-colors duration-300">
                        この税理士に問い合わせる
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
