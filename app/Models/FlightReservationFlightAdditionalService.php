<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightReservationFlightAdditionalService extends Model
{
    use HasFactory;

    public function flight_reservation_flight(){
        return $this->belongsTo(FlightReservationFlight::class);
    }
}
