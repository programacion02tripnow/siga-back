<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationDetailAge extends Model
{
    use HasFactory;

    public function reservation_detail(){
        return $this->belongsTo(ReservationDetail::class);
    }
}
