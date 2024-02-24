<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    public static $permissions = [
        'view' => 'VIEW_CUSTOMER',
        'create' => 'CREATE_CUSTOMER',
        'edit' => 'EDIT_CUSTOMER',
        'delete' => 'DELETE_CUSTOMER',
    ];

    protected $fillable = [
        'wallet'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function customer_phones(){
        return $this->hasMany(CustomerPhone::class);
    }

    public function customer_comments(){
        return $this->hasMany(CustomerComment::class);
    }

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }

    public function customer_wallets(){
        return $this->hasMany(CustomerWallet::class);
    }
}
