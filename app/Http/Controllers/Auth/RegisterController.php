<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showTaxExpertRegister()
    {
        return view('auth.register_tax_expert');
    }

    public function showCompanyRegister()
    {
        return view('auth.register_company');
    }

    public function showIndividualRegister()
    {
        return view('auth.register_individual');
    }

    public function register(Request $request)
{
    if ($request->query('success')) {
        // ここでユーザーをデータベースに登録
        return redirect()->route('dashboard')->with('success', '登録が完了しました！');
    }

    if ($request->query('canceled')) {
        return back()->with('error', '決済がキャンセルされました。');
    }

    return view('auth.register_tax_expert');
}

}
