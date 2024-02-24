<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationPaymentAdditionalValue extends Model
{
    use HasFactory;

    public function reservation_payment(){
        return $this->belongsTo(ReservationPayment::class);
    }

    public function payment_method_additional_field(){
        return $this->belongsTo(PaymentMethodAdditionalField::class);
    }
}
