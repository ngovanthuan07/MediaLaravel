<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function payment(Request $request) {
        $user = Auth::user();
        $total = $request->input('total');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $email = $request->input('email');

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        // Use an existing Customer ID if this is a returning customer.

        $customer = $stripe->customers->create([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $phone,
        ]);

        $ephemeralKey = $stripe->ephemeralKeys->create([
            'customer' => $customer->id,
        ], [
            'stripe_version' => '2022-08-01',
        ]);
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $total,
            'currency' => 'usd',
            'customer' => $customer->id,
            'automatic_payment_methods' => [
                'enabled' => 'true',
            ],
        ]);

        $cart = Cart::query()
            ->where('user_id', $user->id)
            ->where('status', 'CART')
            ->first();
        $cart->total = $total;
        $cart->address = $address;
        $cart->phone = $phone;
        $cart->email = $email;
        $cart->update();

        return response()->json(
            [
                'paymentIntent' => $paymentIntent->client_secret,
                'ephemeralKey' => $ephemeralKey->secret,
                'customer' => $customer->id,
                'secretKey' => env('STRIPE_SECRET_KEY'),
                'publishableKey' => env('STRIPE_KEY')
            ]
        );
    }

    public function success() {
        try {
            $userId = Auth::user()->id;

            $cart = Cart::query()
                ->where('user_id', $userId)
                ->where('status', 'CART')
                ->first();
            $cart->status = 'PAY';
            $cart->update();

            return response()->json([
                'success' => true,
                'cart' => $cart
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e,
                'success' => false,
            ], 401);
        }
    }
}
