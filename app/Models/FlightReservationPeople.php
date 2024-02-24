<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightReservationPeople extends Model
{
    use HasFactory;

    public function flight_reservation(){
        return $this->belongsTo(FlightReservation::class);
    }
}
