<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * ユーザーが特定のロールを持っているか確認するミドルウェア
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role  必要なロール（例: admin, tax_advisor）
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        if ($user->role !== $role && $user->role !== 'admin') {
            // 指定されたロールでもadminでもない場合はダッシュボードにリダイレクト
            return redirect()->route('dashboard')
                ->with('error', 'このページにアクセスする権限がありません。');
        }

        return $next($request);
    }
}
