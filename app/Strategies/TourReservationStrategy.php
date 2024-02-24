<?php

namespace App\Strategies;

use App\Models\TourReservation;

class TourReservationStrategy implements ReservationDetailStrategy
{

    public function execute($reservation_detail){
        $params = $reservation_detail['reservable'];
        $tour_reservation = new TourReservation();
        $tour_reservation->destination = $params['destination'];
        $tour_reservation->tour_name = $params['tour_name'];
        $tour_reservation->package_name = $params['package_name'];
        $tour_reservation->date = $params['date'];
        $tour_reservation->adults_quantity = $params['adults_quantity'] ?? 0;
        $tour_reservation->minors_quantity = $params['minors_quantity'] ?? 0;
        $tour_reservation->description = $params['description'];
        $tour_reservation->save();

        return $tour_reservation;
    }
}
