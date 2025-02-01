<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    // 問い合わせフォームの表示
    public function showForm()
    {
        return view('inquiry.form');
    }

    // 問い合わせ確認画面の表示
    public function confirm(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|regex:/^[0-9\-]+$/',
            'inquiry_type' => 'required|string',
            'message' => 'required|string|max:1000',
        ]);

        // 確認画面に渡すデータ
        return view('inquiry.confirm', [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'inquiry_type' => $request->input('inquiry_type'),
            'message' => $request->input('message'),
        ]);
    }

    // 問い合わせデータの送信
    public function sendInquiry(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:1000',
        ]);

        // メール送信用データの準備
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'inquiry_message' => $request->input('message'), // 変数名を変更
        ];

        // メール送信
        Mail::send('emails.inquiry', $data, function ($message) use ($data) {
            $message->to('your_admin_email@example.com') // 管理者のメールアドレス
                ->subject('新しいお問い合わせ')
                ->replyTo($data['email']); // 送信者のメールアドレスを設定
        });

        // フラッシュメッセージを設定
        return redirect()->route('inquiry.form')->with('success', 'お問い合わせが送信されました！3営業日以内にご連絡いたします｡');
    }
}
