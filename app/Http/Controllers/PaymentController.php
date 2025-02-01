<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => ['name' => '税理士登録料'],
                    'unit_amount' => $request->amount * 100, // 円単位を変換
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('register') . '?success=true',
            'cancel_url' => route('register') . '?canceled=true',
        ]);

        return response()->json(['id' => $session->id]);
    }
}
