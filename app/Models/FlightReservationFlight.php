<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightReservationFlight extends Model
{
    use HasFactory;

    public function flight_reservation(){
        return $this->belongsTo(FlightReservation::class);
    }

    public function flight_reservation_flight_addons(){
        return $this->hasMany(FlightReservationFlightAddon::class);
    }

    public function flight_reservation_flight_additional_services(){
        return $this->hasMany(FlightReservationFlightAdditionalService::class);
    }
}
