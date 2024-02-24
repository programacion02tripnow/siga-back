<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservationPayment extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function reservation(){
        return $this->belongsTo(Reservation::class);
    }

    public function payment_method(){
        return $this->belongsTo(PaymentMethod::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function cancelled_by(){
        return $this->belongsTo(User::class, 'cancelled_by_id');
    }

    public function reservation_payment_additional_values(){
        return $this->hasMany(ReservationPaymentAdditionalValue::class);
    }
}
