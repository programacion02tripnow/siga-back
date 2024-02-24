<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Refund extends Model
{
    use HasFactory, SoftDeletes;

    public function reservation_detail(){
        return $this->belongsTo(ReservationDetail::class);
    }

    public function reservation(){
        return $this->belongsTo(Reservation::class);
    }
}
