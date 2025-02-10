@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>TaxMinutes - 動画投稿</h1>

        <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">動画タイトル</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="video" class="form-label">動画ファイル</label>
                <input type="file" name="video" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">投稿</button>
        </form>
    </div>
@endsection
