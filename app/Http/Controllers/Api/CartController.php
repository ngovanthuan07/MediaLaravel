<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function deleteAllItemCartDetail() {
        $userId = Auth::user()->id;

        $cart = Cart::query()
            ->where('user_id', $userId)
            ->where('status', 'CART')
            ->first();
        CartDetail::where('cart_id', $cart->id)->delete();

    }
    public function cart(Request $request) {
        $postId = $request->input('post_id');
        $userId = Auth::user()->id;
        $quantity= $request->input('quantity');

        // kiem tra gio hang da tao chua
        $checkCart = Cart::query()
            ->where('user_id', $userId)
            ->where('status', 'CART')->exists();
        if(!$checkCart) {
            Cart::create([
                'user_id' => $userId,
                'status' => 'CART'
            ])->save();
        }

        // lay gio hang
        $cart = Cart::query()
            ->where('user_id', $userId)
            ->where('status', 'CART')
            ->first();

        // kiem tra product co trong gio hang khong neu khong co thi tao
        $checkCartDetail = CartDetail::query()
            ->join('carts', 'carts_details.cart_id', '=', 'carts.id')
            ->join('posts', 'carts_details.post_id', '=', 'posts.id')
            ->where('cart_id', $cart->id)
            ->where('post_id', $postId)
            ->exists();

        if(!$checkCartDetail) {
            CartDetail::create([
                'cart_id' => $cart->id,
                'post_id' => $postId,
                'quantity' => 0,
                'total' => 0
            ])->save();
        }

        $cartDetail = CartDetail::query()
            ->where('cart_id', $cart->id)
            ->where('post_id', $postId)
            ->first();
        $post = Post::query()->where('id', $postId)->first();

        if ($cartDetail->quantity + $quantity >= $post['quantity']) {
            return response()->json([
                'message' => 'The quantity of products in the cart has exceeded the available quantity in stock',
                'status' => false
            ], 200);
        }

        if($quantity == 0) {
            $cartDetail->delete();
            return response()->json([
                'message' => 'Oke',
                'status' => true
            ]);
        }

        $cartDetail->update([
            'quantity' => $cartDetail->quantity + $quantity,
            'total' => ($cartDetail->quantity + $quantity) * $post['pricing']
        ]);
        return response()->json([
            'message' => 'Oke',
            'status' => true
        ]);
    }
}
