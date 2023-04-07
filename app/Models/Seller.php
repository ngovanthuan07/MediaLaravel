<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'email',
        'bank_account_holder_name',
        'bank_account_number',
        'bank_identifier_code',
        'bank_location',
        'bank_currency',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
