<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'amount',
        'reservation_detail_id',
        'is_wallet'
    ];
}
