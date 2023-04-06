<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function addProduct(Request $request) {
        $product = new Product;
        $product->fill($request->only([
            'name',
            'category',
            'description',
            'image',
            'public_searchable',
            'dangerous_goods',
            'currency',
            'pricing',
            'discount',
            'quantity',
            'stock',
            'views',
            'choose'
        ]));
        $product->user_id = Auth::user()->id; // thêm dòng này để gán giá trị cho trường user_id
        $product->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function show_product_by_id(Request $request) {
        $product = Product::where('id', $request['id'])->first();

        return response()->json([
            'product' => $product,
            'success' => true
        ]);
    }

}
