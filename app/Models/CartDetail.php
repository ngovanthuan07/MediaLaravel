<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'quantity',
        'cart_id',
        'post_id'
    ];

    protected $table = 'carts_details';


    public function cart() {
        return $this->belongsTo(Cart::class);
    }
    public function post() {
        return $this->belongsTo(Post::class);
    }
}
