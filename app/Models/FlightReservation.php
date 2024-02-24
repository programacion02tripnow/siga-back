<?php

namespace App\Models;

use App\Strategies\FlightReservationStrategy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightReservation extends Model
{
    use HasFactory;

    protected $casts = [
        'round' => 'boolean',
        'is_pack' => 'boolean',
    ];

    public static $strategy = FlightReservationStrategy::class;


    public function reservation_details()
    {
        return $this->morphMany(ReservationDetail::class, 'reservable');
    }

    public function flight_reservation_people()
    {
        return $this->hasMany(FlightReservationPeople::class);
    }

    public function flight_reservation_flights()
    {
        return $this->hasMany(FlightReservationFlight::class);
    }

    public function loadRelations()
    {
        $this->flight_reservation_people;
        $this->flight_reservation_flights = $this->flight_reservation_flights()->with(['flight_reservation_flight_addons', 'flight_reservation_flight_additional_services'])->get();
    }
}
