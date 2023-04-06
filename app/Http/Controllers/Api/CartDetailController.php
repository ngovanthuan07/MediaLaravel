<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartDetailController extends Controller
{
    public function showAllCartDetail(){
        try {
            $userId = Auth::user()->id;

            $cart = Cart::query()
                ->where('user_id', $userId)
                ->where('status', 'CART')
                ->first();

            $cardDetails = CartDetail::query()
                ->where('cart_id', $cart->id)
                ->get();

            foreach($cardDetails as $cardDetail) {
                $product = Product::query()->where('id', $cardDetail['product_id'])->first();
                $cardDetail['product'] = $product;
            }



            return response()->json([
                'card_details' => $cardDetails,
                'status' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'card_details' => [],
                'status' => false,
                'error' => $e
            ], 404);
        }
    }

    public function removeCartDetail(Request $request) {
        $cartDetail = CartDetail::query()->where('id', $request->input('id'));
        $cartDetail->delete();

        return response()->json([
            'status' => true
        ]);
    }
}
