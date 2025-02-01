<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videos</title>
</head>

<body>
    <h1>Videos</h1>
    @if ($videos->isEmpty())
        <p>No videos uploaded yet.</p>
    @else
        @foreach ($videos as $video)
            <div>
                <h3>{{ $video->title }}</h3>
                <video width="320" height="240" controls>
                    <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                </video>
            </div>
        @endforeach
    @endif
</body>

</html>
