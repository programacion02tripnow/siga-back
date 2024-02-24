<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservationPaymentDate extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function reservation_payment()
    {
        return $this->belongsTo(ReservationPayment::class);
    }
}
