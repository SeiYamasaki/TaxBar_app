<?php

namespace App\Http\Controllers;

use App\Models\TaxMinutesVideo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaxMinutesVideoController extends Controller
{
    /**
     * 動画一覧を表示
     */
    public function index()
    {
        $videos = TaxMinutesVideo::latest()->paginate(12);
        return view('taxminivideos.index', compact('videos'));
    }

    /**
     * 動画を都道府県でフィルター
     */
    public function byPrefecture($prefecture)
    {
        $videos = TaxMinutesVideo::where('prefecture', $prefecture)
            ->latest()
            ->paginate(12);

        return view('taxminivideos.index', compact('videos', 'prefecture'));
    }

    /**
     * 動画詳細ページを表示
     */
    public function show(TaxMinutesVideo $video)
    {
        // 閲覧数をインクリメント
        $video->increment('views');

        return view('taxminivideos.show', compact('video'));
    }

    /**
     * 新規動画をアップロード（ダッシュボードのフォームから）
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'video' => 'required|file|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-flv,video/x-ms-wmv|max:102400', // 100MB
        ], [
            'video.required' => '動画ファイルを選択してください。',
            'video.file' => '有効なファイルを選択してください。',
            'video.mimetypes' => '対応していない動画形式です。MP4、QuickTime、AVI、FLV、WMVのいずれかの形式をアップロードしてください。',
            'video.max' => '動画ファイルのサイズは100MB以下である必要があります。',
        ]);

        try {
            // 動画ファイルを保存
            $videoPath = $request->file('video')->store('videos/taxminutes', 'public');
            Log::info('動画ファイル保存パス: ' . $videoPath);

            // データベースに保存
            $userId = Auth::id();
            $video = new TaxMinutesVideo([
                'user_id' => $userId,
                'title' => $request->title,
                'description' => $request->description ?? '',
                'prefecture' => $request->prefecture ?? null,
                'video_path' => $videoPath,
                'thumbnail_path' => null,
                'views' => 0,
            ]);
            $video->save();

            Log::info('動画アップロード成功: ID=' . $video->id);

            return back()->with('success', '動画がアップロードされました');
        } catch (\Exception $e) {
            Log::error('動画アップロードエラー: ' . $e->getMessage());
            return back()->withInput()->with('error', '動画のアップロードに失敗しました: ' . $e->getMessage());
        }
    }

    /**
     * 動画編集ページを表示
     */
    public function edit(TaxMinutesVideo $video)
    {
        // 本人の動画かチェック
        if (Auth::id() !== $video->user_id) {
            abort(403, '他のユーザーの動画は編集できません');
        }

        return view('taxminivideos.edit', compact('video'));
    }

    /**
     * 動画を更新
     */
    public function update(Request $request, TaxMinutesVideo $video)
    {
        // 本人の動画かチェック
        if (Auth::id() !== $video->user_id) {
            abort(403, '他のユーザーの動画は編集できません');
        }

        // actionパラメータがdeleteの場合は削除処理を実行
        if ($request->input('action') === 'delete') {
            return $this->destroy($video);
        }

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
        ]);

        try {
            // データを更新
            $data = [
                'title' => $request->title,
                'description' => $request->description,
            ];

            // データベースを更新
            $video->update($data);
            Log::info('動画更新成功: ID=' . $video->id);

            return redirect()->route('dashboard')
                ->with('success', '動画が更新されました');
        } catch (\Exception $e) {
            Log::error('動画更新エラー: ' . $e->getMessage());
            return redirect()->route('dashboard')
                ->with('error', '動画の更新に失敗しました: ' . $e->getMessage());
        }
    }

    /**
     * 動画を削除
     */
    public function destroy(TaxMinutesVideo $video)
    {
        // 本人の動画かチェック
        if (Auth::id() !== $video->user_id) {
            abort(403, '他のユーザーの動画は削除できません');
        }

        try {
            // ファイルを削除
            if ($video->video_path) {
                Storage::disk('public')->delete($video->video_path);
            }

            if ($video->thumbnail_path) {
                Storage::disk('public')->delete($video->thumbnail_path);
            }

            // データベースから削除
            $video->delete();
            Log::info('動画削除成功: ID=' . $video->id);

            return redirect()->route('dashboard')
                ->with('success', '動画が削除されました');
        } catch (\Exception $e) {
            Log::error('動画削除エラー: ' . $e->getMessage());
            return redirect()->route('dashboard')
                ->with('error', '動画の削除に失敗しました: ' . $e->getMessage());
        }
    }
}
