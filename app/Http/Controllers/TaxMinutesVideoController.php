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
    public function index(Request $request)
    {
        $query = TaxMinutesVideo::with(['user', 'user.taxAdvisor']);

        // 税理士IDでフィルタリング
        if ($request->has('tax_advisor')) {
            $taxAdvisorId = $request->input('tax_advisor');
            $query->where('user_id', $taxAdvisorId);
        }

        $videos = $query->latest()->paginate(12);

        return view('taxminivideos.index', compact('videos'));
    }

    /**
     * 動画詳細ページを表示
     */
    public function show(TaxMinutesVideo $video)
    {
        // 関連するユーザー情報を読み込み
        $video->load([
            'user',
            'user.taxAdvisor',
            'approvedComments.user',
            'approvedComments.user.taxAdvisor'
        ]);

        // 閲覧数をインクリメント
        $video->increment('views');

        return view('taxminivideos.show', compact('video'));
    }

    public function create()
    {
        $user = Auth::user();
        return view('taxminivideos.create', compact('user'));
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
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 最大2MB
        ], [
            'video.required' => '動画ファイルを選択してください。',
            'video.file' => '有効なファイルを選択してください。',
            'video.mimetypes' => '対応していない動画形式です。MP4、QuickTime、AVI、FLV、WMVのいずれかの形式をアップロードしてください。',
            'video.max' => '動画ファイルのサイズは100MB以下である必要があります。',
            'thumbnail.image' => 'サムネイルは画像ファイルである必要があります。',
            'thumbnail.mimes' => 'サムネイルはJPEG、PNG、JPG、GIF形式のみ対応しています。',
            'thumbnail.max' => 'サムネイル画像のサイズは2MB以下である必要があります。',
        ]);

        try {
            // 動画ファイルを保存
            $videoPath = $request->file('video')->store('videos/taxminutes', 'public');
            Log::info('動画ファイル保存パス: ' . $videoPath);

            // サムネイル画像の処理
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('videos/thumbnails', 'public');
                Log::info('サムネイル画像保存パス: ' . $thumbnailPath);
            }

            // データベースに保存
            $userId = Auth::id();
            $video = new TaxMinutesVideo([
                'user_id' => $userId,
                'title' => $request->title,
                'description' => $request->description ?? '',
                'prefecture' => $request->prefecture ?? null,
                'video_path' => $videoPath,
                'thumbnail_path' => $thumbnailPath,
                'views' => 0,
            ]);
            $video->save();

            Log::info('動画アップロード成功: ID=' . $video->id);

            return redirect()->route('taxminivideos.manage')->with('success', '動画がアップロードされました');
        } catch (\Exception $e) {
            Log::error('動画アップロードエラー: ' . $e->getMessage());
            return redirect()->route('taxminivideos.manage')->withInput()->with('error', '動画のアップロードに失敗しました: ' . $e->getMessage());
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
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 最大2MB
        ], [
            'thumbnail.image' => 'サムネイルは画像ファイルである必要があります。',
            'thumbnail.mimes' => 'サムネイルはJPEG、PNG、JPG、GIF形式のみ対応しています。',
            'thumbnail.max' => 'サムネイル画像のサイズは2MB以下である必要があります。',
        ]);

        try {
            // データを更新
            $data = [
                'title' => $request->title,
                'description' => $request->description,
            ];

            // サムネイル画像の処理
            if ($request->hasFile('thumbnail')) {
                // 古いサムネイルを削除
                if ($video->thumbnail_path && Storage::disk('public')->exists($video->thumbnail_path)) {
                    Storage::disk('public')->delete($video->thumbnail_path);
                }

                // 新しいサムネイルを保存
                $thumbnailPath = $request->file('thumbnail')->store('videos/thumbnails', 'public');
                $data['thumbnail_path'] = $thumbnailPath;
                Log::info('サムネイル画像更新: ' . $thumbnailPath);
            }

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
            // 動画ファイルの削除
            if ($video->video_path && Storage::disk('public')->exists($video->video_path)) {
                Storage::disk('public')->delete($video->video_path);
            }

            // サムネイルの削除
            if ($video->thumbnail_path && Storage::disk('public')->exists($video->thumbnail_path)) {
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

    /**
     * 専門家用の動画管理画面を表示
     */
    public function manage()
    {
        $user = Auth::user();

        // ユーザーが投稿した動画を取得
        $videos = TaxMinutesVideo::where('user_id', $user->id)
            ->with('comments')
            ->latest()
            ->paginate(10); // ページネーション機能を追加

        return view('taxminivideos.manage', compact('videos', 'user'));
    }
}
