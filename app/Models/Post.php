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
        'views',
        'choose',
        'deleted',
        'user_id',
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

    public function room_details() {
        return $this->hasMany(RoomDetail::class);
    }
}
