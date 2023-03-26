<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'uri',
        'type',
        'deleted'
    ];

    public function post() {
        return $this->belongsTo(Post::class);
    }
}
