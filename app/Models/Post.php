<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'description',
        'watch',
        'options',
        'public_searchable',
        'show_product_in_live',
        'dangerous_goods',
        'currency',
        'pricing',
        'stock',
        'deleted',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function assets() {
        return $this->hasMany(Asset::class);
    }

    public function hearts() {
        return $this->hasMany(Heart::class);
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }
}
