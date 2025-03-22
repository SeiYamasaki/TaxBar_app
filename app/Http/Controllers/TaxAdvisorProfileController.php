<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\TaxAdvisor;
use App\Models\User;
use App\Models\TaxMinutesVideo;
use App\Models\Theme;

class TaxAdvisorProfileController extends Controller
{
    /**
     * 税理士プロフィール詳細ページを表示
     */
    public function show($id)
    {
        // 税理士IDから税理士を検索
        $taxAdvisor = TaxAdvisor::findOrFail($id);
        $user = $taxAdvisor->user;

        if (!$user || $user->role !== 'tax_advisor') {
            abort(404, '税理士情報が見つかりませんでした。');
        }

        // 税理士が投稿した動画を取得
        $videos = TaxMinutesVideo::where('user_id', $user->id)
            ->latest()
            ->take(6)
            ->get();

        // 選択されたテーマを取得
        $selectedThemes = $taxAdvisor->specialtyThemes;

        return view('tax_advisor.profile.show', compact('user', 'taxAdvisor', 'videos', 'selectedThemes'));
    }

    /**
     * 税理士プロフィール編集画面を表示
     */
    public function edit()
    {
        $user = Auth::user();

        // 税理士ユーザーでない場合はダッシュボードにリダイレクト
        if ($user->role !== 'tax_advisor' && $user->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', '税理士ユーザーのみアクセスできます。');
        }

        $taxAdvisor = $user->taxAdvisor;

        // 全テーマを取得
        $themes = Theme::where('is_active', true)->orderBy('title')->get();

        // 現在選択されているテーマのIDを取得
        $selectedThemeIds = $taxAdvisor->specialtyThemes->pluck('id')->toArray();

        return view('tax_advisor.profile.edit', compact('user', 'taxAdvisor', 'themes', 'selectedThemeIds'));
    }

    /**
     * 税理士プロフィールを更新
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // 税理士ユーザーでない場合はダッシュボードにリダイレクト
        if ($user->role !== 'tax_advisor' && $user->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', '税理士ユーザーのみアクセスできます。');
        }

        $taxAdvisor = $user->taxAdvisor;

        // バリデーション
        $request->validate([
            'office_name' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'prefecture' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'office_phone' => 'required|string|max:20',
            'mobile_phone' => 'nullable|string|max:20',
            'specialty' => 'nullable|string|max:255',
            'theme_ids' => 'nullable|array',
            'theme_ids.*' => 'exists:themes,id',
            'profile_info' => 'nullable|string',
            'tax_accountant_photo' => 'nullable|image|max:5120', // 5MB
            'tax_minutes_icon' => 'nullable|image|max:5120', // 5MB
        ]);

        // 基本情報の更新
        $taxAdvisor->office_name = $request->office_name;
        $taxAdvisor->postal_code = $request->postal_code;
        $taxAdvisor->prefecture = $request->prefecture;
        $taxAdvisor->address = $request->address;
        $taxAdvisor->office_phone = $request->office_phone;
        $taxAdvisor->mobile_phone = $request->mobile_phone;
        $taxAdvisor->specialty = $request->specialty;
        $taxAdvisor->profile_info = $request->profile_info;

        // 税理士写真のアップロード処理
        if ($request->hasFile('tax_accountant_photo')) {
            // 古い写真があれば削除
            if ($taxAdvisor->tax_accountant_photo) {
                Storage::disk('public')->delete($taxAdvisor->tax_accountant_photo);
            }

            // 新しい写真をアップロード
            $taxAdvisor->tax_accountant_photo = $request->file('tax_accountant_photo')->store('tax_advisor_photos', 'public');
        }

        // TaxMinutes用アイコンのアップロード処理
        if ($request->hasFile('tax_minutes_icon')) {
            // 古いアイコンがあれば削除
            if ($taxAdvisor->tax_minutes_icon) {
                Storage::disk('public')->delete($taxAdvisor->tax_minutes_icon);
            }

            // 新しいアイコンをアップロード
            $taxAdvisor->tax_minutes_icon = $request->file('tax_minutes_icon')->store('tax_minutes_icons', 'public');
        }

        $taxAdvisor->save();

        // テーマの関連付けを更新
        if ($request->has('theme_ids')) {
            $taxAdvisor->specialtyThemes()->sync($request->theme_ids);
        } else {
            $taxAdvisor->specialtyThemes()->detach();
        }

        return redirect()->route('dashboard')->with('success', 'プロフィールが更新されました');
    }
}
