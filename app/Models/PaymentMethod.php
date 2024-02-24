<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use HasFactory, SoftDeletes;
    protected $casts = [
        'requires_auth' => 'boolean',
    ];

    public static $permissions = [
        'view' => 'VIEW_PAYMENT_METHOD',
        'create' => 'CREATE_PAYMENT_METHOD',
        'edit' => 'EDIT_PAYMENT_METHOD',
        'delete' => 'DELETE_PAYMENT_METHOD',
    ];

    public function payment_method_additional_fields(){
        return $this->hasMany(PaymentMethodAdditionalField::class);
    }

    public function reservation_payments(){
        return $this->hasMany(ReservationPayment::class);
    }

    public function multimedia(){
        return $this->belongsTo(Multimedia::class);
    }
}
