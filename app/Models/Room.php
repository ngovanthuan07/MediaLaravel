<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'image'
    ];

    public function members() {
        return $this->hasMany(Member::class);
    }

    public function room_details() {
        return $this->hasMany(RoomDetail::class);
    }
}
