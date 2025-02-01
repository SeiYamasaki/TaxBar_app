<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Video;

class VideoController extends Controller
{
    /**
     * 動画一覧を表示する
     */
    public function index()
    {
        // データベースから動画を取得 (最新順)
        $videos = Video::latest()->get();

        // 'videos.index' ビューに動画データを渡す
        return view('videos.index', compact('videos'));
    }

    /**
     * 動画を保存する
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'video' => 'required|mimes:mp4,mov,avi|max:10240', // 10MB以内の動画
        ]);
        $user = Auth::user();//public化 インスタンスの生成
        if ($user()->isTaxAccountant()) { // 税理士のみ投稿可能
            $videoPath = $request->file('video')->store('videos', 'public');

            
            Video::create([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'video_path' => $videoPath,
            ]);

            return redirect()->route('videos.index')->with('success', '動画を投稿しました。');
        }

        return back()->with('error', '投稿権限がありません。');
    }

    /**
     * 動画を削除する
     */
    public function destroy(Video $video)
    {
        $user = Auth::user();//public化 インスタンスの生成
        if ($user->id === $video->user_id || $user()->isAdmin()) {
            Storage::disk('public')->delete($video->video_path);
            $video->delete();

            return redirect()->route('videos.index')->with('success', '動画を削除しました。');
        }

        return back()->with('error', '削除権限がありません。');
    }
}
