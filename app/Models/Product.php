<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'image',
        'description',
        'public_searchable',
        'show_product_in_live',
        'dangerous_goods',
        'currency',
        'pricing',
        'discount',
        'quantity',
        'stock',
        'choose',
        'views',
        'deleted',
        'user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function cart_details() {
        return $this->hasMany(CartDetail::class);
    }
}
