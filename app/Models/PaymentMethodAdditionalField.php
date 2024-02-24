<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethodAdditionalField extends Model
{
    use HasFactory, SoftDeletes;
    protected $casts = [
        'is_required' => 'boolean',
    ];

    public function payment_method(){
        return $this->belongsTo(PaymentMethod::class);
    }

    public function reservation_payment_additional_values(){
        return $this->hasMany(ReservationPaymentAdditionalValue::class);
    }
}
