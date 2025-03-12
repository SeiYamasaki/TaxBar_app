<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\TaxMinutesVideo;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * コンストラクタ - 認証が必要なアクションを指定
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * コメント一覧を表示（管理者向け）
     */
    public function index(Request $request)
    {
        // 管理者権限チェック
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return redirect()->back()->with('error', '権限がありません。');
        }

        $query = Comment::with(['user', 'commentable']);

        // フィルタリング
        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($status === 'pending') {
                $query->where('is_approved', false);
            }
        }

        // 検索
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('content', 'like', "%{$search}%");
        }

        $comments = $query->latest()->paginate(20);

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * 特定のコメントの詳細を表示
     */
    public function show(Comment $comment)
    {
        // 管理者または関連ユーザーのみアクセス可能
        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'ログインが必要です。');
        }

        $commentable = $comment->commentable;

        if ($user->role !== 'admin' && $user->id !== $comment->user_id && $user->id !== $commentable->user_id) {
            return redirect()->back()->with('error', '権限がありません。');
        }

        return view('comments.show', compact('comment'));
    }

    /**
     * ユーザー自身のコメント一覧を表示
     */
    public function myComments(Request $request)
    {
        $user = Auth::user();
        $query = Comment::where('user_id', $user->id);

        // フィルタリング
        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($status === 'pending') {
                $query->where('is_approved', false);
            }
        }

        $comments = $query->latest()->paginate(10);

        return view('comments.my-comments', compact('comments'));
    }

    /**
     * 投稿者向けの受信コメント一覧を表示
     */
    public function receivedComments(Request $request)
    {
        $user = Auth::user();

        // ユーザーが所有するコンテンツのIDを取得
        $videoIds = TaxMinutesVideo::where('user_id', $user->id)->pluck('id')->toArray();
        $themeIds = Theme::where('user_id', $user->id)->pluck('id')->toArray();

        // コメント取得クエリを構築
        $query = Comment::where(function ($q) use ($videoIds, $themeIds) {
            // 動画へのコメント
            $q->where(function ($q1) use ($videoIds) {
                $q1->where('commentable_type', TaxMinutesVideo::class)
                    ->whereIn('commentable_id', $videoIds);
            });
            // テーマへのコメント
            $q->orWhere(function ($q1) use ($themeIds) {
                $q1->where('commentable_type', Theme::class)
                    ->whereIn('commentable_id', $themeIds);
            });
        });

        // フィルタリング
        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($status === 'pending') {
                $query->where('is_approved', false);
            }
        }

        $comments = $query->latest()->paginate(10);

        return view('comments.received', compact('comments'));
    }

    /**
     * TaxMinutesVideoに対するコメントを保存
     */
    public function storeForVideo(Request $request, TaxMinutesVideo $video)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = new Comment([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'is_approved' => false, // デフォルトでは未承認
        ]);

        $video->comments()->save($comment);

        return redirect()->back()->with('success', 'コメントが投稿されました。投稿者の承認後に表示されます。');
    }

    /**
     * Themeに対するコメントを保存（クチコミ）
     */
    public function storeForTheme(Request $request, Theme $theme)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = new Comment([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'is_approved' => false, // デフォルトでは未承認
        ]);

        $theme->comments()->save($comment);

        return redirect()->back()->with('success', 'クチコミが投稿されました。投稿者の承認後に表示されます。');
    }

    /**
     * コメントを承認する（投稿者のみ可能）
     */
    public function approve(Comment $comment)
    {
        // コメント対象の投稿者かどうかを確認
        $commentable = $comment->commentable;

        if ($commentable->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'このコメントを承認する権限がありません。');
        }

        $comment->update(['is_approved' => true]);

        return redirect()->back()->with('success', 'コメントが承認されました。');
    }

    /**
     * コメントを拒否する（投稿者のみ可能）
     */
    public function reject(Comment $comment)
    {
        // コメント対象の投稿者かどうかを確認
        $commentable = $comment->commentable;

        if ($commentable->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'このコメントを拒否する権限がありません。');
        }

        $comment->delete(); // ソフトデリート

        return redirect()->back()->with('success', 'コメントが拒否されました。');
    }

    /**
     * コメントを削除する（コメント投稿者または対象の投稿者のみ可能）
     */
    public function destroy(Comment $comment)
    {
        // コメントの投稿者またはコメント対象の投稿者かどうかを確認
        $commentable = $comment->commentable;

        if ($comment->user_id !== Auth::id() && $commentable->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'このコメントを削除する権限がありません。');
        }

        $comment->delete(); // ソフトデリート

        return redirect()->back()->with('success', 'コメントが削除されました。');
    }

    /**
     * 一括承認（管理者のみ）
     */
    public function bulkApprove(Request $request)
    {
        // 管理者権限チェック
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return redirect()->back()->with('error', '権限がありません。');
        }

        $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:comments,id',
        ]);

        Comment::whereIn('id', $request->comment_ids)->update(['is_approved' => true]);

        return redirect()->back()->with('success', '選択したコメントが承認されました。');
    }

    /**
     * 一括削除（管理者のみ）
     */
    public function bulkDelete(Request $request)
    {
        // 管理者権限チェック
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return redirect()->back()->with('error', '権限がありません。');
        }

        $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:comments,id',
        ]);

        Comment::whereIn('id', $request->comment_ids)->delete(); // ソフトデリート

        return redirect()->back()->with('success', '選択したコメントが削除されました。');
    }
}
