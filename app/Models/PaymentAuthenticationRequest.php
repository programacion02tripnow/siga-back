<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentAuthenticationRequest extends Model
{
    use HasFactory;
    protected $casts = [
        'used' => 'boolean',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function authorizing_user(){
        return $this->belongsTo(User::class, 'authorizing_user_id');
    }
}
