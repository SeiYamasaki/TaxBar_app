<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TaxAdvisor;
use App\Models\Company;
use App\Models\Individual;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;

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

    /**
     * 税理士ユーザー登録処理
     */
    public function registerTaxExpert(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'office_name' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:10'],
            'prefecture' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'office_phone' => ['required', 'string', 'max:20'],
            'mobile_phone' => ['nullable', 'string', 'max:20'],
            'specialty' => ['nullable', 'string', 'max:255'],
        ]);

        // ユーザー作成
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'tax_advisor',
        ]);

        // 税理士情報作成
        TaxAdvisor::create([
            'user_id' => $user->id,
            'office_name' => $request->office_name,
            'postal_code' => $request->postal_code,
            'prefecture' => $request->prefecture,
            'address' => $request->address,
            'office_phone' => $request->office_phone,
            'mobile_phone' => $request->mobile_phone,
            'specialty' => $request->specialty,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', '税理士アカウントが登録されました！');
    }

    /**
     * 企業ユーザー登録処理
     */
    public function registerCompany(Request $request)
    {
        $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'registration_number' => ['nullable', 'string', 'max:15'],
            'address' => ['required', 'string', 'max:255'],
            'contact_info' => ['required', 'string', 'max:255'],
        ]);

        // ユーザー作成
        $user = User::create([
            'name' => $request->company_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'company',
        ]);

        // 企業情報作成
        Company::create([
            'user_id' => $user->id,
            'company_name' => $request->company_name,
            'registration_number' => $request->registration_number,
            'address' => $request->address,
            'contact_info' => $request->contact_info,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', '企業アカウントが登録されました！');
    }

    /**
     * 個人ユーザー登録処理
     */
    public function registerIndividual(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'in:male,female,other'],
            'address' => ['nullable', 'string', 'max:255'],
            'contact_info' => ['nullable', 'string', 'max:255'],
        ]);

        // ユーザー作成
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'individual',
        ]);

        // 個人情報作成
        Individual::create([
            'user_id' => $user->id,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'contact_info' => $request->contact_info,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', '個人アカウントが登録されました！');
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
