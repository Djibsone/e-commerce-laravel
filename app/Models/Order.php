<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_intent_id',
        'amount',
        'payment_created_at',
        'products',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
